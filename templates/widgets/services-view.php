<?php
	// Извлекаем и валидируем параметры
	$filial_id = isset($args['filial_id']) ? $args['filial_id'] : '';
	$service_type = isset($args['service_type']) ? $args['service_type'] : '';

	if (empty($service_type)) { return false; }

	$args = array(
		'post_type'      => 'service',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'ASC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'service_types',
				'field'    => 'slug',
				'terms'    => $service_type,
			),
    ),
	);

	if (!empty($filial_id)) {
		$args = array(
			'post_type' => 'service',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
					array(
							'key' => '_service_filial_id',
							'value' => $filial_id,
							'type' => 'NUMERIC',
							'compare' => '='
					)
			),
			'tax_query'      => array(
				array(
					'taxonomy' => 'service_types',
					'field'    => 'slug',
					'terms'    => $service_type,
				),
			),
			'orderby'        => 'date',
			'order'          => 'ASC'
		);
	}

	$service_query = new WP_Query($args);
	$service_term = get_term_by( 'slug', $service_type, 'service_types' );
	$service_term_name = $service_term->name;
	$service_term_description = $service_term->description;
?>


<?php if ($service_query->have_posts()) : ?>
	<section id="services_<?php echo $service_type; ?>">
		<div class="content-wrapper">
			<div class="heading-block">
				<h2 class="heading is-size-h2"><?php echo $service_term_name; ?></h2>
				<?php if(!empty($service_term_description)) : ?>
					<span class="span"><?php echo $service_term_description; ?></span>
				<?php endif; ?>
			</div>
		</div>
		<div class="content-wrapper is-grid-4 is-scrolled-adaptation">
			<?php while ($service_query->have_posts()) : $service_query->the_post(); ?>
				<?php get_template_part('templates/entities/service-card', null, ['post_id' => get_the_ID()]); ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</section>
<?php endif; ?>