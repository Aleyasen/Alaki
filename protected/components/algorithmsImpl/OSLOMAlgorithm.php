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
class OSLOMAlgorithm extends ClusteringAlgorithm {

    protected $algType;

    public function __construct($user) {
        parent::__construct($user);
        $this->alg_abbr = 'oslom';
        $this->alg_obj = Algorithm::model()->findByPK('5');
    }

    /*  public function getInputFile() {
      return $this->proj_path . 'algorithms/data/' . $this->user->fbid . '-' . $this->date . '-' . $this->alg_abbr;
      } */

    public function getOutputFile() {
        return $this->getInputFileLocation() . '_oslo_files/tp';
    }

    //***********************Windows************************

    public function getExecCommandInWindows() {

        //  ./oslom_undir -f example.dat -uw

        $alg_loc = '"' . $this->proj_path . 'algorithms/OSLOM/oslom_undir.exe';
        $cmd = $alg_loc . ' -f ' . $this->getInputFileLocation() . ' -uw';
        $cmd = $this->cygwin_cmd . $cmd;
        return $cmd;
    }

    //***********************Linux************************

    public function getExecCommandInLinux() {

        //  ./oslom_undir -f example.dat -uw
        $alg_loc = $this->proj_path . 'algorithms/OSLOM/oslom_undir';
        $cmd = $alg_loc . ' -f ' . $this->getInputFileLocation() . ' -uw';
        return $cmd;
    }

    public function execute($edges, $friendNames) {

        $this->initialize($edges);

        $out = shell_exec($this->getExecCommand() . ' 2>&1');
        Yii::log($this->getExecCommand());
        Yii::log($out);

        //*******************Read Output File***************    

        $handle_out = fopen($this->getOutputFile(), 'r') or die('Cannot open file:  ' . $this->getOutputFile());

        $clustering = new Clustering;
        $clustering->algorithm = $this->alg_obj->id;
        $clustering->score = 5;
        $clustering->user = $this->user->id;

        $run = $clustering->save();
        if (!$run) {
            print_r($clustering->getErrors());
        }

        $clus_ind = 1;
        $clusObj = null;
        $fbid_set = array();

        //initialize unknown cluster
        $unknownClus = new Cluster;
        $unknownClus->name = self::$default_unknown_name;
        $unknownClus->clustering = $clustering->id;
        $unknownClus->save();
        //end of initialize unknown cluster

        while (!feof($handle_out)) {

            $line = fgets($handle_out);

            if (strstr($line, '#')) {
                continue;
            }
            $line = trim($line); // to remove space at the end of line
            $linearr = explode(" ", $line);

            if (strlen($linearr[0]) == 0) { // last line is empty, so file is finished!
                //   echo "empty line </br>";
                break;
            }

            //$linearr[sizeof($linearr) - 1] = substr($linearr[sizeof($linearr) - 1], 0, -1);
            //echo sizeof($linearr).'</br>';
            //adding unknown friends to unknownClus        

            if (sizeof($linearr) <= self::$unknown_threshold) {
                for ($it = 0; $it < sizeof($linearr); $it++) {
                    $fri = new Friend;

//                    $relatedData = array(
//                        'clusters' => array($unknownClus->id),
//                        'corClusters' => array($unknownClus->id),
//                    );
                    //$fri->cluster = $unknownClus->id;
                    //$fri->cor_cluster = $unknownClus->id;
                    $fri->user = $this->user->id;
                    // echo "unknown " . $unknownClus->id . " " . $it . " " . $linearr[intval($it)] . " " . $this->rev_arr[$linearr[intval($it)]] . "<br>";
                    if (isset($this->rev_arr[$linearr[intval($it)]])) {
                        //   echo "set!<br>";
                        $fri->fbid = $this->rev_arr[$linearr[intval($it)]];
                        if (isset($friendNames[$fri->fbid]))
                            $fri->name = $friendNames[$fri->fbid];
                    } else {
                        //uncomment this for debug!                   
                        //echo 'not-set: ' . $it . ' ' . $linearr[intval($it)] . '<br/>';
                        //$fri->fbid = '000000';
                        continue;
                    }

//                    $run = $fri->saveWithRelated($relatedData);
                    //$tempfriend = Friend::model()->find('fbid=:fbid and user=:user ', array(':fbid' => $fri->fbid, ':user' => $fri->user));
                    //if (!isset($tempfriend))
//                        $fri->save();
//                    else
//                        $fri = $tempfriend;
                    if (!isset($fbid_set[$fri->fbid])) {
                        $fri->save();
                    } else {
                        $fri = Friend::model()->findByPK($fbid_set[$fri->fbid]);
                    }
                    $fri->addRelationRecords('clusters', array($unknownClus->id), array('cor_cluster' => $unknownClus->id));
                    $fbid_set[$fri->fbid] = $fri->id;
                    if (!$run) {
                        print_r($fri->getErrors());
                    }
                }
                //end of adding unknown friends to unknownClus
            } else {
                $clusObj = new Cluster;
                $clusObj->name = self::$default_clus_name . $clus_ind;
                $clusObj->clustering = $clustering->id;
                $clusObj->save();
                // $clusList[] = $clusObj;
                $clus_ind++;
                for ($it = 0; $it < sizeof($linearr); $it++) {
                    $fri = new Friend;
//                    $relatedData = array(
//                        'clusters' => array($clusObj->id),
//                        'corClusters' => array($clusObj->id),
//                    );
                    //$fri->cluster = $clusObj->id;
                    //$fri->cor_cluster = $clusObj->id;
                    $fri->user = $this->user->id;
                    if (isset($this->rev_arr[$linearr[$it]])) {
                        $fri->fbid = $this->rev_arr[$linearr[$it]];
                        if (isset($friendNames[$fri->fbid]))
                            $fri->name = $friendNames[$fri->fbid];
                    } else {
                        //uncomment this for debug!                   
                        //echo 'not-set: ' . $it . ' ' . $linearr[$it] . '<br/>';
                        //$fri->fbid = '000000';
                        continue;
                    }

//                    $run = $fri->saveWithRelated($relatedData);
//                    $tempfriend = Friend::model()->find('fbid=:fbid and user=:user', array(':fbid' => $fri->fbid, ':user' => $fri->user));
//                    if (!isset($tempfriend))
//                        $fri->save();
//                    else
//                        $fri = $tempfriend;
                    if (!isset($fbid_set[$fri->fbid])) {
                        $fri->save();
                    } else {
                        $fri = Friend::model()->findByPK($fbid_set[$fri->fbid]);
                    }
                    $fri->addRelationRecords('clusters', array($clusObj->id), array('cor_cluster' => $clusObj->id));
                    $fbid_set[$fri->fbid] = $fri->id;
                    if (!$run) {
                        print_r($fri->getErrors());
                    }
                }
            }
        }

        fclose($handle_out);
        chmod($this->getOutputFile(), 0777);

        $unknownClus->clustering = $clustering->id;
        $unknownClus->save();
        $this->takeUnknownToLast($clustering, $unknownClus);
        if ($clustering->save()) {
            //    print_r('success save clus');
        } else {
            print_r($clustering->getErrors());
        }
        return $this->user; //no Need to return
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
