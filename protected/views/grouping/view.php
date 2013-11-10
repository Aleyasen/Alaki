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
    <div class="cluster-zone" id="cluster-zone">
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




    function addDragDrop() {
        colors = ["#E7987E",
            "#72DB44",
            "#E37FE7",
            "#78D7C5",
            "#EAA134",
            "#65DA8A",
            "#CBC2C1",
            "#B9A5E3",
            "#CAD73D",
            "#E893B4",
            "#9BB485",
            "#82BFE0",
            "#AFD26F",
            "#D3B55E",
            "#DAE0AB"];
        alert(colors);
        $('#bottom-list li').each(function(index) {
            $(this).css('background-color', colors[index]);
        });


        $(".cluster").draggable({
            revert: true
        });
        $(".group").droppable({
            hoverClass: "drop-hover",
            accept: ".cluster,.friend_div",
            drop: function(event, ui) {
                if (ui.draggable.attr('data-type') == "user") {
                    //$(this).find("#og").append(ui.draggable.html());
                    ui.draggable.detach().appendTo($(this).find("#og .list"));
                    $cid = $(this).attr('data-cid');
                    $this = $(this);
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('grouping/moveFriend'); ?>",
                        data: {friendId: ui.draggable.attr('data-id'), sourceId: ui.draggable.attr('data-cid'), destId: $cid},
                        success: function(msg) {
                            $this.html(msg);
                        },
                        error: function(xhr) {
                            alert("failure" + xhr.readyState + this.url)
                        }
                    });
                }
                else {
                    ui.draggable.detach().appendTo($(this));
                    $cid = $(this).attr('data-cid');
                    $this = $(this);
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('grouping/moveCluster'); ?>",
                        data: {clusId: ui.draggable.attr('data-cid'), destId: $cid},
                        success: function(msg) {
                            $this.html(msg);
                        },
                        error: function(xhr) {
                            alert("failure" + xhr.readyState + this.url)
                        }
                    });
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

        $(".groups").click(function(event) {
            $cid = $(event.target).attr('data-cid');
            if ($cid == null) {
                $cid = $(event.target).parent().attr('data-cid');
            }
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('grouping/showCluster'); ?>",
                data: {clusId: $cid},
                success: function(msg) {
                    $('#cluster-zone').html(msg);
                },
                error: function(xhr) {
                    alert("failure" + xhr.readyState + this.url)
                }
            });
        });
    }
    $(document).ready(function() {
        addDragDrop();
        console.log("Document loaded");
    });
    $(document).ajaxComplete(function() {
        addDragDrop();
    });

</script>
