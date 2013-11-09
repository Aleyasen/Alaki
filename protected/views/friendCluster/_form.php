<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'friend-cluster-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'friend'); ?>
		<?php echo $form->dropDownList($model, 'friend', GxHtml::listDataEx(Friend::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'friend'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'cluster'); ?>
		<?php echo $form->dropDownList($model, 'cluster', GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'cluster'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'cor_cluster'); ?>
		<?php echo $form->dropDownList($model, 'cor_cluster', GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'cor_cluster'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->