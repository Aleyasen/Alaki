<div style="border:solid black;">
    <?php foreach ($friends as $fri) { ?>
        <div class='members'  fbid=<?php echo $fri->fbid; ?>>
            <img src='https://graph.facebook.com/<?php echo $fri->fbid; ?>/picture'>
            <div><?php echo $fri->name; ?></div>
        </div>
    <?php } ?>
</div>
