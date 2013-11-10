<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->
<div id="this-carousel-id" class="carousel slide"><!-- class of slide for animation -->
  <div class="carousel-inner">
    <div class="item active"><!-- class of active since it's the first item -->
      <div class="cluster-container"></div>
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>
    <div class="item">
      <div class="cluster-container"></div>
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>
    <div class="item">
      <div class="cluster-container"></div>
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>
    <div class="item">
      <div class="cluster-container"></div>
      <div class="carousel-caption">
        <p>Caption text here</p>
      </div>
    </div>
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

<?php
foreach ($user->clusterings[0]->clusters as $clus) {
    $this->renderPartial('_friends', array(
        'friends' => $clus->corFriends));
}
?>
<div id="row">
        <ul class="thumbnails fg-widget">
          <li class="span4 finalGroup">
            <h3>Hello world</h3>
          </li>
          <li class="span4 finalGroup">
            <h3>Hello world</h3>
          </li>
          <li class="span4 finalGroup">
            <h3>Hello world</h3>
          </li>
          <li class="span4 finalGroup">
            <h3>Hello world</h3>
          </li>
          <li class="span4 finalGroup">
            <h3>Hello world</h3>
          </li>
        </ul>
</div>