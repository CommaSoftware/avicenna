<?php
/**
 * Template Name: Страница по умолчанию
 * Template post type: page
 */
?>

<?php get_header(); ?>

<?php if( have_posts() ) : the_post(); ?>
	<article id="content">
		<?php get_template_part('templates/entities/single-header', null, ['show_blog_link' => false, 'show_time' => false, 'style' => 'secondary']) ?>
		<?php get_template_part('templates/entities/single-content', null, ['show_sidebar' => false]) ?>
	</article>
<?php wp_reset_postdata(); endif; ?>

<?php get_footer(); ?>
