<?php
	// Извлекаем и валидируем параметры
	$post_id = isset($args['post_id']) ? $args['post_id'] : '';

	$post_title = get_the_title($post_id);
	$post_excerpt = get_the_excerpt($post_id);
	$post_permalink = get_permalink($post_id);
	$post_categories = get_the_terms( $post_id, 'service_types' );
	$post_thumbnail = get_the_post_thumbnail($post_id, 'medium', array(
		'alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(),
		'loading' => 'lazy'
	));

	$service_price = get_service_price();
	$service_book_link = get_service_book_link();
?>


<div class="service-card">
	<?php if (!empty($post_thumbnail)) : ?>
		<div class="service-card__cover">
			<?php echo $post_thumbnail; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($post_title)) : ?>
		<h3 class="heading is-size-h5"><?php echo $post_title; ?></h3>
	<?php endif; ?>
		
	<?php if (!empty($post_excerpt)) : ?>
		<p class="span is-size-xs"><?php echo $post_excerpt; ?></p>
	<?php endif; ?>
	<div class="service-card__tags">
		<?php if (!empty($service_price)) : ?>
			<span class="span is-size-xs is-highlight"><?php echo $service_price; ?></span>
		<?php endif; ?>
		<?php if(!empty($post_categories)) : ?>
			<?php foreach ($post_categories as $post_category) : ?>
				<span class="span is-size-xs is-secondary"><?php echo $post_category->name ?></span>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<div class="flex is-gap-8 is-wrap-mobile">
		<a
			href="<?php echo $post_permalink ?>"
			class="service-card__readmore button is-wide-full is-style-primary-alt"
			>Подробнее</a
		>
		<?php if (!empty($service_book_link)) : ?>
			<a href="<?php echo $service_book_link; ?>" class="button is-wide-full is-style-accent"
				>Записаться</a
			>
		<?php endif; ?>
	</div>
</div>