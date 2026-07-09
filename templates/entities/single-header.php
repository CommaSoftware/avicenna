<?php
/**
 * Header of Pages Template
 * 
 * @param bool $show_blog_link: Необязательный, по умолчанию True

 */

$show_blog_link = isset($args['show_blog_link']) ? to_bool($args['show_blog_link']) : true;
$theme_blog_heading = get_theme_mod('blog__heading', Theme_Defaults::BLOG_HEADING);
$theme_blog_link = get_theme_mod('blog__link', Theme_Defaults::BLOG_LINK);

?>

<?php $breadcrumb_blog = $show_blog_link ? ['name' => $theme_blog_heading, 'href' => $theme_blog_link] : null; ?>

<div class="single-header">
	<div class="content-wrapper">
		<?php get_template_part('templates/entities/breadcrumbs', null, [
			$breadcrumb_blog
		]); ?>
	</div>

	<?php
		$title = get_the_title();
	?>

	<?php if (!empty($title) || has_excerpt()) : ?>
		<div class="content-wrapper cms-content">
			<?php if (!empty($title)) : ?>
				<h1><?php echo $title; ?></h1>
			<?php endif; ?>
			<time class="span is-size-xs is-secondary"><?php echo get_custom_post_date(); ?></time>
			<?php if( has_excerpt() ): ?>
				<?php the_excerpt(); ?>
			<?php endif; ?>
			
			<?php $tags = get_the_terms( $post->ID, 'category' ); ?>
			<? if( $tags ): ?>
				<ul class="single-header__tags">
					<?php foreach( $tags as $tag ): ?>
						<li><a href="<?php echo get_term_link($tag) ?>" class="button is-size-m is-rounded is-hilight"><?php echo $tag->name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>