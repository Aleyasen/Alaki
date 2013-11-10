<div class='groups'>
    <?php
    foreach ($cluster->clusters as $clus) {
        ?>
        <div class='friend_div'>
            <div><?php echo $clus->name; ?></div>
        </div>
    <?php } ?>
</div>
