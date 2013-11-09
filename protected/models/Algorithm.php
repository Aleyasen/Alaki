<?php

Yii::import('application.models._base.BaseAlgorithm');

class Algorithm extends BaseAlgorithm {

    public static $MCL = null;
    public static $GN = null;
    public static $CNM = null;
    public static $Louvain = null;
    public static $OSLOM = null;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

       
    public static function get_MCL(){
        if (!isset(self::$MCL))
            self::$MCL = Algorithm::model()->findByPK('1');
        return self::$MCL;
    }
    
    public static function get_GN(){
        if (!isset(self::$GN))
             self::$GN= Algorithm::model()->findByPK('2');
        return self::$GN;
    }
    
    public static function get_CNM(){
        if (!isset(self::$CNM))
             self::$CNM = Algorithm::model()->findByPK('3');
        return self::$CNM;
    }
    
    public static function get_Louvain(){
        if (!isset(self::$Louvain))
             self::$Louvain = Algorithm::model()->findByPK('4');
        return self::$Louvain;
    }
    
    public static function get_OSLOM(){
        if (!isset(self::$OSLOM))
             self::$OSLOM = Algorithm::model()->findByPK('5');
        return self::$OSLOM;
    }
   

}