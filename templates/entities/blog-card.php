<?php
	// Извлекаем и валидируем параметры
	$post_id = isset($args['post_id']) ? $args['post_id'] : '';
	$show_excerpt = isset($args['show_excerpt']) ? to_bool($args['show_excerpt']) : false;
	$default_category_id = get_option('default_category');

	$post_title = get_the_title($post_id);
	$post_excerpt = has_excerpt($post_id) ? get_the_excerpt($post_id) : '';
	$post_permalink = get_permalink($post_id);
	$post_categories = get_the_category();
	$post_thumbnail = get_the_post_thumbnail($post_id, 'medium', array(
		'class' => 'blog-card-cover__image',
		'alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(),
		'loading' => 'lazy'
	));

	$post_filial_title = get_post_filial_title();
	$post_filial_link = get_post_filial_link();
?>

<div class="blog-card <?php if(is_sticky()) { echo "is-pinned"; } ?>">
	<div class="blog-card__header">
		<time class="blog-card-header__date span is-size-xs is-secondary"><?php echo get_custom_post_date(); ?></time>
		<?php if (!empty($post_categories) || !empty($post_filial_title)) : ?>
			<div class="blog-card-header__categories">
				<?php if(!empty($post_filial_title)) : ?>
					<a href="<?php echo $post_filial_link; ?>" class="button is-size-s is-style-transparent is-highlight is-no-hover">
						<span class="icon" data-type="map-pin"></span>
						<?php echo $post_filial_title; ?>
					</a>
				<?php endif; ?>
				<?php foreach ($post_categories as $post_category) : ?>
					<?php if ($post_category->term_id == $default_category_id) { continue; } ?>
					<a class="blog-card__category button is-size-xs" href="<?php echo get_category_link($post_category->term_id) ?>"><?php echo $post_category->name ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="blog-card__content">
		<h4 class="heading is-size-h4"><?php echo $post_title; ?></h4>
		<?php if ($show_excerpt && !empty($post_excerpt)) : ?>
			<span class="span"><?php echo $post_excerpt; ?></span>
		<?php endif; ?>
	</div>
	<a href="<?php echo $post_permalink; ?>" class="blog-card__readmore">
		Подробнее
		<span
			class="icon blog-card-footer__icon"
			data-type="chervon-right"
		></span>
	</a>
	<?php if (!empty($post_thumbnail)) : ?>
		<div class="blog-card__cover">
			<?php echo $post_thumbnail; ?>
		</div>
	<?php endif; ?>
</div>