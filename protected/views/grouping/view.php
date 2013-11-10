<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->
<div id="this-carousel-id" class="carousel slide"><!-- class of slide for animation -->
  <div class="carousel-inner">
	<?php for($i = 0; $i < 1; $i++){?>
    <div class="item <?php if($i==0){echo 'active';}?>">
      <div class="cluster-container">
		  <div class="subcluster" id="draggable">
			<img src="https://www.google.com/images/srpr/logo11w.png" >
			<img src="https://www.google.com/images/srpr/logo11w.png" >
			<img src="https://www.google.com/images/srpr/logo11w.png" >
			<img src="https://www.google.com/images/srpr/logo11w.png" >
			<div class="iclear" style="height:10px"></div>
		  </div>
		  <div class="subcluster draggable">
			<img src="https://www.google.com/images/srpr/logo11w.png" >
			<img src="https://www.google.com/images/srpr/logo11w.png" >
			<img src="https://www.google.com/images/srpr/logo11w.png" >
			<img src="https://www.google.com/images/srpr/logo11w.png" >
			<div class="iclear" style="height:10px"></div>
		  </div>
	  </div>
      <div class="carousel-caption">
      </div>
    </div>
    <?php }?>
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
<div id="row">
	<ul class="thumbnails fg-widget">
	  <?php for($i = 0; $i < 5; $i++){?>
	  <li class="span4 finalGroup">
		<h3>Hello world</h3>
	  </li>
	  <?php }?>
	</ul>
</div>

<div id="droppable">Drop here</div>
<div id="draggable">Drag me</div>
<script type="text/javascript">
$( "#draggable" ).draggable();
$( "#droppable" ).droppable({
  drop: function() {
    alert( "dropped" );
  }
});
</script>