<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<?php
//$model->saveClusterMeasures();
?>
<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'fbid',
    // 'createdAt',
    ),
));
?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('clusterings')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->clusterings as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('clustering/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $relatedModel,
        'attributes' => array(
            //    'clusteringError',
            'allClustersSize',
            'allGroundTruthSize',
            'prec',
            'rec',
            'fMeasure',
            'UngroupedSize',
            'UngroupedGTSize',
        ),
    ));

    //*****Comment the following lines if you don't need to overlapped statistics****
    /* if ($relatedModel->algorithm == 5 && $relatedModel->getFMeasure() < 1) {
      print_r($relatedModel->get_overlapped_friends());
      } */
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>


<?php
echo "MCL & Louvain Difference: ";
if (!isset($model->mcl_louvain)) {
    //echo $model->compareGroundtruths(Algorithm::get_MCL(), Algorithm::get_Louvain()) . '<br>';
} else {
    echo $model->mcl_louvain . '<br>';
}

echo "MCL & OSLOM Difference: ";
if (!isset($model->mcl_oslom)) {
    //echo $model->compareGroundtruths(Algorithm::get_MCL(), Algorithm::get_OSLOM()) . '<br>';
} else {
    echo $model->mcl_oslom . '<br>';
}

echo "Louvain & OSLOM Difference: ";
if (!isset($model->louvain_oslom)) {
    //echo $model->compareGroundtruths(Algorithm::get_Louvain(), Algorithm::get_OSLOM()) . '<br>';
} else {
    echo $model->louvain_oslom . '<br>';
}


/*
  echo "MCL & Louvain: ". $model->compareGroundtruths(Algorithm::get_MCL(), Algorithm::get_Louvain()).'<br>';
  echo "MCL & OSLOM: ". $model->compareGroundtruths(Algorithm::get_MCL(), Algorithm::get_OSLOM()).'<br>';
  echo "Louvain & OSLOM: ". $model->compareGroundtruths(Algorithm::get_Louvain(), Algorithm::get_OSLOM()).'<br>';
 *

 */
?>

<!-- 
<h2><?php
echo GxHtml::encode($model->getRelationLabel('friends'));
?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->friends as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('friend/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>
-->