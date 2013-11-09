<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CNMAlgorithm
 *
 * @author Aale
 */
class NewmanAlgorithm extends ClusteringAlgorithm {

    protected $algType;

    public function __construct($user, $type, $abbr) {
        parent::__construct($user);
        $this->algType = $type;
        $this->alg_abbr = $abbr;
        $this->alg_obj = Algorithm::model()->findByPK('3');
    }

    public function getExecCommandInWindows() {
        $alg_loc = $this->proj_path . 'algorithms/Newman/newman';
        $cmd = '"' . $alg_loc . ' -i:' . $this->getInputFileLocation() . ' -a:' . $this->algType . ' -o:' . $this->getOutputFileLocation() . '"';
        $cmd = 'G:\cygwin\bin\bash.exe --login -c ' . $cmd;
        return $cmd;
    }

    public function getExecCommandInLinux() {
        $alg_loc = $this->proj_path . 'algorithms/Newman/newman';
        $cmd = $alg_loc . ' -i:' . $this->getInputFileLocation() . ' -a:' . $this->algType . ' -o:' . $this->getOutputFileLocation();
        return $cmd;
    }

    public function execute($edges, $friendNames) {
        $this->initialize($edges);
        $out = shell_exec($this->getExecCommand() . ' 2>&1');
        Yii::log($this->getExecCommand());
        Yii::log($out);
        $handle_out = fopen($this->getOutputFileLocation(), 'r') or die('Cannot open file:  ' . $this->getOutputFileLocation());
        $clustering = new Clustering;
        $clustering->algorithm = $this->alg_obj->id;
        $clustering->score = 5;
        $clustering->user = $this->user->id;
        //$this->user->clusterings = [$clustering];
        //$this->user->save();
        $run = $clustering->save();
        if (!$run) {
            print_r($clustering->getErrors());
        }

        $clus_ind = -1;
        $clusObj = null;
        //$clusList = array();
        $id = null;
        $clus = null;

        //initialize unknown cluster
        $unknownClus = new Cluster;
        $unknownClus->name = self::$default_unknown_name;
        $unknownClus->clustering = $clustering->id;
        $unknownClus->save();
        //end of initialize unknown cluster

        for ($i = 0; $i < 6; $i++) // 6 lines of output file will not be used here!
            fgets($handle_out);
        $clus_arr = array();
        while (!feof($handle_out)) {
            $line = fgets($handle_out);
            $linearr = explode("\t", $line);
            if (sizeof($linearr) == 2) {
                list($id, $clus) = $linearr;
                //     echo "<br/>";
                //     print_r($linearr);
            } else {
                //uncomment this for debug!
                //echo 'skip line in file';
                continue;
            }
            if ($clus > $clus_ind) {
                $clus_ind++;
            }
            $clus_arr[$clus_ind][] = $id;
        }

        $clus_ind_name = 1;
        for ($it = 0; $it <= $clus_ind; $it++) {
            if (sizeof($clus_arr[$it]) <= self::$unknown_threshold) {
                for ($i = 0; $i < sizeof($clus_arr[$it]); $i++) {
                    $fri = new Friend;
//                    $relatedData = array(
//                        'clusters' => array($unknownClus->id),
//                        'corClusters' => array($unknownClus->id),
//                    );
                    // $fri->cluster = $unknownClus->id;
                    // $fri->cor_cluster = $unknownClus->id;
                    $fri->user = $this->user->id;
                    $fri->fbid = $this->rev_arr[$clus_arr[$it][$i]];
                    $fri->name = $friendNames[$fri->fbid];
//                    $run = $fri->saveWithRelated($relatedData);
                    $fri->save();
                    $fri->setRelationRecords('clusters', array($unknownClus->id), array('cor_cluster' => $unknownClus->id));

                    if (!$run) {
                        print_r($fri->getErrors());
                    }
                }
            } else {
                $clusObj = new Cluster;
                $clusObj->name = self::$default_clus_name . ($clus_ind_name);
                $clus_ind_name++;
                $clusObj->clustering = $clustering->id;
                $clusObj->save();
                for ($i = 0; $i < sizeof($clus_arr[$it]); $i++) {
                    $fri = new Friend;
//                    $relatedData = array(
//                        'clusters' => array($clusObj->id),
//                        'corClusters' => array($clusObj->id),
//                    );
                    //$fri->cluster = $clusObj->id;
                    //$fri->cor_cluster = $clusObj->id;
                    $fri->user = $this->user->id;
                    $fri->fbid = $this->rev_arr[$clus_arr[$it][$i]];
                    $fri->name = $friendNames[$fri->fbid];
//                  
//                    $run = $fri->saveWithRelated($relatedData);
                    $fri->save();
                    $fri->setRelationRecords('clusters', array($clusObj->id), array('cor_cluster' => $clusObj->id));

                    if (!$run) {
                        print_r($fri->getErrors());
                    }
                }
            }
        }

        fclose($handle_out);
        chmod($this->getOutputFileLocation(), 0777);
        // $this->user = User::model()->findByPK($this->user->id);
        //$clustering->clusters = $clusList;
        $this->takeUnknownToLast($clustering, $unknownClus);
        $run = $clustering->save();
        if (!$run) {
            print_r($clustering->getErrors());
        }
        return $this->user;
    }

}

?>
