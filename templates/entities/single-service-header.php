<?php
/**
 * Header of Pages Template
 * 
 * @param bool $show_blog_link: Необязательный, по умолчанию True

 */

$show_blog_link = isset($args['show_blog_link']) ? to_bool($args['show_blog_link']) : true;
$show_time = isset($args['show_time']) ? to_bool($args['show_time']) : true;
$single_header_style = isset($args['style']) ? $args['style'] : '';
if ($single_header_style === 'secondary') { $single_header_style = 'is-style-secondary'; }
if ($single_header_style === 'thirty') { $single_header_style = 'is-style-thirty'; }

$post_title = get_the_title();
$service_filial_title = get_service_filial_title();
$service_filial_link = get_service_filial_link();
$service_price = get_service_price();
$service_book_link = get_service_book_link();
?>

<?php $breadcrumb_filial = !empty($service_filial_title) ? ['name' => $service_filial_title, 'href' => $service_filial_link.'#blog_view'] : null; ?>

<div class="single-header <?php echo $single_header_style; ?>">
	<div class="content-wrapper">
		<?php get_template_part('templates/entities/breadcrumbs', null, [
			$breadcrumb_filial
		]); ?>
	</div>

	<?php if (!empty($post_title) || has_excerpt()) : ?>
		<div class="content-wrapper cms-content">
			<?php if (!empty($post_title)) : ?>
				<h1><?php echo $post_title; ?></h1>
			<?php endif; ?>
			<?php if( has_excerpt() ): ?>
				<?php the_excerpt(); ?>
			<?php endif; ?>
			<?php $tags = get_the_terms( $post->ID, 'service_types' ); ?>
			<div class="flex is-gap-8">
				<?php if(!empty($service_price)) : ?>
					<span class="span is-size-m is-highlight"><?php echo $service_price; ?></span>
				<?php endif; ?>
				<? if( $tags ): ?>
					<ul class="single-header__tags">
						<?php foreach( $tags as $tag ): ?>
							<li><a href="<?php echo $service_filial_link.'#services_'.$tag->slug; ?>" class="button is-size-m is-rounded is-hilight"><?php echo $tag->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<?php if (!empty($service_book_link)) : ?>
				<a href="<?php echo $service_book_link; ?>" class="button is-wide is-style-accent"
					>Записаться</a
				>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>