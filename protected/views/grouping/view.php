<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->
<div style="position:absolute">

	
				<div class="item ">
					<div class="cluster-container">

						<?php $count = 3; foreach ($user->clusterings[0]->clusters as $clus) {  ?>
							<div class="subcluster draggable">
								<?php
								if ($count == 0) {break;}
								$count--;
								$this->renderPartial('_friends', array(
									'friends' => $clus->corFriends));
								?>
								<div class="iclear" style="height:10px"></div>
							</div>
						<?php } ?>
					</div>
					<div class="carousel-caption">
					</div>
				</div>

		<!--  Next and Previous controls below
			  href values must reference the id for this carousel -->
		<a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
	
	<script>
		$(document).ready(function() {
			$('.carousel').carousel('pause');
		});
	</script>

	<div id="row" style="z-index:100;position:relative;">
		<ul class="thumbnails fg-widget">
			<?php for ($i = 0; $i < 5; $i++) { ?>
				<li class="span4 finalGroup">
					<h3>Hello world</h3>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>
<div id="droppable">Drop here</div>
<div id="draggable">Drag me</div>
<script type="text/javascript">
    $(".draggable").draggable();
    $(".finalGroup").droppable({
		hoverClass: "drop-hover",
        drop: function() {
            alert("dropped");
        }
    });
</script>
