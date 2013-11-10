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



<div class="container-fluid">
    <div class="cluster-zone row" id="cluster-zone">
        <?php
        //$count = 3;
        foreach ($user->clusterings[0]->clusters as $clus) {
            ?>

            <?php
//                if ($count == 0) {
//                    break;
//                }
//                $count--;
            $this->renderPartial('_cluster_main', array(
                'cluster' => $clus));
            ?>

        <?php } ?>
        <div class="iclear" ></div>
    </div>
    <div class="iclear"></div>
    <div class="group-zone row">
        <ul id="bottom-list" class="thumbnails fg-widget">
            <?php
            foreach ($user->clusterings[0]->clusters as $clus) {
                if ($clus->level == 1) {
                    ?>
                    <li class="span4 group finalGroup" style="background-color: blue;" data-cid=<?php echo $clus->id; ?>>
                        <?php
                        $this->renderPartial('_cluster_bottom', array(
                            'cluster' => $clus));
                        ?>
                        <div id="og" data-cid="og">
                            <div class="list"></div>
                            <div class="iclear" style="height:5px"></div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>

<script type="text/javascript">
  $url_moveFriend = "<?php echo Yii::app()->createUrl('grouping/moveFriend'); ?>";
  $url_moveCluster = "<?php echo Yii::app()->createUrl('grouping/moveCluster'); ?>";
  $url_showCluster = "<?php echo Yii::app()->createUrl('grouping/showCluster'); ?>";
</script>>