<?php

Yii::import('application.models._base.BaseClustering');

class Clustering extends BaseClustering {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function representingColumn() {
        return 'algorithm';
    }

    public function saveClusterMeasures() {
        foreach ($this->clusters as $clus) {
            $clus->saveMeasures();
        }
    }

    public function getAlgorithmName() {
        return $this->algorithm0->name;
    }

    public function getAllClustersSize() {
        $count = 0;
        //$count_delete = 0;
        //  echo "<br>AllClustersSize<br>";
        foreach ($this->clusters as $clus) {
            $countThis = $clus->getClusterSize();
            $count += $countThis;
            //   echo "clus#:" . $clus->id . " " . $countThis . " " . $clus->getGroundTruthSize() . "<br>";
            // $count_delete += $clus->getDeletedFriendsCount();
        }
        return $count;
    }

    public function getAllGroundTruthSize() {
        $count = 0;
        //$count_delete = 0;
        //echo "<br>AllGroundTruthSize<br>";
        foreach ($this->clusters as $clus) {
            $countThis = $clus->getGroundTruthSize();
            $count += $countThis;
            //  echo "clus#:" . $clus->id . " " . $countThis."<br>";
            // $count_delete += $clus->getDeletedFriendsCount();
        }
        return $count;
    }

    /* public function getPrec() {

      //TODO: remove ungrouped
      // The only wrong scenario: 2 friends first are in un-grouped-> After modification, they go to the same group other than ungrouped=> This function consider this as a positive point while is not.
      if (!isset($this->precision)) {
      $prec = 0;
      $all_friends = $this->getFriends();
      //echo 'num_of_friends: ' . count($all_friends);
      foreach ($all_friends as $friend_i) {
      $count = 0;
      $sum = 0;
      foreach ($all_friends as $friend_j) {

      if (intval($friend_i->id) <= intval($friend_j->id)) { // to avoid considering a pair twice!
      $shared_clusters = count(array_intersect($friend_i->clusters, $friend_j->clusters));

      if ($shared_clusters > 0) {
      $count++;
      $shared_GT_clusters = count(array_intersect($friend_i->corClusters, $friend_j->corClusters));
      $multiplicity = min($shared_clusters, $shared_GT_clusters) / $shared_clusters;
      //  echo  $shared_clusters. '   '.$shared_GT_clusters.'<br>';
      $sum += $multiplicity;
      }
      }
      }

      if ($count > 0)
      $prec += ($sum / $count);
      }

      $prec /= count($all_friends);
      echo "<br>" . "precision:" . $prec . "<br>";
      $this->precision = $prec;
      $this->save();
      }

      return $this->precision;
      } */

    //TODO: remove ungrouped

    /* public function getRec() {

      if (!isset($this->recall)) {
      $rec = 0;
      $all_friends = $this->getFriends();
      // echo 'num_of_friends: ' . count($all_friends);
      foreach ($all_friends as $friend_i) {
      $count = 0;
      $sum = 0;
      foreach ($all_friends as $friend_j) {

      if (intval($friend_i->id) <= intval($friend_j->id)) { // to avoid considering a pair twice!
      $shared_GT_clusters = count(array_intersect($friend_i->corClusters, $friend_j->corClusters));

      if ($shared_GT_clusters > 0) {
      $count++;
      $shared_clusters = count(array_intersect($friend_i->clusters, $friend_j->clusters));
      $multiplicity = min($shared_clusters, $shared_GT_clusters) / $shared_GT_clusters;
      //  echo  $shared_clusters. '   '.$shared_GT_clusters.'<br>';
      $sum += $multiplicity;
      }
      }
      }

      if ($count > 0)
      $rec += ($sum / $count);
      }

      $rec /= count($all_friends);
      echo "<br>" . "recall:" . $rec . "<br>";
      $this->recall = $rec;
      $this->save();
      }
      return $this->recall;
      } */

    public function getPrec() {
        $all_friends = $this->create_all_friends();
        if (!isset($this->precision)) {
            $this->precision = $this->getPrec_Base($all_friends);
            $this->save();
        }
        return $this->precision;
    }

    public function getRec() {
        $all_friends = $this->create_all_friends();
        if (!isset($this->recall)) {
            $this->recall = $this->getRec_Base($all_friends);
            $this->save();
        }
        return $this->recall;
    }

    public function getFMeasure() {

        $f_measure = self::getFMeasure_Base($this->getPrec(), $this->getRec());
        return $f_measure;
    }

    public static function getPrec_Base($all_friends) {

        $prec = 0;
        //echo 'num_of_friends: ' . count($all_friends);           
        foreach ($all_friends as $friend_i => $friend_i_value) {
            $count = 0;
            $sum = 0;
            foreach ($all_friends as $friend_j => $friend_j_value) {

                if (intval($friend_i) <= intval($friend_j)) { // to avoid considering a pair twice!
                    $shared_clusters = count(array_intersect($friend_i_value[0], $friend_j_value[0]));

                    if ($shared_clusters > 0) {
                        $count++;
                        $shared_GT_clusters = count(array_intersect($friend_i_value[1], $friend_j_value[1]));
                        $multiplicity = min($shared_clusters, $shared_GT_clusters) / $shared_clusters;
                        // echo  $shared_clusters. '   '.$shared_GT_clusters.'<br>';
                        $sum += $multiplicity;
                    }
                }
            }

            if ($count > 0)
                $prec += ($sum / $count);
        }

        $prec /= count($all_friends);
        // echo "<br>" . "precision:" . $prec . "<br>";
        return $prec;
    }

    public static function getRec_Base($all_friends) {

        $rec = 0;
        //echo 'num_of_friends: ' . count($all_friends);           
        foreach ($all_friends as $friend_i => $friend_i_value) {
            $count = 0;
            $sum = 0;
            foreach ($all_friends as $friend_j => $friend_j_value) {

                if (intval($friend_i) <= intval($friend_j)) { // to avoid considering a pair twice!
                    $shared_GT_clusters = count(array_intersect($friend_i_value[1], $friend_j_value[1]));

                    if ($shared_GT_clusters > 0) {
                        $count++;
                        $shared_clusters = count(array_intersect($friend_i_value[0], $friend_j_value[0]));

                        $multiplicity = min($shared_clusters, $shared_GT_clusters) / $shared_GT_clusters;
                        //  echo  $shared_clusters. '   '.$shared_GT_clusters.'<br>';
                        $sum += $multiplicity;
                    }
                }
            }

            if ($count > 0)
                $rec += ($sum / $count);
        }

        $rec /= count($all_friends);
        // echo "<br>" . "Recall:" . $rec . "<br>";      
        return $rec;
    }

    public static function getFMeasure_Base($prec, $rec) {
        $f_m = 2 * ($prec * $rec) / ($prec + $rec);
        return $f_m;
    }

    //*********** Count overlapped friends in OSLOM************

    public function get_overlapped_friends() {
        $all_friends = $this->create_all_friends();
        $overlapped_friends = array(); //key: # of overlapped, value: # of friends in this category
        foreach ($all_friends as $friend_i => $friend_i_value) {
            $overlap_size = count($friend_i_value[1]);
            if (!isset($overlapped_friends[$overlap_size])) {
                $overlapped_friends[$overlap_size] = 0;
            }

            $overlapped_friends[$overlap_size]++;
        }

        return $overlapped_friends;
    }

    public function create_all_friends() { // Create the input list of getAccuracy function ( array of [friend_id] => [cluster, cor_cluster] )
        $friends = $this->getFriends();
        $results = array();
        foreach ($friends as $f) {
            $f_clusters = array();
            foreach ($f->clusters as $clus) {
                $f_clusters[] = $clus->id;
            }

            $f_corClusters = array();
            foreach ($f->corClusters as $corClus) {
                $f_corClusters[] = $corClus->id;
            }

            $results[$f->id] = array($f_clusters, $f_corClusters);
        }
        return $results;
    }

    public function getFriends() {

        $friends = array();
        foreach ($this->clusters as $cluster) {
            $friends = array_merge($friends, $cluster->friends);
        }
        array_unique($friends);
        return $friends;
    }

    public function getUngroupedSize() {
        foreach ($this->clusters as $cluster) {
            if ($cluster->name == ClusteringAlgorithm::$default_unknown_name) {
                return $cluster->getClusterSize();
            }
        }
    }

    public function getUngroupedGTSize() {
        foreach ($this->clusters as $cluster) {
            if ($cluster->name == ClusteringAlgorithm::$default_unknown_name) {
                return $cluster->getGroundTruthSize();
            }
        }
    }
    

    // Cluster: the method (C)
    //corr_clus: ground-truth (L)
    //TODO: check with new version of tbl_cluster_friend

    /* public function Bucbed_Precision_Disjoint() {
      $precision = 0;


      foreach ($this->clusters as $cluster) {

      foreach ($cluster->friends as $friend_i) {
      $nom = 0;
      foreach ($cluster->friends as $friend_j) {
      if ($friend_i->id != $friend_j->id) {
      if ($friend_i->cor_cluster == $friend_j->cor_cluster) {
      $nom++;
      }
      }
      }
      $denom = $cluster->getClusterSize() - 1;
      //  echo 'nom: '.$nom.'</br>';
      // echo 'denom: '.$denom.'</br>';

      $precision += $nom / $denom;
      }
      }

      //echo 'friends_num = '.sizeof($this->user0->friends).'</br>';
      // echo 'p: '. $precision.'</br>';

      $precision = $precision / sizeof($this->user0->friends);
      return $precision;
      } */

    //TODO: check with new version of tbl_cluster_friend
    /*   public function Bucbed_Recall_Disjoint() {
      $recall = 0;
      //True Logic as I should have a loop on friends

      /* foreach ($this->user0->friends as $friend_i) {
      $nom = 0;
      foreach ($friend_i->corCluster->friends as $friend_j) {
      if ($friend_i->id != $friend_j->id) {
      //  echo $friend_i->id." >> ". $friend_j->id.'</br>';
      if ($friend_i->cluster == $friend_j->cluster) {
      $nom++;
      }
      }
      }
      //   echo '</br></br>';
      $denom = $friend_i->corCluster->getClusterSize() - 1;
      //  echo 'nom: ' . $nom . '</br>';
      //  echo 'denom: ' . $denom . '</br>';

      $recall += $nom / $denom;
      } */

    /*  foreach ($this->clusters as $cluster) {

      foreach ($cluster->corFriends as $friend_i) {
      $nom = 0;
      foreach ($cluster->corFriends as $friend_j) {
      if ($friend_i->id != $friend_j->id) {
      if ($friend_i->cluster == $friend_j->cluster) {
      $nom++;
      }
      }
      }
      $denom = $cluster->getGroundTruthSize() - 1;
      //  echo 'nom: '.$nom.'</br>';
      // echo 'denom: '.$denom.'</br>';
      $recall += $nom / $denom;
      }
      }

      $recall = $recall / sizeof($this->user0->friends);
      //   echo 'friends_num = ' . sizeof($this->user0->friends) . '</br>';
      //   echo 'r: ' . $recall . '</br>';
      return $recall;
      } */

    /*  public function getClusteringError() {
      $count_add = 0;
      //$count_delete = 0;
      foreach ($this->clusters as $clus) {
      $count_add += $clus->getAddedFriendsCount();
      // $count_delete += $clus->getDeletedFriendsCount();
      }
      return $count_add;
      } */
}