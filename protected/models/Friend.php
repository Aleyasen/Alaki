<?php

Yii::import('application.models._base.BaseFriend');

class Friend extends BaseFriend {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return CMap::mergeArray(parent::relations(), array(
                    'clusters' => array(self::MANY_MANY, 'Cluster', 'tbl_friend_cluster(friend, cluster)'),
                    'corClusters' => array(self::MANY_MANY, 'Cluster', 'tbl_friend_cluster(friend, cor_cluster)'),
                        )
        );
    }

    public function pivotModels() {
        return array(
            'clusters' => 'FriendCluster',
            'corClusters' => 'FriendCluster',
        );
    }

    public function rules() {
        return array();
    }

}