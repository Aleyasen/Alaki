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
			'name' => 'user0',
			'type' => 'raw',
			'value' => $model->user0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->user0)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->user0, true))) : null,
			),
array(
			'name' => 'clusMcl',
			'type' => 'raw',
			'value' => $model->clusMcl !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->clusMcl)), array('cluster/view', 'id' => GxActiveRecord::extractPkValue($model->clusMcl, true))) : null,
			),
array(
			'name' => 'clusLouvain',
			'type' => 'raw',
			'value' => $model->clusLouvain !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->clusLouvain)), array('cluster/view', 'id' => GxActiveRecord::extractPkValue($model->clusLouvain, true))) : null,
			),
array(
			'name' => 'clusOslom',
			'type' => 'raw',
			'value' => $model->clusOslom !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->clusOslom)), array('cluster/view', 'id' => GxActiveRecord::extractPkValue($model->clusOslom, true))) : null,
			),
	),
)); ?>

