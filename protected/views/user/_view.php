<div class="view">

    <?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
    <?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />

    <?php echo GxHtml::encode($data->getAttributeLabel('fbid')); ?>:
    <?php echo GxHtml::encode($data->fbid); ?>
    <br />
    <?php //echo GxHtml::encode($data->getAttributeLabel('createdAt')); ?>
    <?php //echo GxHtml::encode($data->createdAt); ?>
    <br />

    <?php
    echo "MCL & Louvain Difference: ";
    if (!isset($data->mcl_louvain)) {
        // echo $data->compareGroundtruths(Algorithm::get_MCL(), Algorithm::get_Louvain()) . '<br>';
    } else {
        echo $data->mcl_louvain . '<br>';
    }

    echo "MCL & OSLOM Difference: ";
    if (!isset($data->mcl_oslom)) {
        // echo $data->compareGroundtruths(Algorithm::get_MCL(), Algorithm::get_OSLOM()) . '<br>';
    } else {
        echo $data->mcl_oslom . '<br>';
    }

    echo "Louvain & OSLOM Difference: ";
    if (!isset($data->louvain_oslom)) {
        // echo $data->compareGroundtruths(Algorithm::get_Louvain(), Algorithm::get_OSLOM()) . '<br>';
    } else {
        echo $data->louvain_oslom . '<br>';
    }
    ?>

    <?php
     // $data->saveClusterMeasures();
    ?>





</div>