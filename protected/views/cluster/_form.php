<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cluster-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'clustering'); ?>
		<?php echo $form->dropDownList($model, 'clustering', GxHtml::listDataEx(Clustering::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'clustering'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->checkBox($model, 'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'sup_cluster'); ?>
		<?php echo $form->textField($model, 'sup_cluster', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'sup_cluster'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'level'); ?>
		<?php echo $form->textField($model, 'level'); ?>
		<?php echo $form->error($model,'level'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('friendClusters')); ?></label>
		<?php // echo $form->checkBoxList($model, 'friendClusters', GxHtml::encodeEx(GxHtml::listDataEx(FriendCluster::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('friendClusters1')); ?></label>
		<?php // echo $form->checkBoxList($model, 'friendClusters1', GxHtml::encodeEx(GxHtml::listDataEx(FriendCluster::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('friends')); ?></label>
		<?php // echo $form->checkBoxList($model, 'friends', GxHtml::encodeEx(GxHtml::listDataEx(Friend::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('corFriends')); ?></label>
		<?php // echo $form->checkBoxList($model, 'corFriends', GxHtml::encodeEx(GxHtml::listDataEx(Friend::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->