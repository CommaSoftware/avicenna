<?php 
	$theme_blog_answer_to_empty = get_theme_mod("blog__answer_to_empty", Theme_Defaults::BLOG_ANSWER_TO_EMPTY);
	$theme_blog_show_sidebar = get_theme_mod("blog_sidebar__show_in_blog", Theme_Defaults::BLOG_SIDEBAR_SHOW_IN_BLOG);

	if ( get_query_var('paged') ) $paged = get_query_var('paged');
	elseif ( get_query_var('page') ) $paged = get_query_var('page');
	else $paged = 1;

	$args = array(
		'post_type' => 'post',
		'paged' => $paged,
	);

	if (is_category()) {
		$args['cat'] = get_queried_object_id();
	}

	$regular_query = new WP_Query($args);
?>

<section id="blog" class="blog">
	<div class="content-wrapper blog__grid">
		<?php if($theme_blog_show_sidebar) : ?>
			<div class="blog-sidebar" style="grid-row: 1 / calc(<?php echo get_blog_posts_per_page();?> / 2 + 2)">
				<?php get_template_part('templates/entities/blog-author') ?>
			</div>
		<?php endif; ?>
		<?php if ($regular_query->have_posts()) : ?>
			<?php	while ($regular_query->have_posts()) : ?>
				<?php	$regular_query->the_post(); ?>
				<?php get_template_part('templates/entities/blog-card', null, ['post_id' => get_the_ID(), 'show_excerpt' => true]); ?>
			<?php endwhile; ?> 
			<?php get_template_part('templates/entities/pagination', null, [ 'query' => $regular_query ]); ?>
		<?php else : ?>
			<span class="span is-size-m"><?php echo $theme_blog_answer_to_empty; ?></span>
		<?php endif; ?>
		<?php wp_reset_postdata(); wp_reset_query(); ?>
	</div>
</section>