<style>
    #sortable { list-style-type: none; margin-bottom:30px ; padding:0 0 0 0; float: left; margin-right: 1px; }
    #sortable li{ margin: 1px 1px 1px 1px; padding: 1px; width: 60px; float: left;  }
</style>


<div class="row buttons">
            <?php echo CHtml::button('Start Clustering!', array('submit' => array('frontend/clustering'))); ?>
</div>

<?php
$this->widget('zii.widgets.jui.CJuiSortable', array(
    'id' => 'sortable',
    'items' => $friends,
    'itemTemplate' => '<li id="{id}"><fb:profile-pic uid="{content}" size="square" facebook-logo="false" linked="false"></fb:profile-pic></li>'
        )
);
?>

