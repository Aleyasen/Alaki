<?php

Yii::import('application.models._base.BaseFbInfo');

class FbInfo extends BaseFbInfo {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function fetchBasicInfo() {
        $fbid = $this->fbid;
        $userInfo = Yii::app()->facebook->api('me/');
    }
    
    public function fetchPostInfo() {
        
    }

}

