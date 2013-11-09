<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClusteringAlgorithm
 *
 * @author Aale
 */
class ClusteringAlgorithm {

    protected $proj_path;
    protected $dir;
    protected $date;
    protected $user;
    protected $alg_abbr;
    protected $alg_obj;
    protected $dir_arr;
    protected $rev_arr;
    public static $default_unknown_name = 'Un-Grouped';
    public static $unknown_threshold = 1;
    public static $default_clus_name = 'Group ';
    public $cygwin_cmd;

    public function __construct($user) {
        $this->proj_path = dirname(Yii::app()->getBasePath()) . '/';
        $this->proj_path = str_replace('\\', '/', $this->proj_path);
        date_default_timezone_set('America/Chicago');
        $this->date = date("Ymd-His");
        $this->user = $user;
        $this->dir = $this->proj_path . 'algorithms/data/' . $this->user->id . '-' . $this->user->fbid . '/Algorithms';
        $this->cygwin_cmd = 'C:\cygwin64\bin\bash.exe --login -c ' ;
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
    }

    public function getInputFileName() {

        return $this->dir . '/' . 'in-' . $this->user->fbid . '-' . $this->date . '-' . $this->alg_abbr;
    }

    public function getInputFileLocation() {
        //return $this->proj_path . 'algorithms/data/in-' . $this->user->fbid . '-' . $this->date . '-' . $this->alg_abbr . '.txt';
        return $this->getInputFileName() . '.txt';
    }

    public function getOutputFileName() {
        return $this->dir . '/' . 'out-' . $this->user->fbid . '-' . $this->date . '-' . $this->alg_abbr;
    }

    public function getOutputFileLocation() {
        //return $this->proj_path . 'algorithms/data/out-' . $this->user->fbid . '-' . $this->date . '-' . $this->alg_abbr . '.txt';
        return $this->getOutputFileName() . '.txt';
    }

    public function getMapFileLocation() {
        return $this->dir . '/' . 'map-' . $this->user->fbid . '-' . $this->date . '-' . $this->alg_abbr . '.txt';
    }

    public function getExecCommand() {
        if ($this->isWindows())
            return $this->getExecCommandInWindows();
        else
            return $this->getExecCommandInLinux();
    }

    public function execute($edges, $friendNames) {
        
    }

    public function takeUnknownToLast($clustering, $unknownClus) {
        $newUClus = new Cluster;
        $newUClus->name = self::$default_unknown_name;
        $newUClus->clustering = $clustering->id;
        $newUClus->save();
        foreach ($unknownClus->friends as $fri) {
//            $relatedData = array(
//                'clusters' => array($newUClus->id),
//                'corClusters' => array($newUClus->id),
//            );
            // $fri->cluster = $newUClus->id;
            // $fri->cor_cluster = $newUClus->id;
            //  $fri->saveWithRelated($relatedData);
            $fri->save();
            $fri->setRelationRecords('clusters', array($newUClus->id), array('cor_cluster' => $newUClus->id));
        }
        foreach ($unknownClus->corFriends as $fri) {
//            $relatedData = array(
//                'clusters' => array($newUClus->id),
//                'corClusters' => array($newUClus->id),
//            );
            // $fri->cluster = $newUClus->id;
            //  $fri->cor_cluster = $newUClus->id;
//            $fri->saveWithRelated($relatedData);
            $fri->save();
            $fri->setRelationRecords('clusters', array($newUClus->id), array('cor_cluster' => $newUClus->id));
        }
        $unknownClus->delete();
        $newUClus->save();
        $clustering->save();
    }

    public function isWindows() {
        $isWindows = isset($_SERVER['WINDIR']);
        return $isWindows;
    }

    public function initialize($edges) {
        //Create & Open & Read Input File
        $handle_in = fopen($this->getInputFileLocation(), 'w') or die('Cannot open file:  ' . $this->getInputFileLocation());

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
       //echo 'Friends Size: ' . sizeof($this->rev_arr) . '<br>';
        for ($i = 0; $i < sizeof($this->rev_arr); $i++)
            fwrite($handle_map, $i . "\t" . $this->rev_arr[$i] . PHP_EOL);
        fclose($handle_map);
        if (!chmod($this->getMapFileLocation(), 0777))
            echo "can not chmod " . $this->getMapFileLocation();

        //TODO: Check this undirected format cause no problem for none of the algorithms
        foreach ($edges as $e) {
            $data = $this->dir_arr[$e['uid1']] . ' ' . $this->dir_arr[$e['uid2']] . PHP_EOL . $this->dir_arr[$e['uid2']] . ' ' . $this->dir_arr[$e['uid1']] . PHP_EOL;
            fwrite($handle_in, $data);
        }
        fclose($handle_in);

        if (!chmod($this->getInputFileLocation(), 0777))
            echo "can not chmod " . $this->getInputFileLocation();
    }

}

?>
