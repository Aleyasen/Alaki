<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cgroup-form',
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
		<?php echo $form->labelEx($model,'clus_mcl'); ?>
		<?php echo $form->dropDownList($model, 'clus_mcl', GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'clus_mcl'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'clus_louvain'); ?>
		<?php echo $form->dropDownList($model, 'clus_louvain', GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'clus_louvain'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'clus_oslom'); ?>
		<?php echo $form->dropDownList($model, 'clus_oslom', GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'clus_oslom'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->