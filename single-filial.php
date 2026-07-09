<?php
/**
 * Template Name: Страница Филиала
 * Template post type: post
 */
?>

<?php get_header(); ?>

<?php if( have_posts() ) : the_post(); ?>

	<?php 
	$filial_id = get_the_ID();
	$filial_title = get_the_title();
	$filial_thumbnail = get_the_post_thumbnail($filial_id, 'medium', array(
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

	<section id="filial" class="filial">
	<div class="content-wrapper">
		<div class="filial-content">
			<?php get_template_part('templates/entities/breadcrumbs', null, [['name' => $filial_title]]); ?>
			<div class="cms-content">
				<?php the_content(); ?>
			</div>
			<?php
			$menu_id = get_post_meta($filial_id, '_filial_selected_menu', true);
			if (!empty($menu_id)) :
			$menu_object = wp_get_nav_menu_object($menu_id);
			if ($menu_object) : 
			?>
				<h4>Услуги</h4>
				<div class="filial-card__menu">
					<?php	wp_nav_menu(array(
						'theme_location'  => 'filial_menu',
						'menu'           => $menu_id,
						'fallback_cb'    => false,
						'depth'          => 2,
						'walker'         => ''
					)); ?>
				</div>
			<?php endif; endif; ?>
		</div>
		<div class="filial-sidebar">
			<div class="filial-sidebar__content">
				<div class="filial-card">
					<div class="filial-card__body">
						<?php if (!empty($filial_thumbnail)) : ?>
							<?php echo $filial_thumbnail; ?>
						<?php endif; ?>
						<div class="filial-card-body__content">
							<h2 class="heading is-size-h2 is-white"><?php echo $filial_title; ?></h2>
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
								<?php if (!empty($filial_address)) : ?>
									<span class="span is-size-s is-white"><?php echo $filial_address; ?></span>
								<?php endif; ?>
							</div>
							<?php if (!empty($filial_gis2_url) || !empty($filial_appointment_url)) : ?>
							<div class="flex is-gap-8 is-wrap-mobile">
								<?php if (!empty($filial_appointment_url)) : ?>
									<a
										href="<?php echo $filial_gis2_url; ?>"
										class="button is-size-l is-wide-full is-style-primary-alt"
									>
										<span class="icon is-color-clear" data-type="2gis"></span>
										Открыть в 2GIS
									</a>
								<?php endif ?>
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
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php wp_reset_postdata(); endif; ?>

<?php get_footer(); ?>