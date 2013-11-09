<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lovain
 *
 * @author Moti:P
 */
class LouvainAlgorithm extends ClusteringAlgorithm {

    protected $algType;

    public function __construct($user) {
        parent::__construct($user);
        $this->alg_abbr = 'louvain';
        $this->alg_obj = Algorithm::model()->findByPK('4');
    }

    //***********************Windows************************

    public function getExecCommandInWindows() {

        // 1- ./convert -i graph.txt -o graph.bin
        // 2- ./community graph.bin -l -1 > graph.tree
        // 3- ./hierarchy graph.tree

        $prefix1 = '"' . $this->proj_path . 'algorithms/Louvain/convert.exe ';
        $prefix2 = $this->proj_path . 'algorithms/Louvain/community.exe ';
        $prefix3 = $this->proj_path . 'algorithms/Louvain/hierarchy.exe ';

        $cmd1 = $prefix1 . ' -i ' . $this->getInputFileLocation() . ' -o ' . $this->getInputFileName() . '.bin';
        $cmd2 = $prefix2 . $this->getInputFileName() . '.bin' . ' -l -1 > ' . $this->getOutputFileName() . '.tree';
        $cmd3 = $prefix3 . $this->getOutputFileName() . '.tree' . '>' . $this->getOutputFileName() . '.hier';

        $cmd = $this->cygwin_cmd . $cmd1 . ';' . $cmd2 . ';' . $cmd3;
        return $cmd;
    }

    //***********************Linux************************

    public function getExecCommandInLinux() {
        // 1- ./convert -i graph.txt -o graph.bin
        // 2- ./community graph.bin -l -1 > graph.tree
        // 3- ./hierarchy graph.tree


        $prefix1 = $this->proj_path . 'algorithms/Louvain/convert ';
        $prefix2 = $this->proj_path . 'algorithms/Louvain/community ';
        $prefix3 = $this->proj_path . 'algorithms/Louvain/hierarchy ';

        $cmd1 = $prefix1 . ' -i ' . $this->getInputFileLocation() . ' -o ' . $this->getInputFileName() . '.bin';
        $cmd_permission = 'chmod 775 ' . $this->getInputFileName() . '.bin';
        $cmd2 = $prefix2 . $this->getInputFileName() . '.bin' . ' -l -1 > ' . $this->getOutputFileName() . '.tree';
        $cmd3 = $prefix3 . $this->getOutputFileName() . '.tree' . '>' . $this->getOutputFileName() . '.hier';

        $cmd = $cmd1 . '&&' . $cmd_permission . '&&' . $cmd2 . '&&' . $cmd3;
        return $cmd;
    }

    //TODO: just goes through 2 level of hierarcharies to avoid getting confused!
    public function execute($edges, $friendNames) {

        $this->initialize($edges);

        $out = shell_exec($this->getExecCommand() . ' 2>&1');
        Yii::log($this->getExecCommand());
        Yii::log($out);

        //*******************Read Hier File***************
        $handle_hier = fopen($this->getOutputFileName() . '.hier', 'r') or die('Cannot open file:  ' . $this->getOutputFileName() . '.hier');

        $line = fgets($handle_hier);
        $num_of_hiers = implode(',', $this->extract_numbers($line)); // I do not use it further!:D

        $hier = array();

        while (!feof($handle_hier)) {
            $line = fgets($handle_hier);
            $hier[] = $this->extract_numbers($line); // hier[][1]-> the number of clusters in each level
        }


        //*******************Read Tree File (Final Output)***************        
        $handle_out = fopen($this->getOutputFileName() . '.tree', 'r') or die('Cannot open file:  ' . $this->getOutputFileName() . '.tree');
        $clustering = new Clustering;
        $clustering->algorithm = $this->alg_obj->id;
        $clustering->score = 5;
        $clustering->user = $this->user->id;

        $run = $clustering->save();

        if (!$run) {
            print_r($clustering->getErrors());
        }

        $cluster_object = null;
        $friend_id = null;
        $cluster_id = null;

        //initialize unknown cluster
        $unknownClus = new Cluster;
        $unknownClus->name = self::$default_unknown_name;
        $unknownClus->clustering = $clustering->id;
        $unknownClus->save();
        //end of initialize unknown cluster

        $clusters_array = array();
        $clusters_id_map = array(); // A map between clusters DB id and the current id here!

        for ($n = 0; $n < $hier[0][1]; $n++) { // the number of lines that should be for first level = number of friends
            $line = fgets($handle_out);
            $line_array = explode(" ", $line);
            // print_r($line_array);
            $friend_id = $line_array[0];
            $cluster_id = $line_array[1];
            //  echo 'friend_id '.$friend_id. ': cluster_id '.$cluster_id.'</br>';
            // list($friend_id, $cluster_id) = $line_array;
            $clusters_array[intval($cluster_id)][] = $friend_id;
        }

        $clus_ind_name = 1;
        // ********* Level 0 to DB ********

        for ($it = 0; $it < $hier[1][1]; $it++) { // Number of Communities in Level 0 = $hier[1][1]
            if (sizeof($clusters_array[$it]) <= self::$unknown_threshold) {
                for ($i = 0; $i < sizeof($clusters_array[$it]); $i++) {
                    $friend = new Friend;
//                    $relatedData = array(
//                        'clusters' => array($unknownClus->id),
//                        'corClusters' => array($unknownClus->id),
//                    );
                    // $friend->cluster = $unknownClus->id;
                    //  $friend->cor_cluster = $unknownClus->id;
                    $friend->user = $this->user->id;
                    $friend->fbid = $this->rev_arr[$clusters_array[$it][$i]];
                    if (isset($friendNames[$friend->fbid]))
                        $friend->name = $friendNames[$friend->fbid];
//                  
//                    $run = $friend->saveWithRelated($relatedData);
                    $friend->save();
                    $friend->setRelationRecords('clusters', array($unknownClus->id), array('cor_cluster' => $unknownClus->id));

                    if (!$run) {
                        print_r($friend->getErrors());
                    }
                }
            } else {
                $cluster_object = new Cluster;
                $cluster_object->name = self::$default_clus_name . ($clus_ind_name);
                $cluster_object->level = 0;
                $clus_ind_name++;
                $cluster_object->clustering = $clustering->id;
                $cluster_object->save();
                $clusters_id_map[$it] = $cluster_object->getPrimaryKey();
                /* echo $it . ' ';
                  print_r($clusters_id_map[$it]);
                  echo '</br>'; */
                for ($i = 0; $i < sizeof($clusters_array[$it]); $i++) {
                    $friend = new Friend;
//                    $relatedData = array(
//                        'clusters' => array($cluster_object->id),
//                        'corClusters' => array($cluster_object->id),
//                    );
                    // $friend->cluster = $cluster_object->id;
                    // $friend->cor_cluster = $cluster_object->id;
                    $friend->user = $this->user->id;
                    $friend->fbid = $this->rev_arr[$clusters_array[$it][$i]];
                    if (isset($friendNames[$friend->fbid]))
                        $friend->name = $friendNames[$friend->fbid];
//                  
//                    $run = $friend->saveWithRelated($relatedData);
                    $friend->save();
                    $friend->setRelationRecords('clusters', array($cluster_object->id), array('cor_cluster' => $cluster_object->id));

                    if (!$run) {
                        print_r($friend->getErrors());
                    }
                }
            }
        }


        $sup_cluster_id = null;
        $offset1 = 0;
        $offset2 = 0;

        //  for ($x = 1; $x < $num_of_hiers - 1; $x++) { // $x = level, the last level is reapetetive
        for ($x = 1; $x < 2; $x++) { // Just Read one level more!
            //  echo 'level ' . $x . '</br>';
            $offset1 = $offset1 + $offset2;
            $offset2 = $offset2 + $hier[$x][1];

            if (isset($hier[$x][1])) { // To avoid the empty line
                $clus_ind_name = 1;
                for ($n = 0; $n < $hier[$x][1]; $n++) { // the number of lines that should be read
                    $line = fgets($handle_out);
                    $line_array = explode(" ", $line);

                    // Convert community ids to unique ids
                    $cluster_id = $line_array[0] + $offset1;
                    $sup_cluster_id = $line_array[1] + $offset2;

                    // Save Super cluster in DB
                    if (!isset($clusters_id_map[$sup_cluster_id])) {
                        $sup_cluster_object = new Cluster;
                        $sup_cluster_object->name = self::$default_clus_name . ($clus_ind_name) . ' level ' . ($x);
                        $sup_cluster_object->level = $x;
                        $clus_ind_name++;
                        $sup_cluster_object->clustering = $clustering->id;
                        $sup_cluster_object->save();
                        $clusters_id_map[$sup_cluster_id] = $sup_cluster_object->getPrimaryKey();
                    }
                    /*   echo $cluster_id . ' ';
                      //if (isset($clusters_id_map[$cluster_id]))
                      print_r($clusters_id_map[$cluster_id]);
                      echo '</br>'; */

                    // Set super cluster of current cluster
                    $cluster_object = Cluster::model()->findByPK($clusters_id_map[$cluster_id]);
                    $cluster_object->sup_cluster = $clusters_id_map[$sup_cluster_id];
                    $cluster_object->save();
                    /* echo 'super '.$cluster_object->id.': ';
                      echo $cluster_object->sup_cluster;
                      echo '</br>'; */
                }
            }
        }

        fclose($handle_out);
        chmod($this->getOutputFileName() . '.hier', 0777);
        chmod($this->getOutputFileName() . '.tree', 0777);

        $this->takeUnknownToLast($clustering, $unknownClus);
        $run = $clustering->save();
        if (!$run) {
            print_r($clustering->getErrors());
        }
        // echo "Done" . "</br>";
        return $this->user;
    }

    public function varDumpToString($var) {
        ob_start();
        var_dump($var);
        $result = ob_get_clean();
        return $result;
    }

    public function extract_numbers($string) {
        preg_match_all('/([\d]+)/', $string, $match);
        return $match[0];
    }

    //  *********** For the version of Louvain that just gives the lowest hierarchy (Louvain_20110526)************


    /*   public function initialize($edges) {

      //***********************Final Format**************************
      // >
      //<node_id> <node_name>
      // >
      //<slice_id> <slice_name>
      //>
      //<from_node> <to_node> <weight> <slice_id>
      //***************************************************************
      //**************************Map File*****************************
      //direct-reverse arrays implementation
      $ind = 0;
      $this->dir_arr = array();
      $this->rev_arr = array();
      foreach ($edges as $e) {
      if (!isset($this->dir_arr[$e['uid1']])) {
      $this->dir_arr[$e['uid1']] = $ind;
      $this->rev_arr[$ind] = $e['uid1'];
      $ind++;
      }
      if (!isset($this->dir_arr[$e['uid2']])) {
      $this->dir_arr[$e['uid2']] = $ind;
      $this->rev_arr[$ind] = $e['uid2'];
      $ind++;
      }
      }

      $handle_map = fopen($this->getMapFileLocation(), 'w') or die('Cannot open file:  ' . $this->getMapFileLocation());
      for ($i = 0; $i < sizeof($this->rev_arr); $i++)
      fwrite($handle_map, $i . "\t" . $this->rev_arr[$i] . PHP_EOL);
      fclose($handle_map);
      if (!chmod($this->getMapFileLocation(), 0777))
      echo "can not chmod " . $this->getMapFileLocation();

      //*******************************Input File********************************

      $handle_in = fopen($this->getInputFileLocation(), 'w') or die('Cannot open file:  ' . $this->getInputFileLocation());

      //******************Construct the 1st part of the input file: <>
      //   >
      //<node_id> <node_name>
      // >

      $session = Yii::app()->session;
      $friendends = $session->itemAt($friendends);

      fwrite($handle_in, ">" . PHP_EOL);
      for ($i = 0; $i < sizeof($friendends); $i++) {
      fwrite($handle_in, $i . " " . $i . PHP_EOL);
      }
      fwrite($handle_in, ">" . PHP_EOL);

      foreach ($edges as $e) {
      $data = $this->dir_arr[$e['uid1']] . ' ' . $this->dir_arr[$e['uid2']] . PHP_EOL . $this->dir_arr[$e['uid2']] . ' ' . $this->dir_arr[$e['uid1']] . PHP_EOL;
      fwrite($handle_in, $data);
      }
      fclose($handle_in);

      if (!chmod($this->getInputFileLocation(), 0777))
      echo "can not chmod " . $this->getInputFileLocation();
      }
     */
}

?>
