<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('friend')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->friend0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('cluster')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->cluster0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('cor_cluster')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->corCluster)); ?>
	<br />

</div>