<?php
/**
 * Template Name: Search Results
 * The template for displaying search results.
 */

get_header();
?>

<section id="search" class="search">
	<div class="content-wrapper">
			<?php
			$search_query = get_search_query();
			if ( get_query_var('paged') ) $paged = get_query_var('paged');
			elseif ( get_query_var('page') ) $paged = get_query_var('page');
			else $paged = 1;

			$args = array(
					's'              => $search_query,
					'post_type'      => array('post', 'page', 'filial', 'employee'),
					'paged' => $paged,
					'orderby'        => 'relevance',
			);

			$search_results = new WP_Query($args);
			$total_results = $search_results->found_posts;
			?>

			<?php get_search_form(); ?>
			<?php if ($total_results) : ?>
				<div class="span is-secondary">
					<?php 
						echo 'Найдено '.$total_results.' по запросу «'.$search_query.'»'; 
					?>
				</div>
			<?php endif; ?>

			<?php if ($search_results->have_posts()) : ?>
					<div class="search-results">
						<?php
						while ($search_results->have_posts()) : $search_results->the_post(); ?>
							<a href="<?php echo get_permalink() ?>" class="search__result">
								<h2 class="heading is-size-h4"><?php echo get_the_title() ?></h2>
								<?php echo the_excerpt(); ?>
								<span class="span is-size-xs"><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span>
							</a>
						<?php endwhile; ?>
					</div>
					<?php get_template_part('templates/entities/pagination', null, ['query'=>$search_results]); ?>

			<?php else : ?>
				<p><?php esc_html_e('Ничего не найдено. Попробуйте другие ключевые слова.'); ?></p>
			<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>