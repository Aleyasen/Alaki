<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('ID')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->ID), array('view', 'id' => $data->ID)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('friend_1')); ?>:
	<?php echo GxHtml::encode($data->friend_1); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('friend_2')); ?>:
	<?php echo GxHtml::encode($data->friend_2); ?>
	<br />

</div>