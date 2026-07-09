<?php
	// Извлекаем и валидируем параметры
	$post_id = isset($args['post_id']) ? $args['post_id'] : '';
	$show_excerpt = isset($args['show_excerpt']) ? to_bool($args['show_excerpt']) : false;
	$default_category_id = get_option('default_category');

	$post_title = get_the_title($post_id);
	$post_permalink = get_permalink($post_id);
	$post_thumbnail = get_the_post_thumbnail($post_id, 'medium', array(
		'class' => 'filial-card-body__cover',
		'alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(),
		'loading' => 'lazy'
	));

	$filial_phone = esc_html(get_filial_phone());
	$filial_address = esc_html(get_filial_address());
	$filial_schedule = esc_html(get_filial_work_schedule());
	$filial_appointment_url = esc_url(get_filial_appointment_url());
	$filial_gis2_url = esc_url(get_filial_gis2_url());
?>


<div class="filial-card">
	<div class="filial-card__body">
		<?php if (!empty($post_thumbnail)) : ?>
			<?php echo $post_thumbnail; ?>
		<?php endif; ?>
		<div class="filial-card-body__content">
			<h2 class="heading is-size-h2 is-white"><?php echo $post_title; ?></h2>
			<div class="flex is-gap-8 is-dir-col">
				<?php if (!empty($filial_phone) || !empty($filial_schedule)) : ?>
					<div class="flex is-gap-12">
						<?php if (!empty($filial_phone)) : ?>
							<a
								href="<?php echo 'tel:'.$filial_phone; ?>"
								class="button is-size-s is-style-bordered-alt"
								><?php echo $filial_phone; ?></a
							>
						<?php endif; ?>
						<?php if (!empty($filial_schedule)) : ?>
							<span class="span is-size-s is-white"><?php echo $filial_schedule; ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($filial_gis2_url) || !empty($filial_address)) : ?>
					<div class="flex is-gap-12">
						<?php if (!empty($filial_gis2_url)) : ?>
							<a
								href="<?php echo $filial_gis2_url; ?>"
								target="_blank"
								class="button is-size-s is-aspect-ratio-1b1 is-style-bordered-alt"
							>
								<span class="icon is-color-clear" data-type="2gis"></span>
							</a>
						<?php endif; ?>
						<?php if (!empty($filial_address)) : ?>
							<span class="span is-size-s is-white"><?php echo $filial_address; ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="flex is-gap-8 is-wrap-mobile">
				<a
					href="<?php echo $post_permalink; ?>"
					class="button is-size-l is-wide-full is-style-primary-alt"
				>
					<span class="icon" data-type="info"></span>
					Подробнее
				</a>
				<?php if (!empty($filial_appointment_url)) : ?>
					<a
						href="<?php echo $filial_appointment_url; ?>"
						target="_blank"
						class="button is-size-l is-wide-full is-style-accent"
					>
						Записаться
					</a>
				<?php else : ?>
					<a
						href="<?php echo 'tel:'.$filial_phone; ?>"
						target="_blank"
						class="button is-size-l is-wide-full is-style-accent"
					>
						Позвонить
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
	$menu_id = get_post_meta($post_id, '_filial_selected_menu', true);
	if (!empty($menu_id)) :
	$menu_object = wp_get_nav_menu_object($menu_id);
	if ($menu_object) : 
	?>
		<div class="filial-card__footer">
			<span class="span is-size-xs is-secondary">Услуги</span>
			<div class="filial-card__menu">
				<?php	wp_nav_menu(array(
					'theme_location'  => 'filial_menu',
					'menu'           => $menu_id,
					'fallback_cb'    => false,
					'depth'          => 2,
					'walker'         => ''
				)); ?>
			</div>
		</div>
	<?php endif; endif; ?>
</div>