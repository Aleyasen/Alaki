<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />


        <?php
        Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.livequery.min.js');
        Yii::app()->clientScript->registerCssFile('http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bs/css/bootstrap.min.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bs/js/bootstrap.min.js');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bs-editable/css/bootstrap-editable.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bs-editable/js/bootstrap-editable.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.slimscroll.min.js');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/font-awesome/css/font-awesome.min.css');
        ?>


        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>


        <div class="container" id="page">


            <div>
                <div><?php //echo CHtml::encode(Yii::app()->name);        ?>
                    <img src='<?php echo Yii::app()->request->baseUrl; ?>/images/banner.png'></img>
                </div>
            </div><!-- header -->

            <div class="row buttons" style="float: right; margin:2px;">
                <?php
                $scope = 'email,user_about_me,
                            user_actions.books,user_actions.music,user_actions.news,
                            user_actions.video,user_activities,user_birthday,	
                            user_education_history,user_events,user_games_activity,	
                            user_groups,user_hometown,user_interests,
                            user_likes,user_location,user_notes,
                            user_photos,user_questions,user_relationship_details,
                            user_relationships,user_religion_politics,user_status,
                            user_subscriptions,user_videos,user_website,
                            user_work_history,
                            friends_about_me,friends_actions.books,friends_actions.music,
                            friends_actions.news,friends_actions.video,friends_activities,friends_birthday,
                            friends_education_history,friends_events,friends_games_activity,friends_groups,
                            friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,
                            friends_photos,friends_questions,friends_relationship_details,friends_relationships,
                            friends_religion_politics,friends_status,friends_subscriptions,friends_videos,
                            friends_website,friends_work_history,
                            read_stream';
                if (Yii::app()->facebook->isUserLogin())
                    echo CHtml::button('Logout', array('class' => 'btn', 'submit' => Yii::app()->facebook->getLogoutUrl(array('next' => Yii::app()->getBaseUrl(true) . '/index.php/frontend/intro'))));
                else
                    echo CHtml::button('Login with Facebook', array('class' => 'btn', 'submit' => Yii::app()->facebook->getLoginUrl(array('scope' => $scope, 'redirect_uri' => Yii::app()->getBaseUrl(true) . '/index.php/frontend/intro'))));
                ?>
            </div>

            <div id="mainmenu" class="navbar">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => 'Home', 'url' => array('/frontend/intro')),
                        array('label' => 'Terms & Conditions', 'url' => array('/frontend/terms')),
                        array('label' => 'Guidelines', 'url' => array('/frontend/guides')),
                        // array('label' => 'About', 'url' => array('/frontend/intro')),
                        array('label' => 'Contact', 'url' => array('/site/contact'), 'template' => '| {menu}'),
                    //    array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                    //    array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                ));
                ?>
            </div><!-- mainmenu -->
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
