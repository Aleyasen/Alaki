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
            
            echo CHtml::button('Create Your Groups', array('class' => 'btn btn-primary btn-large', 'submit' => array('grouping/view')));
        }
        ?>



    </p>
</div>
