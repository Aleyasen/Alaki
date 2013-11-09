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

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array(
            'name' => 'algorithm0',
            'type' => 'raw',
            'value' => $model->algorithm0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->algorithm0)), array('algorithm/view', 'id' => GxActiveRecord::extractPkValue($model->algorithm0, true))) : null,
        ),
        'score',
        array(
            'name' => 'user0',
            'type' => 'raw',
            'value' => $model->user0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->user0)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->user0, true))) : null,
        ),
        'AllClustersSize',
        'AllGroundTruthSize',
     //   'startTime',
    ),
));
?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('clusters')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->clusters as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('cluster/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $relatedModel,
        'attributes' => array(
            'GroundTruthSize',
            'ClusterSize',
          //  'AddedFriendsCount',
          //  'DeletedFriendsCount',
        // 'createdAt',
        ),
    ));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>