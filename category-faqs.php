<?php get_header(); ?>

<?php
	
	$theme_blog_heading = get_theme_mod('blog__heading', Theme_Defaults::BLOG_HEADING);
	$theme_blog_link = get_theme_mod('blog__link', Theme_Defaults::BLOG_LINK);

	$current_term = get_queried_object();
	$current_term_name = $current_term->name;

	$breadcrumb_items = [
		['name' => $theme_blog_heading, 'href' => $theme_blog_link],
	];

	$args = array(
		'posts_per_page' => -1,
		'category_name' => 'faqs',
		'orderby' => 'date',
		'order' => 'DESC',
		'ignore_sticky_posts' => 1,
	);
	$query = new WP_Query($args);
?>


<section id="faq">
	<div class="content-wrapper">
		<div class="heading-block">
			<?php get_template_part('templates/entities/breadcrumbs', null, $breadcrumb_items); ?>
			<h2 class="heading is-size-h2"><?php echo $current_term_name; ?></h2>
		</div>
	</div>
	<?php if ($query->have_posts()) : ?>
		<div class="content-wrapper">
			<div class="faq__block">
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<details class="faq__item">
						<summary class="faq__item__question">
							<?php the_title(); ?>
						</summary>
						<div class="faq__item__answer cms-content">
							<?php the_content(); ?>
						</div>
					</details>
				<?php endwhile; ?>
			</div>
		</div>
	<?php else : ?>
		<div class="content-wrapper">
			<div class="faq__block flex is-justify-c">
				<span class="span">Раздел пуст, загляните позже</span>
			</div>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); wp_reset_query(); ?>
</section>

<?php get_footer(); ?>