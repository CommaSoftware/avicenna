<?php 
$current_query = $args['query'] ?? false;
?>

<div class="pagination">
	<?php 
		// пагинация для произвольного запроса
		$big = 999999999; // уникальное число
		echo paginate_links( array(
		'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format'  => '?paged=%#%',
		'total'   => $current_query->max_num_pages,
		'current' => max( 1, get_query_var('paged') ),
		'show_all'     => False,
		'end_size'     => 0,
		'mid_size'     => 2,
		'prev_next'    => true,
		'prev_text'    => ('<span class="icon" data-type="chervon-left"></span>'),
		'next_text'    => ('<span class="icon" data-type="chervon-right"></span>'),
		'type'         => 'plain',
		'add_args'     => False,
		'add_fragment' => '',
    'before_page_number' => '',
    'after_page_number' => '',
	) ); ?>
</div>