<div class='groups' style="background-color: yellow;">
    <?php
    $max_count = 7;
    foreach ($friends as $fri) {
        if ($max_count == 0)
            break;
        $max_count--;
        ?>
        <div class='friend_div'  fbid=<?php echo $fri->fbid; ?>>
            <img src='https://graph.facebook.com/<?php echo $fri->fbid; ?>/picture'>
            <div><?php echo $fri->name; ?></div>
        </div>
<?php } ?>
</div>
