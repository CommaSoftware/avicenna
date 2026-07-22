<?php
	$theme_blog_view_show_on_front = get_theme_mod("blog_view__show_on_front", Theme_Defaults::BLOG_VIEW_SHOW_ON_FRONT);
	if (is_front_page() && !$theme_blog_view_show_on_front) { return false; }

	$filial_id = isset($args['filial_id']) ? $args['filial_id'] : '';
	$blog_view_use_pagination = isset($args['use_pagination']) ? to_bool($args['use_pagination']) : false;
	$blog_view_posts_per_page = isset($args['posts_per_page']) ? $args['posts_per_page'] : null;
	
	$theme_blog_show_faqs = get_theme_mod("blog__show_faqs", Theme_Defaults::BLOG_SHOW_FAQS);
	$theme_blog_view_heading = get_theme_mod("blog_view__heading", Theme_Defaults::BLOG_VIEW_HEADING);
	$theme_blog_view_description = get_theme_mod("blog_view__description", Theme_Defaults::BLOG_VIEW_DESCRIPTION);
	$theme_blog_link = get_theme_mod('blog__link', Theme_Defaults::BLOG_LINK);

	$args = array(
		'orderby' => 'date',
		'order' => 'DESC',
	);

	if (!empty($blog_view_posts_per_page)) {
		$args['posts_per_page'] = $blog_view_posts_per_page;
	}

	if (!to_bool($theme_blog_show_faqs)) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => 'faqs',
				'operator' => 'NOT IN'
			)
    );
	}

	if (!empty($filial_id)) {
		$args['meta_query'] = array(
			array(
				'key' => '_post_filial_id',
				'value' => $filial_id,
				'type' => 'NUMERIC',
				'compare' => '='
			)
		);
		$args['ignore_sticky_posts'] = 1;
	}

	if ($blog_view_use_pagination) {
		if ( get_query_var('paged') ) $paged = get_query_var('paged');
		elseif ( get_query_var('page') ) $paged = get_query_var('page');
		else $paged = 1;

		$args['paged'] = $paged;
	}

	$query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>
	<section id="blog_view">
		<div class="content-wrapper">
			<?php if ($theme_blog_view_description != '' || $theme_blog_view_heading != '') : ?>
				<div class="heading-block">
					<?php if ($theme_blog_view_heading != '') : ?>
						<h2 class="heading is-size-h2"><?php echo $theme_blog_view_heading; ?></h2>
					<?php endif; ?>
					<?php if ($theme_blog_view_description != '') : ?>
						<span class="span is-size-m"><?php echo $theme_blog_view_description; ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="content-wrapper is-grid-4">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php get_template_part('templates/entities/blog-card', null, ['post_id' => get_the_ID(), 'show_excerpt' => true]); ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php if ($blog_view_use_pagination) : ?>
			<?php get_template_part('templates/entities/pagination', null, [ 'query' => $query, 'anchor' => '#blog_view' ]); ?>
		<?php else : ?>
			<div class="content-wrapper">
				<div class="buttons-block">
					<a
					href="<?php echo $theme_blog_link; ?>"
					class="button is-style-secondary is-wide"
					>Показать больше</a
					>
				</div>
			</div>
		<?php endif; ?>
	</section>
	<?php endif; ?>
	<?php wp_reset_query(); ?>