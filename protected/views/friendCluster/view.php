<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
array(
			'name' => 'friend0',
			'type' => 'raw',
			'value' => $model->friend0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->friend0)), array('friend/view', 'id' => GxActiveRecord::extractPkValue($model->friend0, true))) : null,
			),
array(
			'name' => 'cluster0',
			'type' => 'raw',
			'value' => $model->cluster0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->cluster0)), array('cluster/view', 'id' => GxActiveRecord::extractPkValue($model->cluster0, true))) : null,
			),
array(
			'name' => 'corCluster',
			'type' => 'raw',
			'value' => $model->corCluster !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->corCluster)), array('cluster/view', 'id' => GxActiveRecord::extractPkValue($model->corCluster, true))) : null,
			),
	),
)); ?>

