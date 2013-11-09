<?php

class FrontendController extends Controller {

    public function initialize() {
        // echo "initialize...";
        ini_set('session.gc_maxlifetime', 8 * 60 * 60);
        ini_set('max_execution_time', 3600);
        ini_set("session.cookie_lifetime", 3600);

        session_set_cookie_params(8 * 60 * 60);
        date_default_timezone_set('America/Chicago');
        //session_save_path(realpath(dirname(FILE) . '/../protected/runtime/'));
        //  $permutation = array(1 => array(1, 2, 3), 2 => array(1, 3, 2), 3 => array(2, 1, 3),
        //    4 => array(2, 3, 1), 5 => array(3, 1, 2), 6 => array(3, 2, 1));
//        $permutation = array(1 => array(1, 4, 5), 2 => array(1, 5, 4), 3 => array(4, 1, 5),
//            4 => array(4, 5, 1), 5 => array(5, 1, 4), 6 => array(5, 4, 1)); // New version due to adding Louvain & OSLOM
//        $this->setVar('chosen_perm', $permutation[rand(1, 6)]);
//        $this->setVar('current', 0);
        $this->setVar('friends', NULL);
        $this->setVar('edges', NULL);
    }

    public function actionGuides() {
        $this->render('guides', array());
    }

    public function actionTerms() {
        $this->render('terms', array());
    }

    public function actionIntro() {
        $user = new User;
        $user->createdAt = new CDbExpression('NOW()');

        if (Yii::app()->facebook->isUserLogin()) {
            // session_destroy();
            $this->initialize();
            $user->fbid = Yii::app()->facebook->getUser();

            if ($user->save()) {
                Yii::log('success');
            } else {
                print_r($user->getErrors());
            }
            $this->setVar('user', $user);
            // These two commands save network + friends info=> If the size of the FB network is very big, comment them!
            $this->saveLinks();
       //     $result = $user->fetchFriendsInfo();

            // echo 'UserId: ' . $user->id;
        } else {
            // echo 'not login';
            $user->fbid = -1;
        }

        $this->render('intro', array(
            'user' => $user,
        ));
    }

    public function isValidUser() {
        if (!isset(Yii::app()->session['user']) || empty(Yii::app()->session['user'])) {
            // if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    public function actionSaveFBData() {
        if ($this->isValidUser()) {
            $u = $this->getVar('user');
            $result = $u->fetchFriendsInfo();
            //  echo $result;
            $result2 = $u->fetchFriendsPostInfo();
            echo $result2;

            $this->render('fbresult', array(
            ));
        }
    }

    public function actionFriends() {
//        if (Yii::app()->facebook->isUserLogin()) {
        if ($this->isValidUser()) {
            $friends = array_keys($this->getFriends());
            $u = $this->getVar('user');
            $u->save();
            $this->render('friends', array(
                'friends' => $friends,
            ));
        } else {
            $this->render('error', array(
            ));
        }
    }

    public function actionLoad($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->render('_base_clustering', array());
        } else {
            $user = User::model()->findByPK($id);
            $this->setVar('user', $user);
            $this->render('clustering_all', array(
                'user' => $user
            ));
        }
    }

    //TODO: Save Links before start
//    public function actionClustering() {
//        if (Yii::app()->facebook->isUserLogin()) {
//            if (Yii::app()->request->isAjaxRequest || $this->getVar('current') == 3) {
//                //echo 'it is ajax request';
//            } else {
//                $this->clusteringAlgorithm();
//                //return; // Just for Test
//                $user = User::model()->findByPK($this->getVar('user')->id);
//                $this->setVar('user', $user);
//            }
//            $algNo_ = $this->getVar('algNo');
//            if ($algNo_ == 1 || $algNo_ == 2 || $algNo_ == 3) {
//                $this->render('clustering', array(
//                    'user' => $this->getVar('user')
//                ));
//            } else if ($algNo_ == 4) {
//                $this->render('clustering_hier', array(
//                    'user' => $this->getVar('user')
//                ));
//            } else if ($algNo_ == 5) {
//                $this->render('clustering_overlap', array(
//                    'user' => $this->getVar('user')
//                ));
//            }
//        } else {
//            //  $this->render('error', array(  //  ));
//        }
//    }


    public function getClusteringId($user, $algNo) {
        foreach ($user->clusterings as $c) {
            if ($c->algorithm == $algNo)
                return $c->id;
        }
    }

    public function actionDisjoint() {
        //  if (Yii::app()->facebook->isUserLogin()) {
        if ($this->isValidUser()) {
            $clusteringId = $this->getClusteringId($this->getVar('user'), 1);
            $this->renderPartial('clustering', array(
                'user' => $this->getVar('user'),
                'clusteringId' => $clusteringId
            ));
        }
    }

    public function actionOverlap() {
        //   if (Yii::app()->facebook->isUserLogin()) {
        if ($this->isValidUser()) {
            $clusteringId = $this->getClusteringId($this->getVar('user'), 5);
            $this->renderPartial('clustering_overlap', array(
                'user' => $this->getVar('user'),
                'clusteringId' => $clusteringId
            ));
        }
    }

    public function actionHier() {
        //    if (Yii::app()->facebook->isUserLogin()) {
        if ($this->isValidUser()) {
            $clusteringId = $this->getClusteringId($this->getVar('user'), 4);
            $this->renderPartial('clustering_hier', array(
                'user' => $this->getVar('user'),
                'clusteringId' => $clusteringId
            ));
        }
    }

    public function actionThanks() {
        session_destroy();
        $this->render('thanks', array(
            'user' => $this->getVar('user')
        ));

        //  $this->saveLinks();
    }

    public function saveLinks() {//*********Save all the links between friends in the databse***********
        $transaction = Yii::app()->db->beginTransaction();
        try {
            // $connection->createCommand($sql1)->execute();
            // $connection->createCommand($sql2)->execute();
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

    public function actionClusteringAll() {
        //   if (Yii::app()->facebook->isUserLogin()) {
        if ($this->isValidUser()) {
            if (Yii::app()->request->isAjaxRequest) {
                $this->render('_base_clustering', array());
            } else {
                if (count($this->getVar('user')->clusterings) < 3) {
                    $this->clusteringAlgorithm();
                }
                //return; // Just for Test
                $user = User::model()->findByPK($this->getVar('user')->id);
                $this->setVar('user', $user);

                $this->render('clustering_all', array(
                    'user' => $user
                ));
            }
        }
    }

    public function actionRunAlgorithms() {
        //echo "Markov Algorithm";
        $edges = $this->getEdges();
        $mcl = new MarkovAlgorithm($this->getVar('user'));
        $mcl->execute($edges);
    }

//       public function clusteringAlgorithm() {
//
//        // echo "Old Current: " . $this->getVar('current');
//        $chosen_perm = $this->getVar('chosen_perm');
//        // $chosen_perm = $permutation[4];
//        $algNo = $chosen_perm[$this->getVar('current')];
//        // echo " Algnorithm Number: " . $algNo . "</br>";
//        // echo "chosen_perm";
//        // echo $chosen_perm[0];
//        // echo $chosen_perm[1];
//        // echo $chosen_perm[2];
//        $edges = $this->getEdges();
//
//        //$algNo = 1; // TODO: Just For TEST! Should be removed!
//        $this->setVar('algNo', $algNo);
//        if ($algNo == 1) {//MCL Algorithm
//            echo "Markov Algorithm";
//            $mcl = new MarkovAlgorithm($this->getVar('user'));
//            $mcl->execute($edges, $this->getFriends());
//        } elseif ($algNo == 2) {//GN Algorithm
//            echo "GN Algorithm";
//            $gn = new NewmanAlgorithm($this->getVar('user'), 1, 'gn');
//            $gn->execute($edges, $this->getFriends());
//        } elseif ($algNo == 3) {//CNM Algorithm
//            echo "CNM Algorithm";
//            $cnm = new NewmanAlgorithm($this->getVar('user'), 2, 'cnm');
//            $cnm->execute($edges, $this->getFriends());
//        } elseif ($algNo == 4) {//Louvain Algorithm
//            echo "Louvain Algorithm" . "</br>";
//            $louvain = new LouvainAlgorithm($this->getVar('user'));
//            $louvain->execute($edges, $this->getFriends());
//        } elseif ($algNo == 5) {//OSLOM Algorithm
//            echo "OSLOM Algorithm" . "</br>";
//            $oslom = new OSLOMAlgorithm($this->getVar('user'));
//            $oslom->execute($edges, $this->getFriends());
//        } else {
//            print_r($algNo);
//        }
//
//        $c = $this->getVar('current') + 1;
//        $this->setVar('current', $c);
//        // echo "New Current: " . $this->getVar('current');
//    }


    public function clusteringAlgorithm() {

        $edges = $this->getEdges();

        //  echo "Markov Algorithm" . "</br>";
        $mcl = new MarkovAlgorithm($this->getVar('user'));
        $mcl->execute($edges, $this->getFriends());

        // echo "Louvain Algorithm" . "</br>";
        $louvain = new LouvainAlgorithm($this->getVar('user'));
        $louvain->execute($edges, $this->getFriends());

        //  echo "OSLOM Algorithm" . "</br>";
        $oslom = new OSLOMAlgorithm($this->getVar('user'));
        $oslom->execute($edges, $this->getFriends());
    }

    public function friendIdList($friends) {
        $farr = array();
        foreach ($friends as $f)
            $farr[$f->id] = $f->fbid;
        return $farr;
    }

    public function actionIndex() {
        $this->render('intro', array(
            'user' => $this->getVar('user'),
        ));
    }

    public function actionError() {
        $this->render('error', array(
        ));
    }

    public function getFriends() {
        $f = $this->getVar('friends');
        if (isset($f)) {
            return $this->getVar('friends');
        }

//        $friends = Yii::app()->facebook->api(array(
//            'method' => 'fql.query',
//            'query' => 'SELECT uid1 from friend where uid2=me()',
//                ));
//        
        $friends = Yii::app()->facebook->api('me/friends?limit=5000');
        $list = array();
        echo "Friends#" . count($friends["data"]) . "<br>";
        foreach ($friends["data"] as $friend) {
            $list[$friend["id"]] = $friend["name"];
        }
        //echo 'friends#:' . count($list) . '<br>';

        $this->setVar('friends', $list);
        return $list;
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

    public function actionFinish() {
        $this->render('finish');
    }

    public function printUser($u) {
        echo 'UserId=' . $u->id;
        echo '<br/>';
        echo 'FBId=' . $u->fbid;
        echo '<br/>';
        foreach ($u->clusterings as $cls) {
            echo 'Clustering=' . $cls->id;
            echo '<br/>Clusters:[<br/>';
            foreach ($cls->clusters as $c) {
                echo 'Cluster=' . $c->id;
                echo '<br/>';
                foreach ($c->friends as $f) {
                    echo $f->id . ':' . $f->fbid . ',[C:' . $f->cluster . '],[CC:' . $f->cor_cluster . ']';
                }
                echo '<br/>';
            }
            echo ']';
            echo '<br/>';
        }
    }

    public function getVar($key) {
        $session = Yii::app()->session;
        return $session->itemAt($key);
    }

    public function setVar($key, $val) {
        $session = Yii::app()->session;
        $session->add($key, $val);
    }

    //*************************User Interface**********************************
    // Public members reload after ajax call
    //alg_type = 1 
    //           2  overlapping
    //           3 hier
    public function getMembers_reload($group_id) {
        $cluster = Cluster::model()->findByPK($group_id);
        $this->setVar('currentClusId', $group_id);
        // $members = $cluster->friends1;
        $members = $cluster->corFriends;
        $html = "";
        if ($cluster->name != ClusteringAlgorithm::$default_unknown_name)
            $html .= "<h2><a href='#' id='clusname" . $cluster->id . "' cid='" . $cluster->id . "'>" . $cluster->name . "</a></h2>";
        else
            $html .= "<h2>" . $cluster->name . "</h2>";

        // $html .= "<i id='selectall' selall='0' class='icon-th-list icon-large' style='float:right;margin-right:30px;' title='Select All'></i>";
        $html .= "<div selall='0' class='btn btn-small selectall' style='float:right;margin-right:30px;'><i class='icon-th-list'></i> Select All</div>";
        if ($members) {
            foreach ($members as $m) {
                $html .= "<div class='members' sel='0' id='mem" . $m->id . "' fbid='" . $m->fbid . "'>\n";
                //    if ($algNo_ == 4) { //Louven algorithm
                //    } else {
                if ($cluster->name == ClusteringAlgorithm::$default_unknown_name) {
                    //TODO : consider deleted cluster in this scenario
                    if (count($m->corClusters) == 1) {
                        //nothing
                    } else {
                        $html .= "<div id='delete" . $m->id . "' class='delbutton close' style='font-size: 14px;'>x</div>";
                    }
                } else {
                    $html .= "<div id='delete" . $m->id . "' class='delbutton close' style='font-size: 14px;'>x</div>";
                }
                //    }
                //$html .= "<fb:profile-pic class='logopic' uid=" . $m->fbid . " size='square' facebook-logo='false' linked='false'></fb:profile-pic>";
                $html .= "<img src='https://graph.facebook.com/" . $m->fbid . "/picture'>";

                $html .= "<div id='name" . $m->fbid . "'>" . $m->name . "</div>";
                $html .= "<i class='icon-facebook-sign icon-large ilink' style='display:none'></i>";
                $html .= "</div>";
            }
        } else {
            //   $html .= "<div style='font-size:12pt'>This group has not any members.<div>";
        }
        return $html;
    }

    // Grouped members reload after ajax call
    public function getGroups_reload($clusteringId) {
        $u = $this->getVar('user');
        $user = User::model()->findByPK($u->id);
        if (!isset($user))
            return "user not set!";
        $clusters = Clustering::model()->findByPK($clusteringId)->clusters;
        if (!isset($clusters))
            return "clusters not set!";
        $html = "";

        // $html .= "<div id='0' class='ui-widget-content ui-corner-all group'>\n";
        // $html .= "<div id='cln0' class='groupheader ui-corner-all'>New Group</div>";
        $html .= "<div style='vertical-align:middle;margin-bottom:10px;'><center><a href='#addGroupModal' role='button' class='btn btn-large' data-toggle='modal'>Add Group</a></center></div>";
        //$html .= "<div>&nbsp</div>";
        // $html .= "</div>";
        //$html .= "<h2>Groups</h2>";
        if ($clusters) {
            $unknownClus = null;
            foreach ($clusters as $cluster) {
                if ($cluster->deleted == true)
                    continue;
                if ($cluster->name == ClusteringAlgorithm::$default_unknown_name) {
                    $unknownClus = $cluster;
                    $this->setVar('unknownClusID', $unknownClus->id);
                    break;
                }
            }
            $childs = array();
            $htmlcontent = array();

            foreach ($clusters as $cluster) {
                if (isset($cluster->sup_cluster)) {
                    $childs[$cluster->sup_cluster][] = $cluster->id;
                }
            }

            foreach ($clusters as $cluster) {
                if (!isset($childs[$cluster->id]) || count($childs[$cluster->id]) == 0) {
                    $htmlcontent[$cluster->id] = $this->getGroupOverviewHtml($cluster, $unknownClus);
                }
            }
            foreach ($clusters as $cluster) {
                if (isset($cluster->sup_cluster)) {
                    if (!isset($htmlcontent[$cluster->sup_cluster]))
                        $htmlcontent[$cluster->sup_cluster] = "";
                    $htmlcontent[$cluster->sup_cluster] .= $htmlcontent[$cluster->id];
                }
            }

            foreach ($clusters as $cluster) {
                if (!isset($cluster->sup_cluster)) {
                    if (isset($childs[$cluster->id]) && count($childs[$cluster->id]) > 1)
                        $htmlcontent[$cluster->id] = $this->getGroupWithChildsHtml($cluster, $unknownClus, $htmlcontent[$cluster->id]);
                }
            }

            foreach ($clusters as $cluster) {
                if (!isset($cluster->sup_cluster)) {
                    $html .= $htmlcontent[$cluster->id];
                }
            }
        }
        return $html;
    }

    public function getGroupWithChildsHtml($cluster, $unknownClus, $childsHtml) {
        $html = "";
        //  $algNo_ = $this->getVar('algNo');
        if ($cluster->deleted == true)
            return;
        if ($cluster->name == ClusteringAlgorithm::$default_unknown_name) {
            $html .= "<div id='" . $cluster->id . "' class='ui-corner-all supgroup'>\n";
            $html .= "<div id='cln" . $cluster->id . "' class='supgroupheader ui-corner-all'>" . ucwords($cluster->name) . "<div style='float:right;margin-right:3px;'></div></div>";
        } else {
            $html .= "<div id='" . $cluster->id . "' class='ui-corner-all supgroup color" . (($cluster->id % 6) + 1) . "'>\n";
            // $html .= "<div id='cln" . $cluster->id . "' class='groupheader ui-corner-all'>" . ucwords($cluster->name) . "<div style='float:right;margin-right:3px;'><a data-toggle='modal' data-id='" . $cluster->id . "' data-name='" . $cluster->name . "' data-unknownClus='" . $unknownClus->id . "' class='openRemoveModal' href='#removeGroupModal'>x</a></div></div>";
            //  if ($algNo_ == 4) {
            //      $html .= "<div id='cln" . $cluster->id . "' class='supgroupheader ui-corner-all color" . (($cluster->id % 6) + 1) . "'>" . "<a href='#' id='clusname" . $cluster->id . "' cid='" . $cluster->id . "'>" . $cluster->name . "</a>" . "<div style='float:right;margin-right:3px;'></div></div>";
            //  } else {
            $html .= "<div id='cln" . $cluster->id . "' class='supgroupheader ui-corner-all color" . (($cluster->id % 6) + 1) . "'>" . "<a href='#' id='clusname" . $cluster->id . "' cid='" . $cluster->id . "'>" . $cluster->name . "</a>" . "<div style='float:right;margin-right:3px;'><a data-toggle='modal' data-id='" . $cluster->id . "' data-name='" . $cluster->name . "' data-unknownClus='" . $unknownClus->id . "' class='openRemoveModal' href='#'>x</a></div></div>";
            //  }
        }
        $html .= "<div id='added" . $cluster->id . "' class='add' style='display:none;' ><img src='" . Yii::app()->request->baseUrl . "/images/green.png' width='25' height='25'></div>";
        $html .= "<div id='removed" . $cluster->id . "' class='remove' style='display:none;' ><img src='" . Yii::app()->request->baseUrl . "/images/red.png' width='25' height='25'></div>";
        $html .= "<div class='supcont'><ul>\n";
        $html .= $childsHtml;
        $html .= "</ul></div>\n";
        $html .= "</div>";
        return $html;
    }

    public function getGroupOverviewHtml($cluster, $unknownClus) {
        $html = "";
        if ($cluster->deleted == true)
            return;
        if ($cluster->name == ClusteringAlgorithm::$default_unknown_name) {
            $html .= "<div id='" . $cluster->id . "' class='ui-widget-content ui-corner-all group'>\n";
            $html .= "<div id='cln" . $cluster->id . "' class='groupheader ui-corner-all'>" . ucwords($cluster->name) . "<div style='float:right;margin-right:3px;'></div></div>";
        } else {
            $html .= "<div id='" . $cluster->id . "' class='ui-widget-content ui-corner-all group'>\n";
            // $html .= "<div id='cln" . $cluster->id . "' class='groupheader ui-corner-all'>" . ucwords($cluster->name) . "<div style='float:right;margin-right:3px;'><a data-toggle='modal' data-id='" . $cluster->id . "' data-name='" . $cluster->name . "' data-unknownClus='" . $unknownClus->id . "' class='openRemoveModal' href='#removeGroupModal'>x</a></div></div>";
            $html .= "<div id='cln" . $cluster->id . "' class='groupheader ui-corner-all'>" . "<a href='#' id='clusname" . $cluster->id . "' cid='" . $cluster->id . "'>" . $cluster->name . "</a>" . "<div style='float:right;margin-right:3px;'><a data-toggle='modal' data-id='" . $cluster->id . "' data-name='" . $cluster->name . "' data-unknownClus='" . $unknownClus->id . "' class='openRemoveModal' href='#'>x</a></div></div>";
        }
        $html .= "<div id='added" . $cluster->id . "' class='add' style='display:none;' ><img src='" . Yii::app()->request->baseUrl . "/images/green.png' width='25' height='25'></div>";
        $html .= "<div id='removed" . $cluster->id . "' class='remove' style='display:none;' ><img src='" . Yii::app()->request->baseUrl . "/images/red.png' width='25' height='25'></div>";
        $html .= "<div class='cont'><ul>\n";
        $html .= $this->lastClusterMembers($cluster);
        $html .= "</ul></div>\n";
        $html .= "</div>";
        return $html;
    }

    public function lastClusterMembers($cluster) {
        // echo $cluster->id;
        // echo 'salam';
        $html = '';
        $max_count = 9;
        $count = 0;
        // foreach ($cluster->friends1 as $m) {
        foreach ($cluster->corFriends as $m) {
            /*    if ($count == 4) {
              $html .= "<div class='fb_thumb'>\n";
              $html .= "<div class='fb_thumb_count'>" . sizeof($cluster->friends1) . "</div>";
              $html .= "</div>";
              }
             * 
             */

            $html .= "<div picfbid='" . $m->fbid . "' class='fb_thumb'>\n";
            // $html .= "<fb:profile-pic class='logopic' uid=" . $m->fbid . " size='square' width='34' facebook-logo='false' linked='false'></fb:profile-pic>";
            $html .= "<img src='https://graph.facebook.com/" . $m->fbid . "/picture' width='34'>";

            $html .= "</div>";
            $count++;

            if ($count >= $max_count)
                break;
        }
        return $html;
    }

    public function addMembers($friendId, $newcorclusId) {
        $friend = Friend::model()->findByPK($friendId);

//        $relatedData = array(
//            'corClusters' => array($clusId),
//        );
        //$friend->cor_cluster = $clusId;
        // $friend->saveWithRelated($relatedData);
        $oldcorclusId = $this->getVar('currentClusId');
        $friendclus = FriendCluster::model()->find("friend=:friend and cor_cluster=:cor_cluster", array(":friend" => $friend->id, ":cor_cluster" => $oldcorclusId));
        $resp = $friend->removeRelationRecords('corClusters', array($oldcorclusId));
        $html = "<>" . $resp . "<>";


        $resp2 = $friend->addRelationRecords('corClusters', array($newcorclusId), array('cluster' => $friendclus->cluster));
        $html .= "        <>  " . $resp2;
        return $html;


        //return $html;
    }

    public function addMembersClone($friendId, $newclusId) {
        $oldclusId = $this->getVar('currentClusId');
        $oldclusObj = Cluster::model()->findByPK($oldclusId);
        if ($oldclusObj->name == ClusteringAlgorithm::$default_unknown_name) {
            $this->addMembers($friendId, $newclusId);
        } else {
            $friend = Friend::model()->findByPK($friendId);
            $friend->addRelationRecords('clusters', array($oldclusId), array('cor_cluster' => $newclusId));
        }
    }

    public function updateName($clusid, $name) {
        $clus = Cluster::model()->findByPK($clusid);
        $clus->name = $name;
        $clus->save();
        return;
    }

    public function actionUpdateName() {
        $this->updateName($_POST['pk'], $_POST['value']);
    }

    public function addNewGroup($groupName, $clusteringId) {
        $u = $this->getVar('user');
        $user = User::model()->findByPK($u->id);
        if (!isset($user))
            return "user not set!";
        $clustering = Clustering::model()->findByPK($clusteringId);
        if (!isset($clustering))
            return "clustering not set!";
        $clusObj = new Cluster;
        $clusObj->name = $groupName;
        $clusObj->clustering = $clustering->id;
        $clusObj->save();
    }

//    public function removeGroup($groupId, $toGroupId) {
//        $clus = Cluster::model()->findByPK($groupId);
//        $clus->deleted = true;
//        $toclus = Cluster::model()->findByPK($toGroupId);
//        //foreach ($clus->friends1 as $fri) {
//        foreach ($clus->corFriends as $fri) {
////            $relatedData = array(
////                'corClusters' => array($toclus->id),
////            );
//            // $fri->cor_cluster = $toclus->id;
//            //   $fri->saveWithRelated($relatedData);
//            $friendclus = FriendCluster::model()->find("friend=:friend and cor_cluster=:cor_cluster", array(":friend" => $fri->id, ":cor_cluster" => $clus->id));
//
//            $fri->removeRelationRecords('corClusters', array($clus->id));
//            $fri->addRelationRecords('corClusters', array($toclus->id), array('cluster' => $friendclus->cluster));
//        }
//        $clus->save();
//    }

    public function removeGroup($groupId, $toGroupId) {
        $clus = Cluster::model()->findByPK($groupId);
        foreach ($clus->corFriends as $fri) {
            $this->removeMember($fri->id);
        }
        $clus->deleted = true;
        $clus->save();
    }

    public function removeMember($memId) {
        $uclusID = $this->getVar('unknownClusID');
        $clusId = $this->getVar('currentClusId');
        $currClusObj = Cluster::model()->findByPK($clusId);
        $fri = Friend::model()->findByPK($memId);
        $friendclus = FriendCluster::model()->find("friend=:friend and cor_cluster=:cor_cluster", array(":friend" => $fri->id, ":cor_cluster" => $clusId));

        if ($currClusObj->name == ClusteringAlgorithm::$default_unknown_name) {

            $allFriendClusCount = FriendCluster::model()->count("friend=:friend", array(":friend" => $fri->id));
            $str = "";
            if ($allFriendClusCount > 1) {
                $fri->removeRelationRecords('corClusters', array($clusId));
                $str .= "remove only";
            } else {
                $fri->removeRelationRecords('corClusters', array($clusId));
                $fri->addRelationRecords('corClusters', array($uclusID), array('cluster' => $friendclus->cluster));
                $str .= "remove and add";
            }
            return "in unknown group (all friendClus#:" . $allFriendClusCount . ") " . $str;
        } else {
            $countCurrent = count($fri->corClusters);
            //   $str = $fri->corClusters[0]->name . " " . $fri->corClusters[1]->name;
            if ($countCurrent == 1) { // two same line because of changing count after remove
                $fri->removeRelationRecords('corClusters', array($clusId));
                $fri->addRelationRecords('corClusters', array($uclusID), array('cluster' => $friendclus->cluster));
            } else {
                $fri->removeRelationRecords('corClusters', array($clusId));
            }
            return "in regular group " . $countCurrent;
        }
    }

    public function loadFBdata($memId) {
        return "salam" + $memId;
    }

// Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */

    /*
      public function filters() {
      return array(
      'accessControl', // perform access control for CRUD operations
      );
      }

      /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    /*
      public function accessRules() {
      return array(
      array('allow', // allow all users to perform 'index' and 'view' actions
      'actions' => array('index', 'intro', 'community', 'alg1', 'alg2'),
      'users' => array('*'),
      ),
      array('deny', // deny all users
      'users' => array('*'),

      ),
      );
      }
     */
}