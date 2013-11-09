<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Markov
 *
 * @author Aale
 */
class MarkovAlgorithm extends ClusteringAlgorithm {

    //put your code here
    public function __construct($user) {
        parent::__construct($user);
        $this->alg_abbr = 'mcl';
        $this->alg_obj = Algorithm::model()->findByPK('1');
    }

    public function getExecCommandInWindows() {
        $cmd = '"mcl ' . $this->getInputFileLocation() . ' --abc -o ' . $this->getOutputFileLocation() . '"';
        $cmd = $this->cygwin_cmd . $cmd;
        return $cmd;
    }

    public function getExecCommandInLinux() {
        $cmd = '/usr/local/bin/mcl ' . $this->getInputFileLocation() . ' --abc -o ' . $this->getOutputFileLocation();
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

        $run = $clustering->save();
        if (!$run) {
            print_r($clustering->getErrors());
        }

        $clus_ind = 1;
        $clusObj = null;
        //$clusList = array();
        //initialize unknown cluster
        $unknownClus = new Cluster;
        $unknownClus->name = self::$default_unknown_name;
        $unknownClus->clustering = $clustering->id;
        $unknownClus->save();
        //$clusList[] = $unknownClus;
        //end of initialize unknown cluster

        while (!feof($handle_out)) {
            $line = fgets($handle_out);
            $linearr = explode("\t", $line);
            if (sizeof($linearr) <= 1)
                break;
            $linearr[sizeof($linearr) - 1] = substr($linearr[sizeof($linearr) - 1], 0, -1);
            //adding unknown friends to unknownClus
            if (sizeof($linearr) <= self::$unknown_threshold) {
                for ($it = 0; $it < sizeof($linearr); $it++) {
                    $fri = new Friend;
//                    $relatedData = array(
//                        'clusters' => array($unknownClus->id),
//                        'corClusters' => array($unknownClus->id),
//                    );
                    // $fri->cluster = $unknownClus->id;
                    // $fri->cor_cluster = $unknownClus->id;
                    $fri->user = $this->user->id;
                    if (isset($this->rev_arr[$linearr[intval($it)]])) {
                        $fri->fbid = $this->rev_arr[$linearr[intval($it)]];
                        $fri->name = $friendNames[$fri->fbid];
                    } else {
                        //uncomment this for debug!                   
                        //echo 'not-set: ' . $it . ' ' . $linearr[intval($it)] . '<br/>';
                        //$fri->fbid = '000000';
                        continue;
                    }
                    $fri->save();
                    $fri->setRelationRecords('clusters', array($unknownClus->id), array('cor_cluster' => $unknownClus->id));

                    //$run = $fri->saveWithRelated($relatedData);
                    if (!$run) {
                        print_r("unk");
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
                    // $fri->cluster = $clusObj->id;
                    // $fri->cor_cluster = $clusObj->id;
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
                    $fri->save();
                    // $run = $fri->saveWithRelated($relatedData);

                    $fri->setRelationRecords('clusters', array($clusObj->id), array('cor_cluster' => $clusObj->id));
                    //$fri->save();
                    //$fri->setRelationRecords('corClusters', array($clusObj->id));
                    if (!$run) {
                        // print_r($fri);
                        print_r("clusO");
                        print_r($fri->getErrors());
                    }
                }
            }
        }

        fclose($handle_out);
        chmod($this->getOutputFileLocation(), 0777);


        $unknownClus->clustering = $clustering->id;
        $unknownClus->save();
        // $clustering->clusters = $clusList;
        $this->takeUnknownToLast($clustering, $unknownClus);
        if ($clustering->save()) {
            //    print_r('success save clus');
        } else {
            print_r($clustering->getErrors());
        }
        return $this->user; //no Need to return
    }

}

?>
