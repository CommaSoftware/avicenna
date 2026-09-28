<?php
	// Извлекаем и валидируем параметры
	$filial_id = isset($args['filial_id']) ? $args['filial_id'] : '';

	$args = array(
		'post_type'      => 'slides',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'ASC',
	);

	if (!empty($filial_id)) {
		$args = array(
			'post_type' => 'slides',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
					array(
							'key' => '_slides_filial_id',
							'value' => $filial_id,
							'type' => 'NUMERIC',
							'compare' => '='
					)
			),
			'orderby'        => 'date',
			'order'          => 'ASC'
		);
	}

	$slides_query = new WP_Query($args);
?>

<?php if ($slides_query->have_posts()) : ?>
	<section id="slider" class="slider" data-autoslide="3500">
		<div id="sliderButtonLeft" class="slider__nav-button"></div>
		<div id="sliderButtonRight" class="slider__nav-button"></div>
		<?php while ($slides_query->have_posts()) : $slides_query->the_post(); ?>
			<?php
				$post_id = get_the_ID();
				$post_title = get_the_title($post_id);
				$post_thumbnail = get_the_post_thumbnail($post_id, 'full', array(
					'alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(),
					'loading' => 'lazy'
				));
				$post_excerpt = get_the_excerpt($post_id);
				$slides_more_link = get_slides_more_link();
				$slides_book_link = get_slides_book_link();
			?>
			<div class="slider__item content-wrapper is-active-item">
				<div class="slider-item__content">
					<?php if (!empty($post_title)) : ?>
						<h3 class="heading is-size-h1 is-white"><?php echo $post_title; ?></h3>
					<?php endif; ?>
					<?php if (!empty($post_excerpt)) : ?>
						<p class="span is-white"><?php echo $post_excerpt; ?></p>
					<?php endif; ?>
					<?php if (!empty($slides_book_link) || !empty($slides_more_link)) : ?>
						<div class="slider-item-content__buttons">
							<?php if (!empty($slides_book_link)) : ?>
								<a href="<?php echo $slides_book_link; ?>" class="button is-rounded is-wide is-style-accent"
									>Записаться</a
								>
							<?php endif; ?>
							<?php if (!empty($slides_more_link)) : ?>
								<a href="<?php echo $slides_more_link; ?>" class="button is-rounded is-wide"
									>Подробнее</a
								>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<?php if (!empty($post_thumbnail)) : ?>
					<div class="slider-item__image">
						<?php echo $post_thumbnail; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</section>
<?php endif; ?>