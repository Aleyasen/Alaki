<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('clus_mcl')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->clusMcl)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('clus_louvain')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->clusLouvain)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('clus_oslom')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->clusOslom)); ?>
	<br />

</div>