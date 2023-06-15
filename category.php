<?php

/**
 * The template for displaying all single posts and attachments
 */

get_header();

$args = array(
	'post_type' => 'page',
	'pagename' => 'kategorije',


);
$loop = new WP_Query($args);
if ($loop->have_posts()) :
	while ($loop->have_posts()) : $loop->the_post(); ?>
		<div class="container-fluid p-0">
			<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">
					<?php
					if (have_rows('slider')) :
						$i = 0;
						while (have_rows('slider')) : the_row();
							$image = get_sub_field('slika'); ?>
							<div class="carousel-item <?php if ($i == 0) : echo 'active';
														endif; ?>">
								<img class="img-fluid w-100" src="<?php echo $image; ?>">
							</div>
							<?php if ($i != 0) : ?>
								<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</button>
								<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</button>

					<?php
							endif;
							$i++;
						endwhile;
					endif;
					?>
				</div>
			</div>
		</div>
<?php

	endwhile;
endif;
wp_reset_postdata(); ?>


<div class="container-md">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-8 p-0">
			<h3>
				<?php foreach ((get_the_category()) as $category) {
					echo $category->cat_name . ' ';
				} ?>
			</h3>
			<?php
			$current_page = get_queried_object();
			$category     = $current_page->post_name;

			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$category1 = get_category(get_query_var('cat'));
			$cats = $category1->cat_ID;
			$args = array(
				'paged'         => $paged,
				//'category_name' => $category,
				'cat' => $cats,
				'order'         => 'DESC',
				'post_type'     => 'post',
				'post_status'   => 'publish',

			);

			$loop = new WP_Query($args);
			if ($loop->have_posts()) :
				while ($loop->have_posts()) : $loop->the_post(); ?>
					<div class="left-sidebar">
						<p class="date"><?php the_date(); ?></p>
						<h1><?php echo wp_strip_all_tags(get_the_title()); ?></h1>
						<?php $url =  get_the_post_thumbnail_url(); ?>
						<a href="<?php echo the_permalink() ?>">
							<?php if ($url) : ?>
								<img class="img-responsive w-100 single" src="<?php echo $url; ?>" alt="<?php the_title(); ?>">
							<?php endif; ?>
							<p><?php $text = wp_strip_all_tags(get_the_content());
								echo wp_trim_words($text, 60, '[ ... ]'); ?></p>
						</a>
						<script>
							var element = document.querySelector(".modula-gallery");
							element.remove();
						</script>
					</div>

				<?php

				endwhile;
				?>
				<nav class="navigation post-navigation">
					<div class="nav-links">
						<div class="nav-previous">
							<?php
							previous_posts_link('<span class="meta-nav links" aria-hidden="true"><i class="fa-solid fa-circle-chevron-left"></i>Предходна страна</span>');
							?>
						</div>
						<div class="nav-next">
							<?php next_posts_link('<span class="meta-nav links" aria-hidden="true">Следећа страна<i class="fa-solid fa-circle-chevron-right"></i></span>', $query->max_num_pages); ?>
						</div>
					</div>
				</nav>
			<?php
			endif;

			wp_reset_postdata();
			?>

		</div>
		<div class="col-sm-12 col-md-12 col-lg-4 p-0">
			<?php get_template_part('sidebar'); ?>
		</div>
	</div>
</div>

<?php

wp_reset_postdata();
get_footer();
