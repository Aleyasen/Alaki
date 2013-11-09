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
class CNMAlgorithm extends ClusteringAlgorithm {

    public function __construct($time, $fbid) {
        parent::__construct($time, $fbid);
        $this->alg_abbr = 'cnm';
        $this->alg_obj = Algorithm::model()->findByPK('3');
    }

    public function getExecCommandInWindows() {
        $alg_loc = $this->proj_path . 'algorithms/CNM/community';
        $cmd = '"' . $alg_loc . ' -i:' . $this->getInputFileLocation() . ' -a:2 -o:' . $this->getOutputFileLocation() . '"';
        $cmd = 'G:\cygwin\bin\bash.exe --login -c ' . $cmd;
        return $cmd;
    }
    
    public function getExecCommandInLinux() {
        $cmd = "";
        return $cmd;
    }

    public function execute() {
        $out = shell_exec($this->getExecCommand());
        $handle_out = fopen($this->getOutputFileLocation(), 'r') or die('Cannot open file:  ' . $this->getOutputFileLocation());
        $clustering = new Clustering;
        $clustering->algorithm = $this->alg_obj;
        $clustering->score = 5;
        $clustering->user = $this->user->id;
        $this->user->clusterings = [$clustering];
        $this->user->save();
        if ($clustering->save()) {
            //    print_r('success save clus');
        } else {
            print_r($clustering->getErrors());
        }
        $clus_ind = -1;
        $clusObj = null;
        $clusList = array();
        $id = null;
        $clus = null;

        for ($i = 0; $i < 6; $i++)
            fgets($handle_out);
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
                echo "Error<br/>";
                print_r($line);
                echo "<br/>";
                print_r($linearr);
                echo "Done<br/>";
            }
            if ($clus > $clus_ind) {
                $clusObj = new Cluster;
                $clusObj->name = self::$default_clus_name . ($clus+1);
                $clusObj->clustering = $clustering->id;
                $clusObj->save();
                $clusList[] = $clusObj;
                $clus_ind++;
            }

            $fri = new Friend;
//            $relatedData = array(
//                'clusters' => array($clusObj->id),
//                'corClusters' => array($clusObj->id),
//            );
          //  $fri->cluster = $clusObj->id;
          //  $fri->cor_cluster = $clusObj->id;
            $fri->user = $this->user->id;
            $fri->fbid = $this->rev_arr[$id];
            $fri->save();
            $fri->setRelationRecords('clusters', array($clusObj->id), array('cor_cluster' => $clusObj->id));
                    
//            $fri->saveWithRelated($relatedData)
                //      print_r('success save friends');
            
        }

        fclose($handle_out);
        chmod($this->getOutputFileLocation(),0777);
        
        $this->user = User::model()->findByPK($this->user->id);
        $clustering->clusters = $clusList;
        $this->takeUnknownToLast($clustering, $unknownClus);
        if ($clustering->save()) {
            //    print_r('success save clus');
        } else {
            print_r($clustering->getErrors());
        }
        
        return $this->user;
    }
}

?>
