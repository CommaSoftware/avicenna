<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<input
			type="search"
			class="button is-size-l is-style-secondary search-form__field"
			placeholder="<?php echo esc_attr_x('Поиск по сайту', 'placeholder'); ?>"
			value="<?php echo get_search_query(); ?>"
			name="s"
	/>
	<button type="submit" class="button is-size-l is-style-primary search-submit">
		Найти
	</button>
</form>