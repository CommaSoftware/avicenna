<?php
/**
 * Header of Pages Template
 * 
 * @param bool $show_sidebar: Необязательный, по умолчанию True
 * @param bool $show_sharing: Необязательный, по умолчанию True

 */
?>

<?php
	$show_sidebar = isset($args['show_sidebar']) ? to_bool($args['show_sidebar']) : true;
	$show_sharing = isset($args['show_sharing']) ? to_bool($args['show_sharing']) : true;
	$show_thumbnail = has_post_thumbnail() && get_post_meta( get_the_ID(), 'hide_thumb_field', 1 ) != "true";
	$show_content = get_post()->post_content !== '';
?>

<?php if( $show_content || $show_thumbnail || $show_sidebar || $show_sharing) : ?>
	<div class="single-content">
		<div class="content-wrapper">
			<div class="single-content-sidebar">
				<?php if ($show_sidebar) { get_template_part('templates/entities/blog-author'); } ?>
			</div>
			<?php if ($show_sharing) { get_template_part('templates/entities/single-content-sharing'); } ?>
			<div class="cms-content">
				<?php if ($show_thumbnail) : ?>
					<img src="<?php the_post_thumbnail_url('large'); ?>" class="publication__header__cover" alt="<?php get_the_post_thumbnail_caption( $post ); ?>">
				<?php endif; ?>
				<?php if ($show_content) : ?>
					<?php the_content(); ?>
				<?php else: ?>
					<p>Раздел в процессе наполнения.</p>
				<?php endif; ?>
			</div>
			<?php if ($show_content) : ?>
				<div class="single-content-button_scroll_top">
					<a
						href="#content"
						id="button_scroll_top"
						class="button is-size-l is-style-bordered is-aspect-ratio-1b1"
					>
						<span class="icon" data-type="chervon-up"></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php else: ?>
	<div class="single-content">
		<div class="content-wrapper">
			<div class="cms-content">
				<p>Раздел в процессе наполнения.</p>
			</div>
		</div>
	</div>
<?php endif; ?>