<?php

class GroupingController extends Controller {

    public function initialize() {
        // echo "initialize...";
        ini_set('session.gc_maxlifetime', 8 * 60 * 60);
        ini_set('max_execution_time', 3600);
        ini_set("session.cookie_lifetime", 3600);
        session_set_cookie_params(8 * 60 * 60);
        date_default_timezone_set('America/Chicago');
        $this->setVar('friends', NULL);
        $this->setVar('edges', NULL);
    }

    public function actionIntro() {
        $user = new User;
        $user->createdAt = new CDbExpression('NOW()');
        if (Yii::app()->facebook->isUserLogin()) {
            $this->initialize();
            $user->fbid = Yii::app()->facebook->getUser();
            if ($user->save()) {
                Yii::log('success');
            } else {
                print_r($user->getErrors());
            }
            $this->setVar('user', $user);
            $this->saveLinks();
        } else {
            $user->fbid = -1;
        }
        $this->render('intro', array(
            'user' => $user,
        ));
    }

    public function actionView() {
        $this->layout = "grouping";
        //   if (Yii::app()->facebook->isUserLogin()) {
        if ($this->isValidUser()) {
            if (Yii::app()->request->isAjaxRequest) {
                // TODO    $this->render('_base_clustering', array());
            } else {
                if (count($this->getVar('user')->clusterings) < 1) {
                    //$this->clusteringAlgorithm();
                }
                //return; // Just for Test
                $user = User::model()->findByPK($this->getVar('user')->id);
                $this->setVar('user', $user);

                $this->render('view', array(
                    'user' => $user
                ));
            }
        }
    }

    public function clusteringAlgorithm() {

        $edges = $this->getEdges();

        $louvain = new LouvainAlgorithm($this->getVar('user'));
        $louvain->execute($edges, $this->getFriends());
    }

    public function getVar($key) {
        $session = Yii::app()->session;
        return $session->itemAt($key);
    }

    public function setVar($key, $val) {
        $session = Yii::app()->session;
        $session->add($key, $val);
    }

    public function saveLinks() {//*********Save all the links between friends in the databse***********
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //.... other SQL executions
            $links = $this->getEdges();
            // echo "save links";
            $u = $this->getVar('user');
            // echo $u->id;
            foreach ($links as $l) {
                $link = new Link;
                $link->user = $u->id;
                $link->friend_1 = $l["uid1"];
                $link->friend_2 = $l["uid2"];
                $link->save();
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }

    public function getEdges() {
        $e = $this->getVar('edges');
        if (isset($e)) {
            return $this->getVar('edges');
        }

        $returned_array = array();
        $all_friends_id = array_keys($this->getFriends());
        $chunked_friends = array_chunk($all_friends_id, 20);

        foreach ($chunked_friends as $array) {
            $mutualfriends = Yii::app()->facebook->api(array(
                'method' => 'fql.query',
                'query' => 'SELECT uid1, uid2 FROM friend 
                WHERE uid2 IN 
                (SELECT uid2 FROM friend WHERE uid1=me())   
                AND uid1 < uid2 
                AND uid1 IN ( ' . implode(', ', $array) . ' )'
            ));
            //   echo "chunk# " . count($mutualfriends).'<br>';
            foreach ($mutualfriends as $mutualfriend) {
                $returned_array[] = array("uid1" => $mutualfriend['uid1'], "uid2" => $mutualfriend['uid2']);
            }
        }
        $this->setVar('edges', $returned_array);
        // echo 'edges size: ' . sizeof($returned_array) . '<br>';
        return $returned_array;
    }

    public function getFriends() {
        $f = $this->getVar('friends');
        if (isset($f)) {
            return $this->getVar('friends');
        }

        $friends = Yii::app()->facebook->api('me/friends?limit=5000');
        $list = array();
        echo "Friends#" . count($friends["data"]) . "<br>";
        foreach ($friends["data"] as $friend) {
            $list[$friend["id"]] = $friend["name"];
        }

        $this->setVar('friends', $list);
        return $list;
    }

    public function isValidUser() {
        if (!isset(Yii::app()->session['user']) || empty(Yii::app()->session['user'])) {
            // if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

}