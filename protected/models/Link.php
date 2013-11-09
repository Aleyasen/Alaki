<?php

Yii::import('application.models._base.BaseLink');

class Link extends BaseLink {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function isNeighbour($fbid1, $fbid2, $uid) {
        $count1 = Link::model()->count('user=:userId and friend_1=:fbid1 and friend_2=:fbid2', array(':userId' => $uid, ':fbid1' => $fbid1, ':fbid2' => $fbid2));
        if ($count1 > 0)
            return true;
        $count2 = Link::model()->count('user=:userId and friend_1=:fbid1 and friend_2=:fbid2', array(':userId' => $uid, ':fbid1' => $fbid2, ':fbid2' => $fbid1));
        if ($count2 > 0)
            return true;
        return false;
    }

    public static function getDegree($fbid, $uid) {
        $count1 = Link::model()->count('user=:userId and friend_1=:fbid', array(':userId' => $uid, ':fbid' => $fbid));
        $count2 = Link::model()->count('user=:userId and friend_2=:fbid', array(':userId' => $uid, ':fbid' => $fbid));
        return $count1 + $count2;
    }

    public static function printGraph($innerFriends, $uid) {
        echo "Nodes#: " . count($innerFriends) . '<br>';
        for ($i = 0; $i < count($innerFriends); $i++) {
            echo $innerFriends[$i]->id . ' :: ';
            for ($j = $i + 1; $j < count($innerFriends); $j++) {
                if (Link::isNeighbour($innerFriends[$i]->fbid, $innerFriends[$j]->fbid, $uid)) {
                    echo $innerFriends[$j]->id . " - ";
                }
            }
            echo '<br>';
        }
    }

    public static function getNeighbours($fbid, $uid) {
        $fbids = array();
        $set1 = Link::model()->findAll(array('select' => 'friend_2',
            'condition' => 'user=:userId and friend_1=:fbid',
            'params' => array(':userId' => $uid, ':fbid' => $fbid)));
        foreach ($set1 as $link) {
            $fbids[] = $link->friend_2;
        }
        $set2 = Link::model()->findAll(array('select' => 'friend_1',
            'condition' => 'user=:userId and friend_2=:fbid',
            'params' => array(':userId' => $uid, ':fbid' => $fbid)));
        foreach ($set2 as $link) {
            $fbids[] = $link->friend_1;
        }
        return $fbids;
    }

    public static function getNeighboursInner($fbid, $uid, $innerFriends) {
        $innerNeighbours = array();
        $neighbours = Link::getNeighbours($fbid, $uid);
        //echo 'allhamsaye#' . $neighbours[0] . '<br>';
        //print_r($neighbours);
        for ($i = 0; $i < count($innerFriends); $i++) {
            if (in_array($innerFriends[$i]->fbid, $neighbours)) {
                $innerNeighbours[] = $innerFriends[$i]->fbid;
            }
        }
        return $innerNeighbours;
    }

}