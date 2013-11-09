<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'friend-form',
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
		<?php echo $form->labelEx($model,'fbid'); ?>
		<?php echo $form->textField($model, 'fbid', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'fbid'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('friendClusters')); ?></label>
		<?php echo $form->checkBoxList($model, 'friendClusters', GxHtml::encodeEx(GxHtml::listDataEx(FriendCluster::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('links')); ?></label>
		<?php echo $form->checkBoxList($model, 'links', GxHtml::encodeEx(GxHtml::listDataEx(Link::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('links1')); ?></label>
		<?php echo $form->checkBoxList($model, 'links1', GxHtml::encodeEx(GxHtml::listDataEx(Link::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('clusters')); ?></label>
		<?php echo $form->checkBoxList($model, 'clusters', GxHtml::encodeEx(GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('corClusters')); ?></label>
		<?php echo $form->checkBoxList($model, 'corClusters', GxHtml::encodeEx(GxHtml::listDataEx(Cluster::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->