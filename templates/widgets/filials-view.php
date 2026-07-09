<?php
	$args = array(
		'post_type'      => 'filial',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'ASC'
	);

	$filials_query = new WP_Query($args);
?>


<?php if ($filials_query->have_posts()) : ?>
	<section id="filials" class="filials bg-highlight">
		<div class="content-wrapper is-grid-3 is-scrolled-adaptation">
			<?php while ($filials_query->have_posts()) : $filials_query->the_post(); ?>
				<?php get_template_part('templates/entities/filial-card', null, ['post_id' => get_the_ID()]); ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); wp_reset_query(); ?>
		</div>
	</section>
<?php endif; ?>