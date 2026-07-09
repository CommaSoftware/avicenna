<?php
/**
 * Template Name: Страница по умолчанию
 * Template post type: page
 */
?>

<?php get_header(); ?>

<?php if( have_posts() ) : the_post(); ?>
	<article id="content">
		<?php get_template_part('templates/entities/single-header', null, ['show_blog_link' => false]) ?>
		<?php get_template_part('templates/entities/single-content') ?>
	</article>
<?php wp_reset_postdata(); endif; ?>

<?php get_template_part("templates/widgets/blog-view"); ?>
<?php get_template_part("templates/widgets/target-banner"); ?>

<?php get_footer(); ?>
