<style>
    #sortable1, #sortable2 { list-style-type: none; margin-bottom:30px ; padding:0 0 0 0; float: left; margin-right: 1px; }
    #sortable1 li, #sortable2 li{ margin: 1px 1px 1px 1px; padding: 1px; width: 60px; float: left;  }
</style>

<?php
/* @var $this FrontendController */

$this->breadcrumbs = array(
    'Frontend',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
    You may change the content of this page by modifying
    the file <tt><?php echo __FILE__; ?></tt>.
</p>

<div class="form">

    <?php
//print_r($edges);
    ?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'cluster-form',
        'enableAjaxValidation' => false,
            ));
    ?>



    <?php
    $this->widget('zii.widgets.jui.CJuiSortable', array(
        'id' => 'sortable1',
        'items' => $model['items1'],
        'itemTemplate' => '<li id="{id}"><img src="{content}" /></li>',
        'options' => array(
            'connectWith' => '.connectedSortable'
        ),
        'htmlOptions' => array(
            'class' => 'connectedSortable',
        ),
    ));


    $this->widget('zii.widgets.jui.CJuiSortable', array(
        'id' => 'sortable2',
        'items' => $model['items2'],
        'itemTemplate' => '<li id="{id}"><img src="{content}" /></li>',
        'options' => array(
            'connectWith' => '.connectedSortable',
        ),
        'htmlOptions' => array(
            'class' => 'connectedSortable',
        ),
    ));
    
    ?>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Cluster'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>