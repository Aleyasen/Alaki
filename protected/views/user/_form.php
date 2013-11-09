<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'fbid'); ?>
		<?php echo $form->textField($model, 'fbid', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'fbid'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'createdAt'); ?>
		<?php echo $form->textField($model, 'createdAt'); ?>
		<?php echo $form->error($model,'createdAt'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('clusterings')); ?></label>
		<?php echo $form->checkBoxList($model, 'clusterings', GxHtml::encodeEx(GxHtml::listDataEx(Clustering::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('friends')); ?></label>
		<?php echo $form->checkBoxList($model, 'friends', GxHtml::encodeEx(GxHtml::listDataEx(Friend::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->