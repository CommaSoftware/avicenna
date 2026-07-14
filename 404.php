<?php get_header(); ?>

<section id="not_found" class="not-found bg-highlight is-has-gradient">
	<div class="content-wrapper">
		<h1 class="heading is-size-h1">Ошибка 404</h1>
		<p class="span">Cтраницы по этой ссылке не существует</p>
		<a href="<?php echo get_home_url(); ?>" class="button is-style-bordered">
			<span class="icon" data-type="arrow-undo"></span>
			Вернуться на главную
		</a>
	</div>
</section>

<?php get_footer(); ?>
