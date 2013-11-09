<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'link-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->dropDownList($model, 'user', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'friend_1'); ?>
		<?php echo $form->textField($model, 'friend_1', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'friend_1'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'friend_2'); ?>
		<?php echo $form->textField($model, 'friend_2', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'friend_2'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->