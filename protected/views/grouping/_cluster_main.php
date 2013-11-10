<li class='cluster' data-type="cluster" data-cid="<?php echo $cluster->id;?>">
    <div class="list">
	<?php
    $max_count = 7;
    foreach ($cluster->corFriends as $fri) {
        if ($max_count == 0)
            break;
        $max_count--;
        ?>
        <div class='friend_div' data-type="user" data-fbid=<?php echo $fri->fbid; ?>>
            <img src='https://graph.facebook.com/<?php echo $fri->fbid; ?>/picture'>
            <div class="name"><?php echo $fri->name; ?></div>
        </div>
    <?php } ?>
	</div>
	<div class="iclear" style="height:5px"></div>
</li>
