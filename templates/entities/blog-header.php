<?php
	$is_category = is_category();
	
	$theme_blog_heading = get_theme_mod('blog__heading', Theme_Defaults::BLOG_HEADING);
	$theme_blog_link = get_theme_mod('blog__link', Theme_Defaults::BLOG_LINK);
	
	$current_term = get_queried_object();
	$current_term_id = $current_term->term_id;
	$current_term_name = $current_term->name;

	$breadcrumb_items = [
		['name' => $theme_blog_heading, 'href' => $theme_blog_link],
		$is_category ? ['name' => $current_term_name] : null,
	];

?>

<div class="section-header">
	
	<div class="content-wrapper">
		<?php get_template_part('templates/entities/breadcrumbs', null, $breadcrumb_items); ?>
		<div class="section-header__headings">
			<h1 class="heading"><?php echo $theme_blog_heading  . ($is_category ? (" / ". $current_term_name) : ""); ?></h1>
		</div>

		<?php $tags = get_terms( [
			'taxonomy' => 'category',
			'orderby' => 'count',
			'order' => 'DESC',
			'hide_empty' => false
		] ); ?>
		<? if( $tags ): ?>
			<ul class="section-header__actions">
				<?php foreach( $tags as $tag ): ?>
					<li>
						<?php if ($tag->term_id == $current_term_id) : ?>
							<a 
								href="<?php echo $theme_blog_link; ?>" 
								class="button is-size-m is-highlight is-style-primary">
								<?php echo $tag->name; ?>
								<span class="icon" data-type="filter-off"></span>
							</a>
						<?php else : ?>
							<a 
								href="<?php echo get_term_link($tag); ?>" 
								class="button is-size-m is-highlight">
								<?php echo $tag->name; ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</div>