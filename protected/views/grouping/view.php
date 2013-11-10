<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->

<?php /* <div id="this-carousel-id" class="carousel slide" style="z-index:999;position:relative;top:10px"><!-- class of slide for animation -->
  <div class="carousel-inner">
  <?php for ($i = 0; $i < 1; $i++) { ?>
  <div class="item <?php if ($i == 0) {echo 'active';}?>">
  <div class="cluster-container">
 */ ?>

<?php /* 				</div>
  <div class="carousel-caption">
  </div>
  </div>
  <?php } ?>
  </div><!-- /.carousel-inner -->
  <!--  Next and Previous controls below
  href values must reference the id for this carousel -->
  <a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
  </div><!-- /.carousel -->
  <script>
  $(document).ready(function() {
  $('.carousel').carousel('pause');
  });
  </script>
 */ ?>
<?php /*
  <div id="row" style="z-index:100;position:relative;">
  <ul class="thumbnails fg-widget">

  <ul>
  <?php for ($i = 0; $i < 5; $i++) { ?>
  <li class="span4 finalGroup">
  <h3>Hello world</h3>
  </li>
  <?php } ?>
  </ul>
  </ul>
  </div>
 */ ?>
</div>



<div class="main">
    <div class="cluster-zone">
        <?php
        $count = 3;
        foreach ($user->clusterings[0]->clusters as $clus) {
            ?>
            <ul>
                <?php
                if ($count == 0) {
                    break;
                }
                $count--;
                $this->renderPartial('_cluster_main', array(
                    'cluster' => $clus));
                ?>
                <div class="iclear" style="height:10px"></div>
            </ul>
        <?php } ?>
        <div class="iclear" ></div>
    </div>
    <div class="iclear"></div>
    <div class="group-zone">
        <ul>
            <?php foreach ($user->clusterings[0]->clusters as $clus) { ?>
                <li class="group">
                    <?php
                    $this->renderPartial('_cluster_bottom', array(
                        'cluster' => $clus));
                    ?>
					<div id="og" data-cid="og"></div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>


<script type="text/javascript">
    $(".cluster").draggable({
		revert: true
	});
    $(".group").droppable({
		hoverClass: "drop-hover",
        accept: ".cluster,.friend_div",
        drop: function(event, ui) {
			if(ui.draggable.attr('data-type') == "user"){
				//$(this).find("#og").append(ui.draggable.html());
				ui.draggable.detach().appendTo($(this).find("#og"));
			}
			else{
				ui.draggable.detach().appendTo($(this));
			}
        }
    });
	

    $(".friend_div").draggable({
		revert: true
	});
    $(".cluster").droppable({
		hoverClass: "drop-hover",
        accept: ".friend_div",
        drop: function(event, ui) {
          ui.draggable.detach().appendTo($(this).find(".list"));
        }
    });
</script>

</script>
