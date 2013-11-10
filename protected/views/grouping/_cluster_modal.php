<?php
//$count = 3;
foreach ($cluster->clusters as $subclus) {
    ?>

    <?php
    $this->renderPartial('_cluster_main', array(
        'cluster' => $subclus));
    ?>

<?php } ?>

<?php
    $this->renderPartial('_cluster_main', array(
        'cluster' => $cluster));
    ?>
<div class="iclear" ></div>
