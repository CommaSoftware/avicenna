<?php
/**
 * Template Name: Запись по умолчанию
 * Template post type: post
 */
?>

<?php get_header(); ?>

<?php
	$theme_post_show_sidebar = get_theme_mod("blog_sidebar__show_in_post", Theme_Defaults::BLOG_SIDEBAR_SHOW_IN_POST);
?>

<?php if( have_posts() ) : the_post(); ?>
	<article id="content">
		<?php get_template_part('templates/entities/single-header') ?>
		<?php get_template_part('templates/entities/single-content', null, ['show_sidebar' => $theme_post_show_sidebar]) ?>
	</article>
<?php wp_reset_postdata(); endif; ?>

<?php get_footer(); ?>
