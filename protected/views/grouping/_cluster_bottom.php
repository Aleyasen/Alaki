<div class='groups' data-cid=<?php echo $cluster->id; ?>>
    <div><?php echo $cluster->name; ?></div>
    <?php
    foreach ($cluster->clusters as $clus) {
        ?>
        <div>
            <div><?php echo $clus->name; ?></div>
        </div>
    <?php } ?>
</div>
