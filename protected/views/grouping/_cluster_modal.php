<?php
//$count = 3;
foreach ($cluster->clusters as $subclus) {
    ?>

    <?php
//                if ($count == 0) {
//                    break;
//                }
//                $count--;
    $this->renderPartial('_cluster_main', array(
        'cluster' => $subclus));
    ?>

<?php } ?>
<div class="iclear" ></div>
