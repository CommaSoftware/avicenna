<?php
	$current_term = get_term_by('slug', 'faqs', 'category');;
	$current_term_name = $current_term->name;
	$current_term_link = get_category_link($current_term);

	$args = array(
		'category_name' => 'faqs',
		'orderby' => 'date',
		'order' => 'DESC',
		'ignore_sticky_posts' => 1,
	);
	$query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>
<section id="faq">
	<div class="content-wrapper">
		<div class="heading-block">
			<h2 class="heading is-size-h2"><?php echo $current_term_name; ?></h2>
		</div>
	</div>
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
			<?php wp_reset_postdata(); wp_reset_query(); ?>
		</div>
	</div>
	<div class="content-wrapper">
		<div class="buttons-block">
			<a
			href="<?php echo $current_term_link; ?>"
			class="button is-style-secondary is-wide"
			>Показать больше</a
			>
		</div>
	</div>
</section>
<?php endif; ?>