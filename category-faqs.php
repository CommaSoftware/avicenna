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
		'ignore_sticky_posts' => 0,
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
	<?php endif; ?>
	<?php wp_reset_postdata(); wp_reset_query(); ?>
</section>

<?php get_footer(); ?>




<!-- <details class="faq__item">
	<summary class="faq__item__question">
		Как оформить водительскую справку?
	</summary>
	<div class="faq__item__answer cms-content">
		<p>
			Водительская справка оформляется на основании заключений
			терапевта, офтальмолога, психиатра-нарколог (в рамках
			лицензированной комиссии).
		</p>
		<p>
			В клинике «АВИЦЕННА» вы можете пройти всех необходимых врачей в
			один день, включая ЭЭГ и ЭКГ по показаниям. Готовый документ
			соответствует требованиям ГИБДД и действует для замены или
			получения водительского удостоверения.
		</p>
	</div>
</details>
<details class="faq__item">
	<summary class="faq__item__question">
		Что входит в справку формы 086/у и для чего она нужна?
	</summary>
	<div class="faq__item__answer cms-content">
		<p>
			Справка формы 086/у — это стандартный медицинский документ,
			обязательный для:
		</p>
		<ul>
			<li>
				поступления в средние специальные и высшие учебные заведения;
			</li>
			<li>
				оформления в общеобразовательные учреждения (школы, лицеи,
				гимназии).
			</li>
		</ul>
		<p>
			В справку входят заключения: терапевта, хирурга, невролога,
			офтальмолога, отоларинголога, а также результаты флюорографии,
			ЭКГ и лабораторных анализов (клинический анализ крови и мочи,
			кровь на сахар). В «АВИЦЕННЕ» справка оформляется в течение 1–2
			дней.
		</p>
	</div>
</details>
<details class="faq__item">
	<summary class="faq__item__question">
		Можно ли пройти ФГДС без направления и без очереди?
	</summary>
	<div class="faq__item__answer cms-content">
		<p>
			Да. Эндоскопическое исследование (гастродуоденоскопия)
			проводится в клинике по предварительной записи в удобное для
			пациента время. Направление от врача не требуется. Процедура
			выполняется на современном оборудовании с использованием тонких
			гастроскопов, что снижает дискомфорт. По желанию пациента
			возможно проведение ФГДС в медикаментозном сне.
		</p>
	</div>
</details>
<details class="faq__item">
	<summary class="faq__item__question">
		Выдаёте ли вы больничные листы?
	</summary>
	<div class="faq__item__answer cms-content">
		<p>
			Да. Медицинский центр «АВИЦЕННА» имеет лицензию на проведение
			экспертизы временной нетрудоспособности. Листок
			нетрудоспособности (больничный лист) оформляется врачом после
			очного приёма при наличии клинических показаний. Документ
			принимается по месту работы, включая электронный формат (ЭЛН).
		</p>
	</div>
</details>
<details class="faq__item">
	<summary class="faq__item__question">
		Какие исследования входят в лабораторные анализы?
	</summary>
	<div class="faq__item__answer cms-content">
		<p>В клинике доступен полный спектр лабораторной диагностики:</p>
		<ul>
			<li>клинический и биохимический анализы крови;</li>
			<li>общий анализ мочи;</li>
			<li>
				исследование на гормоны, маркеры воспаления, онкомаркеры;
			</li>
			<li>анализ на инфекции (включая ПЦР);</li>
			<li>коагулограмма, липидный профиль.</li>
		</ul>
		<p>
			Биоматериал принимается ежедневно. Большинство анализов
			выполняются в течение 24 часов.
		</p>
	</div>
</details>
<details class="faq__item">
	<summary class="faq__item__question">
		Какие документы нужны для прохождения медосмотра при
		трудоустройстве?
	</summary>
	<div class="faq__item__answer cms-content">
		<p>
			Для прохождения обязательного предварительного (при поступлении
			на работу) и периодического медицинского осмотра при себе
			необходимо иметь:
		</p>
		<ul>
			<li>паспорт гражданина РФ;</li>
			<li>направление от работодателя (если требуется);</li>
			<li>
				паспорт здоровья (при наличии результатов предыдущих
				осмотров).
			</li>
		</ul>
		<p>
			По итогу осмотра выдаётся заключение установленного образца с
			допуском к профессиональной деятельности.
		</p>
	</div>
</details> -->