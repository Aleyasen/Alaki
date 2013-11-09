<?php
$this->breadcrumbs = array(
    User::label(2),
    Yii::t('app', 'Index'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create') . ' ' . User::label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Manage') . ' ' . User::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(User::label(2)); ?></h1>

<?php
//echo 'MCL: '.User::get_Alg_Results(Algorithm::get_MCL()).'<br>';
//echo 'Louvain: '. User::get_Alg_Results(Algorithm::get_Louvain()).'<br>';
//echo 'OSLOM: '. User::get_Alg_Results(Algorithm::get_OSLOM()).'<br>'; 

//$comparisons = User::get_Alg_Comparisons();

//echo "Average MCL & Louvain Difference : " . $comparisons[0] . '<br>';
//echo "Average MCL & OSLOM Difference: " . $comparisons[1] . '<br>';
//echo "Average Louvain & OSLOM Difference: " . $comparisons[2] . '<br>';
?>

<?php
//****************Overlapping Friends************
/*echo '<br>';
echo "Ovelapped Friends: ".'<br>';
$overlapped_friends = User::get_overlap_information();

foreach ($overlapped_friends as $key => $value) {
    echo $key . ': ';
    print_r($value);
    echo '<br>';
}*/

?>



<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
