<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'clustering-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'algorithm'); ?>
		<?php echo $form->dropDownList($model, 'algorithm', GxHtml::listDataEx(Algorithm::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'algorithm'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'score'); ?>
		<?php echo $form->textField($model, 'score'); ?>
		<?php echo $form->error($model,'score'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->dropDownList($model, 'user', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'startTime'); ?>
		<?php echo $form->textField($model, 'startTime'); ?>
		<?php echo $form->error($model,'startTime'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('clusters')); ?></label>
		<?php echo $form->checkBoxList($model, 'clusters', GxHtml::encodeEx(GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->