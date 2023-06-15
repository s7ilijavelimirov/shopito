<!-- SLIDER -->
<?php if (have_rows('slider')) : $i = 0; ?>
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div class="carousel-inner">
            <?php
            while (have_rows('slider')) : the_row();
                $image = get_sub_field('image');
                $title = get_sub_field('header_title');
                $text = get_sub_field('title');
                $button = get_sub_field('button');
                $button_link = get_sub_field('button_link');
                $image_logo = get_sub_field('image_logo');
            ?>
                <div class="carousel-item <?php if ($i == 0) : echo 'active';
                                            endif; ?>">
                    <div class="slider-item-container">
                        <?php if ($image) : ?>
                            <img src="<?php echo $image; ?>" class="d-block img-fluid w-100" alt="Slider Banner">
                        <?php endif; ?>
                        <div class="slider-text">
                            <?php if ($image_logo) : ?>
                                <img src="<?php echo $image_logo; ?>" class="d-block img-fluid" alt="Slider Banner">
                            <?php endif; ?>
                            <h1><?php echo $title; ?></h1>
                            <p><?php echo $text; ?></p>
                            <?php if ($button) : ?>
                                <?php
                                if ($button_link) {
                                    $link_text = $button_link['title'];
                                    $link_url = $button_link['url'];
                                }
                                ?>
                                <a href="<?php echo $link_url; ?>"><?php echo $link_text; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php $i++;
            endwhile; ?>
        </div>
        <?php if ($i > 1) : ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        <?php endif; ?>
        <?php if (have_rows('slider')) : $b = 0; ?>
            <div class="carousel-indicators">
                <?php while (have_rows('slider')) : the_row(); ?>
                    <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="<?php echo $b; ?>" <?php if ($b == 0) : ?>class="active" aria-current="true" <?php endif; ?>aria-label="Slide <?php echo ($b + 1); ?>"></button>
                <?php $b++;
                endwhile; ?>
            </div>
        <?php endif; ?>
        <?php $my_field_value = get_field('banner_bottom');
        if ($my_field_value) :
            if (have_rows('box_banner')) : ?>
                <div class="container-fluid d-none d-lg-flex">
                    <div class="boxes container d-md-flex flex-md-row d-sm-flex flex-sm-column justify-content-between">
                        <?php while (have_rows('box_banner')) : the_row();
                            $text = get_sub_field('text'); ?>
                            <p class="white"><?php echo $text; ?></p>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif;  ?>

        <?php endif; ?>
    </div>
<?php endif; ?>
<!-- ENDSLIDER -->