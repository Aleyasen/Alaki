<div class="row">

    <div id="myCarousel" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <!-- Carousel items -->
        <div class="carousel-inner">
            <div class="active item"><div class="carousel-caption">Hello World</div>
                <div class="carousel-caption">Hello World</div>

            </div>
            <div class="item"><div class="carousel-caption">Hello World1</div></div>
            <div class="item"><div class="carousel-caption">Hello World2</div></div>
        </div>
        <!-- Carousel nav -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>

    <?php
    echo $user->clusterings;
    ?>

</div>
