<script>
    $(function() {
        $('#myTab2 a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cgroup-grid',
    'dataProvider' => $glist,
    'columns' => array(
        'id',
        array(
            'name' => 'user',
            'value' => 'GxHtml::valueEx($data->user0)',
            'filter' => GxHtml::listDataEx(User::model()->findAllAttributes(null, true)),
        ),
        array(
            'name' => 'clus_mcl',
            'value' => 'GxHtml::valueEx($data->clusMcl)',
            'filter' => GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true)),
        ),
        array(
            'name' => 'clus_louvain',
            'value' => 'GxHtml::valueEx($data->clusLouvain)',
            'filter' => GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true)),
        ),
        array(
            'name' => 'clus_oslom',
            'value' => 'GxHtml::valueEx($data->clusOslom)',
            'filter' => GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true)),
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>


<div class="form">



    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'cgroup-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'user'); ?>
        <?php echo $form->dropDownList($model, 'user', GxHtml::listDataEx(User::model()->findAllAttributes(null, true, 'id=:uid', array(':uid' => $model->user)))); ?>
        <?php echo $form->error($model, 'user'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'clus_mcl'); ?>
        <?php echo $form->dropDownList($model, 'clus_mcl', GxHtml::listDataEx(User::getAlgClusters($model->user, 1)), array('empty' => '--No Cluster--')); ?>
        <?php echo $form->error($model, 'clus_mcl'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'clus_louvain'); ?>
        <?php echo $form->dropDownList($model, 'clus_louvain', GxHtml::listDataEx(User::getAlgClusters($model->user, 4)), array('empty' => '--No Cluster--')); ?>
        <?php echo $form->error($model, 'clus_louvain'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'clus_oslom'); ?>
        <?php echo $form->dropDownList($model, 'clus_oslom', GxHtml::listDataEx(User::getAlgClusters($model->user, 5)), array('empty' => '--No Cluster--')); ?>
        <?php echo $form->error($model, 'clus_oslom'); ?>
    </div><!-- row -->


    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->

<div>

    <ul class="nav nav-tabs" id="myTab2">
        <li><a href="#alg-1-4" data-toggle="tab" class="algtab">MCL->Lvn</a></li>  
        <li><a href="#alg-4-1" data-toggle="tab" class="algtab">Lvn->MCL</a></li>  
        <li><a href="#alg-1-5" data-toggle="tab" class="algtab">MCL->Oslm</a></li>
        <li><a href="#alg-5-1" data-toggle="tab" class="algtab">Oslm->MCL</a></li>  
        <li><a href="#alg-4-5" data-toggle="tab" class="algtab">Lvn->Oslm</a></li>  
        <li><a href="#alg-5-4" data-toggle="tab" class="algtab">Oslm->Louvain</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="alg-1-4"><?php $model->user0->printLL(1, 4); ?></div>
        <div class="tab-pane" id="alg-4-1"><?php $model->user0->printLL(4, 1); ?></div>
        <div class="tab-pane" id="alg-1-5"><?php $model->user0->printLL(1, 5); ?></div>
        <div class="tab-pane" id="alg-5-1"><?php $model->user0->printLL(5, 1); ?></div>
        <div class="tab-pane" id="alg-4-5"><?php $model->user0->printLL(4, 5); ?></div>
        <div class="tab-pane" id="alg-5-4"><?php $model->user0->printLL(5, 4); ?></div>
    </div>