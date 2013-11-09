<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('algorithm')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->algorithm0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('score')); ?>:
	<?php echo GxHtml::encode($data->score); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('user')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('startTime')); ?>:
	<?php echo GxHtml::encode($data->startTime); ?>
	<br />

</div>