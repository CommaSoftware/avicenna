<?php
/**
 * Template Name: Запись по умолчанию
 * Template post type: post
 */
?>

<?php get_header(); ?>

<?php if( have_posts() ) : the_post(); ?>
	<?php
		$employee_title = get_the_title();
		$show_content = get_post()->post_content !== '';
		$employee_thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium', array(
			'alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: $employee_title,
			'loading' => 'lazy'
		));
		$employee_position = esc_html(get_employee_position());
		$employee_phone = esc_html(get_employee_phone());
		$employee_appointment_link = esc_url(get_employee_appointment_link());
		$employee_reviews_link = esc_url(get_employee_reviews_link());
		$employee_filial = get_employee_filial_object();
		$employee_breadcrumb_config = !empty($employee_filial) ? ['name' => esc_html($employee_filial->post_title), 'href' => get_permalink($employee_filial->ID)] : null; 
	?>

	<article id="content">
		<div class="single-header is-style-thirty">
			<div class="content-wrapper">
				<?php get_template_part('templates/entities/breadcrumbs', null, [
					$employee_breadcrumb_config
				]); ?>
			</div>
			<div class="content-wrapper cms-content">
				<div class="specialist-card">
					<div class="specialist-card__cover">
						<?php if (!empty($employee_position)) : ?>
							<?php echo $employee_thumbnail; ?>
						<?php endif; ?>
					</div>
					<div class="flex is-gap-8 is-dir-col is-justify-sb is-wide-full">
						<div class="specialist-card__headings">
							<?php if (!empty($employee_position)) : ?>
								<span class="span is-size-xs is-highlight"><?php echo $employee_position; ?></span>
							<?php endif; ?>
							<h2 class="heading is-size-h2"><?php echo $employee_title; ?></h2>
						</div>
						<div class="flex is-gap-8 is-dir-col" style="height:100%;">
							<?php if (!empty($employee_filial)) : ?>
								<a
									href="<?php echo get_permalink($employee_filial->ID); ?>"
									class="specialist-card__filial button is-style-transparent is-size-s"
								>
									<span class="icon" data-type="map-pin"></span>
									<?php echo esc_html($employee_filial->post_title); ?>
								</a>
							<?php endif; ?>
							<?php if (!empty($employee_reviews_link)) : ?>
								<a href="<?php echo $employee_reviews_link; ?>" class="button is-size-m is-wide-full">
									<span class="icon" data-type="star"></span>
									Отзывы
								</a>
							<?php endif; ?>
							<div class="flex is-gap-8 is-wrap-mobile" style="margin-top:auto;">
								<?php if (!empty($employee_phone)) : ?>
									<a
										href="<?php echo 'tel:'.$employee_phone; ?>"
										class="button is-size-l is-style-bordered is-wide-full"
									>
										<?php echo $employee_phone; ?>
									</a>
								<?php endif; ?>
								<?php if (!empty($employee_appointment_link)) : ?>
									<a
										href="<?php echo $employee_appointment_link; ?>"
										class="specialist-card__readmore button is-size-l is-style-accent is-wide-full"
									>
										Записаться
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="single-content">
			<div class="content-wrapper">
				<div class="cms-content">
					<?php if ($show_content) : ?>
						<?php the_content(); ?>
					<?php else: ?>
						<p>Раздел в процессе наполнения.</p>
					<?php endif; ?>
				</div>
				<div class="single-content-button_scroll_top">
					<a
						href="#content"
						id="button_scroll_top"
						class="button is-size-l is-style-bordered is-aspect-ratio-1b1"
					>
						<span class="icon" data-type="chervon-up"></span>
					</a>
				</div>
			</div>
		</div>
	</article>
<?php wp_reset_postdata(); endif; ?>

<?php get_footer(); ?>

