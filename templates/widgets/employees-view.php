<?php
	// Извлекаем и валидируем параметры
	$filial_id = isset($args['filial_id']) ? $args['filial_id'] : '';

	$args = array(
		'post_type'      => 'employee',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'ASC'
	);

	if (!empty($filial_id)) {
		$args = array(
			'post_type' => 'employee',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
					array(
							'key' => '_employee_filial_id',
							'value' => $filial_id,
							'type' => 'NUMERIC',
							'compare' => '='
					)
			),
		'orderby'        => 'date',
		'order'          => 'ASC'
		);
	}

	$employee_query = new WP_Query($args);
?>


<?php if ($employee_query->have_posts()) : ?>
	<section id="specialists">
		<div class="content-wrapper">
			<div class="heading-block">
				<h2 class="heading is-size-h2">Наши специалисты</h2>
			</div>
		</div>
		<div class="content-wrapper is-grid-4 is-scrolled-adaptation">
			<?php while ($employee_query->have_posts()) : $employee_query->the_post(); ?>

				<?php
					$employee_title = get_the_title();
					$employee_permalink = get_the_permalink();
					$employee_thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium', array(
						'alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: $employee_title,
						'loading' => 'lazy'
					));
					$employee_position = esc_html(get_employee_position());
					$employee_phone = esc_html(get_employee_phone());
					$employee_appointment_link = esc_url(get_employee_appointment_link());
					$employee_reviews_link = esc_url(get_employee_reviews_link());
					$employee_filial = get_employee_filial_object();
				?>

				<div class="specialist-card">
					<div>
						<?php if (!empty($employee_position)) : ?>
							<span class="span is-size-xs is-highlight"><?php echo $employee_position; ?></span>
						<?php endif; ?>
						<div class="h3 heading is-size-h5"><?php echo $employee_title; ?></div>
					</div>
					<div
						class="flex is-gap-12 is-align-items-end is-justify-sb is-wrap-mobile"
					>
						<div class="specialist-card__cover">
							<?php if (!empty($employee_position)) : ?>
								<?php echo $employee_thumbnail; ?>
							<?php endif; ?>
						</div>
						<div class="flex is-gap-8 is-dir-col is-wide-full">
							<?php if (!empty($employee_filial)) : ?>
								<a
									href="<?php echo get_permalink($employee_filial->ID); ?>"
									class="specialist-card__filial button is-style-transparent is-size-s"
								>
									<span class="icon" data-type="map-pin"></span>
									<?php echo esc_html($employee_filial->post_title); ?>
								</a>
							<?php endif; ?>
							<?php if (!empty($employee_reviews_link)) : ?>
								<a href="<?php echo $employee_reviews_link; ?>" class="button is-size-m is-wide-full">
									<span class="icon" data-type="star"></span>
									Отзывы
								</a>
							<?php endif; ?>
							<a
								href="<?php echo $employee_permalink; ?>"
								class="specialist-card__readmore button is-size-m is-style-bordered is-wide-full"
							>
								Подробнее
								<span class="icon" data-type="chervon-right"></span>
							</a>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); wp_reset_query(); ?>
		</div>
	</section>
<?php endif; ?>