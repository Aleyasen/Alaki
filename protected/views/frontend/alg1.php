<?php
/* @var $this FrontendController */
/* @var $user User */
?>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.jeditable.js');
?>
<script type="text/javascript">
    (function($) {
        $(function() {
            $("#accordion > div").accordion({ heightStyle: "content", header: "h3", collapsible: true });
        })
    })(jQuery);
</script>

<script>
    $(document).ready(function() {
        $('.click').editable('#', {
            indicator : 'Saving...',
            tooltip   : ' '
        });
    });
</script>

<?php
//echo get_class($user);
//echo get_class($user->clusterings[0]);
//echo get_class($user->clusterings[0]->clusters[0]);

$csize = sizeof($user->clusterings[0]->clusters);


echo '<style>';
for ($i = 0; $i < $csize; $i++) {
    echo '#sortable' . $i . ' { list-style-type: none; margin-bottom:30px ; padding:0 0 0 0; float: left; margin-right: 1px; }';
    echo '#sortable' . $i . ' li { margin: 1px 1px 1px 1px; padding: 1px; width: 60px; float: left;  }';
}
echo '</style>';
$items = array();
echo '<div id="accordion">';
for ($i = 0; $i < $csize; $i++) {
    echo '<div>';
    $items[$i] = $this->friendIdList($user->clusterings[0]->clusters[$i]->friends);
    echo '<h3>';
    //echo '<div class="click" style="display: inline;margin-left: 25px;"></div>';
    echo '<div id="ndiv' . $i . '" style="margin-left: 25px;">Cluster #' . ($i + 1) . '</div>';
    echo '</h3>';
    $height = 100 + 55 * floor((sizeof($items[$i])) / 12);
    echo '<div style="overflow:hidden">';

    echo '<div>';
    echo 'Name ';
    echo CHtml::textField('Text', '', array('id' => 'nameDiv' . $i));
    echo '</div>';

    echo '<div style="height:' . $height . 'px;overflow:auto">';
    $this->widget('zii.widgets.jui.CJuiSortable', array(
        'id' => 'sortable' . $i,
        'items' => $items[$i],
        'itemTemplate' => '<li id="{id}"><fb:profile-pic uid="{content}" size="square" facebook-logo="false" linked="false"></fb:profile-pic></li>',
        'options' => array(
            'connectWith' => '.connectedSortable',
        ),
        'htmlOptions' => array(
            'class' => 'connectedSortable',
            'style' => 'height:70%;',
        ),
    ));
    echo '</div></div>';
    echo '</div>';
}
echo '</div>';
?>

<div class="row buttons" style="float:right">
    <?php echo CHtml::button('Next', array('submit' => array('frontend/alg2')));
    ?>
</div>
<div class="row buttons" style="float:left">

    <?php
    echo CHtml::AjaxButton(
            'Done', array('frontend/alg1'), array('data' =>
        array('items0' => 'js:$("#sortable0 li").map(function(i,n) {return $(n).attr(\'id\');}).get()',
            'items1' => 'js:$("#sortable1 li").map(function(i,n) {return $(n).attr(\'id\');}).get()',
            'items2' => 'js:$("#sortable2 li").map(function(i,n) {return $(n).attr(\'id\');}).get()',
            'items3' => 'js:$("#sortable3 li").map(function(i,n) {return $(n).attr(\'id\');}).get()',
            'items4' => 'js:$("#sortable4 li").map(function(i,n) {return $(n).attr(\'id\');}).get()',
            'items5' => 'js:$("#sortable4 li").map(function(i,n) {return $(n).attr(\'id\');}).get()',
            'items6' => 'js:$("#sortable4 li").map(function(i,n) {return $(n).attr(\'id\');}).get()',
            'c0name' => 'js:$("#nameDiv0").val()',
            'c1name' => 'js:$("#nameDiv1").val()',
            'c2name' => 'js:$("#nameDiv2").val()',
            'c3name' => 'js:$("#nameDiv3").val()',
            'c4name' => 'js:$("#nameDiv4").val()',
            'c5name' => 'js:$("#nameDiv5").val()',
            'c6name' => 'js:$("#nameDiv6").val()'),
        'type' => 'POST')
    );
    ?>

</div>


