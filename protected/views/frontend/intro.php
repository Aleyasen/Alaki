<?php
Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.livequery.min.js');
Yii::app()->clientScript->registerCssFile('http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bs/css/bootstrap.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bs/js/bootstrap.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bs-editable/css/bootstrap-editable.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bs-editable/js/bootstrap-editable.min.js');
?>

<?php
/* @var $this FrontendController */
/* @var $user User */
Yii::log($user);
?>


<div class="hero-unit">
    <h2>Group Detection</h2>
    <p>Although there are dozens of community detection algorithms, we lack real community structures necessary to create reliable benchmarks for evaluation of such clustering algorithms.
        Here, We developed a Facebook application to explore common community detection algorithms. You can create your groups of your Facebook friends by these algorithms and then revise them to make a perfect grouping.
    </p>
    <p>

        <?php
        $fbID = Yii::app()->facebook->getUser();
        if ((Yii::app()->facebook->isUserLogin())) {
            //For the version of two separate phases 
            /*  echo CHtml::button('Create Your Groups', array('class' => 'btn btn-primary btn-large', 'submit' => array('frontend/thanks')));
              echo  '<br>';
              if ((sizeof(User::lastLogins($fbID)) != 0)) { //Further Login
              echo CHtml::button('Go to Your Groups', array('class' => 'btn btn-primary btn-large', 'submit' => array('frontend/clustering')));
              //TODO: Must show all the logins informations
              }
             */
            
            echo CHtml::button('Create Your Groups', array('class' => 'btn btn-primary btn-large', 'submit' => array('frontend/clusteringall')));
        }
        ?>



    </p>
</div>
