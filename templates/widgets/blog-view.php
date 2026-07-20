<?php
	$theme_blog_show_faqs = get_theme_mod("blog__show_faqs", Theme_Defaults::BLOG_SHOW_FAQS);
	$theme_blog_view_show_on_front = get_theme_mod("blog_view__show_on_front", Theme_Defaults::BLOG_VIEW_SHOW_ON_FRONT);
	$theme_blog_view_heading = get_theme_mod("blog_view__heading", Theme_Defaults::BLOG_VIEW_HEADING);
	$theme_blog_view_description = get_theme_mod("blog_view__description", Theme_Defaults::BLOG_VIEW_DESCRIPTION);
	$theme_blog_link = get_theme_mod('blog__link', Theme_Defaults::BLOG_LINK);

	$args = array(
		'posts_per_page' => 8,
		'orderby' => 'date',
		'order' => 'DESC',
		'ignore_sticky_posts' => 0, // 0 - учитывать закреплённые, 1 - игнорировать
	);

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

	$query = new WP_Query($args);
?>

<?php if (is_front_page() && $theme_blog_view_show_on_front || !is_front_page()) : ?>
	<section id="blog_preview">
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
		<?php if ($query->have_posts()) : ?>
			<div class="content-wrapper is-grid-4">
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php get_template_part('templates/entities/blog-card', null, ['post_id' => get_the_ID(), 'show_excerpt' => true]); ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); wp_reset_query(); ?>
		<div class="content-wrapper">
			<div class="buttons-block">
				<a
					href="<?php echo $theme_blog_link; ?>"
					class="button is-style-bordered is-wide is-hilight"
					>Смотреть всё</a
				>
			</div>
		</div>
	</section>
<?php endif; ?>