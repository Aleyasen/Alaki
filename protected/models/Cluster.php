<?php

Yii::import('application.models._base.BaseCluster');

class Cluster extends BaseCluster {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getGroundTruthSize() {
        return sizeof($this->corFriends);
    }

    public function getClusterSize() {
        return sizeof($this->friends);
    }

    public function calcInnerEdgesCount() {
        $innerEdgeCount = 0;
        for ($i = 0; $i < count($this->corFriends); $i++) {
            for ($j = $i + 1; $j < count($this->corFriends); $j++) {
                $fr1 = $this->corFriends[$i];
                $fr2 = $this->corFriends[$j];
                if (Link::isNeighbour($fr1->fbid, $fr2->fbid, $this->clustering0->user0->id) == true) {
                    $innerEdgeCount++;
                }
            }
        }
        $this->innerEdges = $innerEdgeCount;

        $degreeSum = 0;
        for ($i = 0; $i < count($this->corFriends); $i++) {
            $fr = $this->corFriends[$i];
            $degreeSum += Link::getDegree($fr->fbid, $this->clustering0->user0->id);
        }
        $this->outerEdges = $degreeSum - (2 * $innerEdgeCount);
        $this->save();
    }

    public function calcInnerEdgesCountBefore() {
        $innerEdgeCount = 0;
        for ($i = 0; $i < count($this->friends); $i++) {
            for ($j = $i + 1; $j < count($this->friends); $j++) {
                $fr1 = $this->friends[$i];
                $fr2 = $this->friends[$j];
                if (Link::isNeighbour($fr1->fbid, $fr2->fbid, $this->clustering0->user0->id) == true) {
                    $innerEdgeCount++;
                }
            }
        }
        $this->innerEdgesB = $innerEdgeCount;

        $degreeSum = 0;
        for ($i = 0; $i < count($this->friends); $i++) {
            $fr = $this->friends[$i];
            $degreeSum += Link::getDegree($fr->fbid, $this->clustering0->user0->id);
        }
        $this->outerEdgesB = $degreeSum - (2 * $innerEdgeCount);
        $this->save();
    }

    //************************Scoring Functions based on Internal Connectivity************

    public function saveMeasures() {
//        $this->calcInnerEdgesCount();
        $this->calcInnerEdgesCountBefore();
        $this->friendsCount = sizeof($this->friends);
        $this->corFriendsCount = sizeof($this->corFriends);
        $this->save();

//        $this->internalDensity = $this->internal_density();
//        $this->averageDegree = $this->average_degree();
//        $this->TPR = $this->TPR();
//        //echo 'TPR ' . $this->id . ' : ' . $this->TPR . '<br>';
//        $this->expansion = $this->expansion();
//        $this->cutRation = $this->cut_ration();
        $this->conductance = $this->conductance();

        $this->internalDensityB = $this->internal_density_before();
        $this->averageDegreeB = $this->average_degree_before();
        $this->TPRB = $this->TPR_before();
        $this->expansionB = $this->expansion_before();
        $this->cutRationB = $this->cut_ration_before();
        $this->conductanceB = $this->conductance_before();

        $this->save();
    }

    public function internal_density() {
        $corClusterSize = $this->getGroundTruthSize();
        if ($corClusterSize == 0 || $corClusterSize == 1)
            return 0.0;
        return $this->innerEdges / ($corClusterSize * ( $corClusterSize - 1) / 2);
    }

    public function average_degree() {
        $corClusterSize = $this->getGroundTruthSize();
        if ($corClusterSize == 0)
            return 0.0;
        return 2 * $this->innerEdges / $corClusterSize;
    }

    public function TPR() {
        if (count($this->corFriends) == 0)
            return 0.0;
        $uid = $this->clustering0->user0->id;
        $mark = array();
        for ($i = 0; $i < count($this->corFriends); $i++) {
            $mark[$this->corFriends[$i]->fbid] = false;
        }
        for ($i = 0; $i < count($this->corFriends); $i++) {
            $fbid = $this->corFriends[$i]->fbid;
            if ($mark[$fbid] == false) {
                $neighbours = Link::getNeighboursInner($fbid, $uid, $this->corFriends);
                //echo 'hamsaye# ' . count($neighbours) . '<br>';
                for ($j = 0; $j < count($neighbours); $j++) {
                    for ($k = $j + 1; $k < count($neighbours); $k++) {
                        if (Link::isNeighbour($neighbours[$j], $neighbours[$k], $uid)) {
                            $mark[$fbid] = true;
                            //echo 'mark me true!<br>';
                            $mark[$neighbours[$j]] = true;
                            $mark[$neighbours[$k]] = true;
                            break 2;
                        }
                    }
                }
            }
        }
        $sum = 0;
        for ($i = 0; $i < count($this->corFriends); $i++) {
            if ($mark[$this->corFriends[$i]->fbid] == true)
                $sum++;
        }
        return $sum / count($this->corFriends);
    }

    //************************Scoring Functions based on External Connectivity************
    public function expansion() {
        $corClusterSize = $this->getGroundTruthSize();
        if ($corClusterSize == 0) //TODO: CBM
            return 0.0;
        return $this->outerEdges / $corClusterSize;
    }

    public function cut_ration() {
        $corClusterSize = $this->getGroundTruthSize();
        $num_of_friends = count($this->clustering0->getFriends());
        if ($corClusterSize == 0) //TODO: CBM
            return 0.0;
        return $this->outerEdges / ( $corClusterSize * ($num_of_friends - $corClusterSize) );
    }

    //************************Scoring Functions that Combine Internal & External Connectivity************
    public function conductance() {
        if (((2 * $this->innerEdges) + $this->outerEdges) == 0)
            return 0.0;
        return $this->outerEdges / ((2 * $this->innerEdges) + $this->outerEdges);
    }

    //*************************All METHODS REPEAT FOR BEFORE CLUSTERS**********************

    public function internal_density_before() {
        $clusterSize = $this->getClusterSize();
        if ($clusterSize == 0 || $clusterSize == 1)
            return 0.0;
        return $this->innerEdgesB / ($clusterSize * ( $clusterSize - 1) / 2);
    }

    public function average_degree_before() {
        $clusterSize = $this->getClusterSize();
        if ($clusterSize == 0)
            return 0.0;
        return 2 * $this->innerEdgesB / $clusterSize;
    }

    public function TPR_before() {
        if (count($this->friends) == 0)
            return 0.0;
        $uid = $this->clustering0->user0->id;
        $mark = array();
        for ($i = 0; $i < count($this->friends); $i++) {
            $mark[$this->friends[$i]->fbid] = false;
        }
        for ($i = 0; $i < count($this->friends); $i++) {
            $fbid = $this->friends[$i]->fbid;
            if ($mark[$fbid] == false) {
                $neighbours = Link::getNeighboursInner($fbid, $uid, $this->friends);
                //echo 'hamsaye# ' . count($neighbours) . '<br>';
                for ($j = 0; $j < count($neighbours); $j++) {
                    for ($k = $j + 1; $k < count($neighbours); $k++) {
                        if (Link::isNeighbour($neighbours[$j], $neighbours[$k], $uid)) {
                            $mark[$fbid] = true;
                            //echo 'mark me true!<br>';
                            $mark[$neighbours[$j]] = true;
                            $mark[$neighbours[$k]] = true;
                            break 2;
                        }
                    }
                }
            }
        }
        $sum = 0;
        for ($i = 0; $i < count($this->friends); $i++) {
            if ($mark[$this->friends[$i]->fbid] == true)
                $sum++;
        }
        return $sum / count($this->friends);
    }

    //************************Scoring Functions based on External Connectivity************
    public function expansion_before() {
        $clusterSize = $this->getClusterSize();
        if ($clusterSize == 0) //TODO: CBM
            return 0.0;
        return $this->outerEdgesB / $clusterSize;
    }

    public function cut_ration_before() {
        $clusterSize = $this->getClusterSize();
        $num_of_friends = count($this->clustering0->getFriends());
        if ($clusterSize == 0) //TODO: CBM
            return 0.0;
        return $this->outerEdgesB / ( $clusterSize * ($num_of_friends - $clusterSize) );
    }

    //************************Scoring Functions that Combine Internal & External Connectivity************
    public function conductance_before() {
        if (((2 * $this->innerEdgesB) + $this->outerEdgesB) == 0)
            return 0.0;
        return $this->outerEdgesB / ((2 * $this->innerEdgesB) + $this->outerEdgesB);
    }

    //*************************************************************************************
    public function getClustersLikelihood($cluslist) {
        $result = array();
        $sum = 0;
        $friCount = count($this->corFriends);
        foreach ($this->corFriends as $fri) {
            foreach ($cluslist as $clus) {
                if ($clus->isFBidExist($fri->fbid)) {
                    if (!isset($result[$clus->id])) {
                        $result[$clus->id] = array();
                        $result[$clus->id][0] = 0;
                    }
                    $result[$clus->id][0] ++;
                    $sum++;
                }
            }
        }
        $max = -1;
        foreach ($cluslist as $clus) {
            if (isset($result[$clus->id])) {
                $result[$clus->id][1] = $result[$clus->id][0] * 100 / $friCount;
                if ($result[$clus->id][1] > $max)
                    $max = $result[$clus->id][1];
            }
        }
        $result[-1] = $max;
        return $result;
    }

    public function isFBidExist($fbid) {
        foreach ($this->corFriends as $fri) {
            if ($fri->fbid == $fbid)
                return true;
        }
        return false;
    }

    public function relations() {
        return CMap::mergeArray(parent::relations(), array(
                    'friends' => array(self::MANY_MANY, 'Friend', 'tbl_friend_cluster(cluster, friend)', 'order' => 'friends.name ASC'),
                    'corFriends' => array(self::MANY_MANY, 'Friend', 'tbl_friend_cluster(cor_cluster, friend)', 'order' => 'corFriends.name ASC'),
                        )
        );
    }

    public function pivotModels() {
        return array(
            'friends' => 'FriendCluster',
            'corFriends' => 'FriendCluster',
        );
    }

    public function rules() {
        return array();
    }

    /* public function getDeletedFriendsCount() {
      $count = 0;
      foreach ($this->friends as $fri) {
      if ($fri->cluster != $fri->cor_cluster)
      $count++;
      }
      return $count;
      } */

    /* public function getAddedFriendsCount() {
      $count = 0;
      foreach ($this->corFriends as $fri) {
      if ($fri->cluster != $fri->cor_cluster)
      $count++;
      }
      return $count;
      } */
}