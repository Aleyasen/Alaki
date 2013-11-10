<div class='groups'>
    <div><?php echo $cluster->name; ?></div>
    <?php
    $max_count = 9;
    foreach ($cluster->clusters as $clus) {
        foreach ($clus->corFriends as $fri) {
            if ($max_count == 0) {
                break;
            }
            $max_count--;
            ?>
            <div class='friend_div' data-type='user' data-cid=<?php echo $cluster->id; ?> data-id=<?php echo $fri->id; ?> data-fbid=<?php echo $fri->fbid; ?>>
                <img src='https://graph.facebook.com/<?php echo $fri->fbid; ?>/picture'>
                <div class="name"><?php echo $fri->name; ?></div>
            </div>

            <?php
        }
    }

    foreach ($cluster->corFriends as $fri) {
        if ($max_count == 0) {
            break;
        }
        $max_count--;
        ?>
        <div class='friend_div' data-type='user' data-cid=<?php echo $cluster->id; ?> data-id=<?php echo $fri->id; ?> data-fbid=<?php echo $fri->fbid; ?>>
            <img src='https://graph.facebook.com/<?php echo $fri->fbid; ?>/picture'>
            <div class="name"><?php echo $fri->name; ?></div>
        </div>

        <?php
    }
    ?>
</div>
