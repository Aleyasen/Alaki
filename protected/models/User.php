<?php

Yii::import('application.models._base.BaseUser');
ini_set('memory_limit', '-1');

class User extends BaseUser {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function representingColumn() {
        return 'fbid';
    }

    //Likelihood
    public function calcLikelihood($alg1, $alg2) {
        $cing1 = null;
        $cing2 = null;
        foreach ($this->clusterings as $cing) {
            if ($cing->algorithm0->id == $alg1) {
                $cing1 = $cing;
            }
            if ($cing->algorithm0->id == $alg2) {
                $cing2 = $cing;
            }
        }
        if ($cing1 == null || $cing2 == null) {
            echo "one of the clustring is null<br>";
            return;
        }
        $list = array();
        foreach ($cing1->clusters as $c1) {
            if ($c1->corFriendsCount > 0 && $c1->deleted != 1) {
                $list[$c1->id] = $c1->getClustersLikelihood($cing2->clusters);
            }
        }
//        foreach ($list as $key1 => $val1) {
//            foreach ($list as $key2 => $val2) {
//                if ($list[$key1][-1] > $list[$key2][-1]) {
//                    $temp = $list[$key1];
//                    $list[$key1] = $list[$key2];
//                    $list[$key2] = $temp;
//                    
//                }
//            }
//        }
//        echo "<pre>";
//        print_r($list);
//        echo "</pre>";
        return $list;
    }

    public function printLikelihoodList($alg1, $alg2) {
        $threshold = 90;
        $list = $this->calcLikelihood($alg1, $alg2);
        foreach ($list as $clus1 => $list2) {
            $clus1Obj = Cluster::model()->findByPK($clus1);
            if ($list2[-1] == 100) {
                echo "<div style='color:#3251CF'>";
            } else if ($list2[-1] < $threshold) {
                echo "<div style='color:red'>";
            } else {
                echo "<div>";
            }
            echo "<b>" . $clus1Obj->name . "</b>" . " (" . $clus1Obj->corFriendsCount . " " . number_format((float) $list2[-1], 2, '.', '') . "%) => ";
            foreach ($list2 as $clus2 => $count) {
                if ($clus2 != -1) {
                    $clus2Obj = Cluster::model()->findByPK($clus2);
                    echo " [ " . $clus2Obj->name . " (" . $count[0] . " " . number_format((float) $count[1], 2, '.', '') . "%) ]";
                }
            }
            echo "</div>";
            echo "<br>";
        }
    }

    public function printLL($alg1, $alg2) {
        echo "<pre>";
        print_r($this->printLikelihoodList($alg1, $alg2));
        echo "</pre>";
    }

    public function saveClusterMeasures() {
        foreach ($this->clusterings as $clustering) {
            $clustering->saveClusterMeasures();
        }
    }

    public static function lastLogins($fbID) { //returns all of the last logins of this user
        return User::model()->find('fbid=:fbID', array(':fbID' => $fbID));
    }

    public function compareGroundtruths($alg1, $alg2) { // inputs should be in this format: Algorithm::get_MCL()
        foreach ($this->clusterings as $clustering) {
            if ($clustering->algorithm0 == $alg1)
                $clustering1 = $clustering;
            else if ($clustering->algorithm0 == $alg2) {
                //echo 'alg2: '.$alg2.'<br>';
                $clustering2 = $clustering;
            }
        }

        if (!isset($clustering1) || !isset($clustering2))
            return 0;
        if ($clustering1->getFMeasure() == 1 || $clustering2->getFMeasure() == 1)
            return 0;

        $all_friends = $this->create_lists($clustering1, $clustering2);
        $prec = Clustering::getPrec_Base($all_friends);
        $rec = Clustering::getRec_Base($all_friends);
        $f_measure = Clustering::getFMeasure_Base($prec, $rec);

        return 1 - $f_measure;
    }

    public function create_lists($clustering1, $clustering2) {

        $friends_1 = $clustering1->getFriends();
        $friends_2 = $clustering2->getFriends();

        $results = array();

        //   $ff = "";
        foreach ($friends_1 as $f1) {
            $corClusters_id = array();
            foreach ($f1->corClusters as $corClus) {
                $corClusters_id[] = $corClus->id;
            }
            $results[$f1->fbid][0] = $corClusters_id;
            // $ff = $f1->fbid;
        }

        foreach ($friends_2 as $f2) {
            $corClusters_id = array();
            foreach ($f2->corClusters as $corClus) {
                $corClusters_id[] = $corClus->id;
            }
            if (isset($results[$f2->fbid][0]))
                $results[$f2->fbid][1] = $corClusters_id;
        }

        /* echo '<pre>';
          var_dump($results[$ff]);
          echo '</pre>';
         */
        $final_results = array();
        foreach ($results as $key => $value) {
            if (isset($value[0]) && isset($value[1])) {
                $final_results[$key] = $value;
            }
        }
        return $final_results;
    }

    public function fetchFriendsInfo() {
        $fbid = $this->fbid;
        $limit = 100;
        $offset = 0;
        $allinfo = array();
        while (true) {
            $query = "SELECT about_me, activities, affiliations, age_range, birthday_date,
            books, currency, current_address, current_location, devices, education,
            first_name, friend_count, hometown_location, inspirational_people, install_type,
            interests, languages ,last_name, likes_count, locale, meeting_for,meeting_sex,
            middle_name, movies, music, mutual_friend_count, name, notes_count, political,
            profile_blurb, profile_update_time, profile_url,quotes, relationship_status,
            religion,sex, significant_other_id, sports, status, subscriber_count, third_party_id,
            timezone, tv, uid, username, wall_count, website, work, education_history, family,
            favorite_athletes, favorite_teams, games  FROM user WHERE uid in
            (select uid1 from friend where uid2=me() limit " . $limit . " offset " . $offset . ");";
            $friendsInfo = Yii::app()->facebook->api(array(
                'method' => 'fql.query',
                'query' => $query,
            ));
            if (empty($friendsInfo))
                break;
            $offset += $limit;
            $allinfo = array_merge($allinfo, $friendsInfo);
        }


        $proj_path = str_replace('\\', '/', dirname(Yii::app()->getBasePath()) . '/');
        $file = $proj_path . "algorithms\\fbinfo\\" . $fbid . "-" . date("Ymd-His") . "-friends.txt";
        $file_handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);
        fwrite($file_handle, json_encode($allinfo));
        fclose($file_handle);
        echo "<pre>";
        //print_r($allinfo);
        echo "</pre>";
        return "success friendsInfo:" . count($allinfo) . "<br/>";
    }

    public function fetchFriendsPostInfo() {
        $fbid = $this->fbid;
        $limit = 25;
        $offset = 0;
        $allinfo = array();
        while (true) {
            $query = "SELECT action_links, actor_id, app_data, app_id, attachment, attribution, claim_count, comment_info, 
                    created_time, description, description_tags, expiration_timestamp, feed_targeting, filter_key,
                    impressions, likes, message, message_tags, parent_post_id,permalink, place, post_id,
                    promotion_status, share_count, source_id, tagged_ids, target_id, targeting, type,
                    updated_time, via_id, with_location,with_tags FROM stream WHERE source_id IN 
                    (SELECT target_id FROM connection WHERE source_id = me()) limit " . $limit . " offset " . $offset . ";";
            $postsInfo = Yii::app()->facebook->api(array(
                'method' => 'fql.query',
                'query' => $query,
            ));
            if (empty($postsInfo)) {
                echo "empty set for limit:" . $limit . " offset:" . $offset . "<br>";
                //break;
            }

            if ($offset > 200)
                break;

            $offset += $limit;
            $allinfo = array_merge($allinfo, $postsInfo);
        }
        $proj_path = str_replace('\\', '/', dirname(Yii::app()->getBasePath()) . '/');
        $file = $proj_path . "algorithms\\fbinfo\\" . $fbid . "-" . date("Ymd-His") . "-friends-post.txt";
        $file_handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);
        fwrite($file_handle, json_encode($allinfo));
        fclose($file_handle);
        echo "<pre>";
        print_r($allinfo);
        echo "</pre>";
        return "success friendsPostsInfo:" . count($allinfo) . "<br/>";
    }

    public static function get_Alg_Results($alg) {
        // echo 'alg: ' . $alg . '<br>';
        //  if ($this->algorithm0 == Algorithm::get_MCL())     
        $count = 0;
        $sum = 0;
        $users = User::model()->findAll();
        foreach ($users as $u) {
            if ($u->id > 264) { // The participants id starting from 267
                $user_clusterings = $u->clusterings;
                foreach ($user_clusterings as $clustering) {
                    if ($clustering->algorithm0 == $alg) {
                        if ($clustering->getFMeasure() < 1) {
                            $sum += $clustering->getFMeasure();
                            $count++;
                        }
                    }
                }
            }
        }

        echo "<br>" . "# of users: " . $count . "<br>";

        return $sum / $count;
    }

    public static function get_Alg_Comparisons() {

        $comparisons = array(0, 0, 0); // [0]: MCL & Louvain / [1]: MCL & OSLOM / [2]:Louvain & OSLOM 

        $count_mcl_louvain = 0;
        $count_mcl_oslom = 0;
        $count_louvain_oslom = 0;

        $mcl_louvain = 0;
        $mcl_oslom = 0;
        $louvain_oslom = 0;

        $users = User::model()->findAll();
        foreach ($users as $u) {
            if ($u->id > 264 & $u->id != 305) { // The participants id starting from 267 & ID 305 does not finish one yet!
                echo 'user: ' . $u->id . '<br>';

                //****************** Set Users' Algs' Comparisons******************
                if (!isset($u->mcl_louvain)) {
                    $mcl_louvain = $u->compareGroundtruths(Algorithm::get_MCL(), Algorithm::get_Louvain());
                    $u->mcl_louvain = $mcl_louvain;
                }

                if (!isset($u->mcl_oslom)) {
                    $mcl_oslom = $u->compareGroundtruths(Algorithm::get_MCL(), Algorithm::get_OSLOM());
                    $u->mcl_oslom = $mcl_oslom;
                }

                if (!isset($u->louvain_oslom)) {
                    $louvain_oslom = $u->compareGroundtruths(Algorithm::get_Louvain(), Algorithm::get_OSLOM());
                    $u->louvain_oslom = $louvain_oslom;
                }
                $u->save();
                //**********************Calculate the overall Comparisons**************
                if ($u->mcl_louvain > 0) {
                    $count_mcl_louvain++;
                    $comparisons[0] += $u->mcl_louvain;
                }

                if ($u->mcl_oslom > 0) {
                    $count_mcl_oslom++;
                    $comparisons[1] += $u->mcl_oslom;
                }

                if ($u->louvain_oslom > 0) {
                    $count_louvain_oslom++;
                    $comparisons[2] += $u->louvain_oslom;
                }
            }
        }
        //echo "<br>" . "# of users: " . $count . "<br>";       
        $comparisons[0] /= $count_mcl_louvain;
        $comparisons[1] /= $count_mcl_oslom;
        $comparisons[2] /= $count_louvain_oslom;

        return $comparisons;
    }

    public static function get_overlap_information() {
        $users = User::model()->findAll();
        $all_overlaps = array();
        foreach ($users as $u) {
            if ($u->id > 264) {
                $user_clusterings = $u->clusterings;
                foreach ($user_clusterings as $clustering) {
                    if ($clustering->algorithm == 5 & $clustering->getFmeasure() < 1) {//just for Overlapping algorithm
                        $all_overlaps[$u->id] = $clustering->get_overlapped_friends();
                    }
                }
            }
        }

        return $all_overlaps;
    }

    public static function getAlgClusters($userid, $alg) {
        $user = User::model()->findByPK($userid);
        foreach ($user->clusterings as $cing) {
            if ($cing->algorithm == $alg) {
                return $cing->clusters;
            }
        }
    }

}