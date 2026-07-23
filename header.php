<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title><?php wp_title('–', true, 'right');?> <?php bloginfo('name'); ?></title>

	<!-- Meta for SEO -->
	<?php if(is_front_page()) { ?>
		<meta name="description" content="<?php echo get_bloginfo('description'); ?>">
	<?php } elseif(is_single()) { ?>
		<meta name="description" content="<?php echo get_post()->post_excerpt; ?>">
	<?php } ?>

	<!-- Meta for social network -->
	<meta property="og:title" content="<?php wp_title('–', true, 'right');?> <?php bloginfo('name'); ?>" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/cover.jpg" />

	<?php echo get_theme_mod('title_tagline__head_code', ''); ?>

	<?php wp_head(); ?>
</head>
<body>

<?php
	$theme_header_logo = get_theme_mod('header__logo', Theme_Defaults::HEADER_LOGO);
	$theme_contacts_tg_link = get_theme_mod('contacts__tg_link', Theme_Defaults::CONTACTS_TG_LINK);
	$theme_contacts_vk_link = get_theme_mod('contacts__vk_link', Theme_Defaults::CONTACTS_VK_LINK);
	$theme_contacts_max_link = get_theme_mod('contacts__max_link', Theme_Defaults::CONTACTS_MAX_LINK);
	$theme_header_button1_link = get_theme_mod('header__button1_link', Theme_Defaults::HEADER_BUTTON1_LINK);
	$theme_header_button1_name = get_theme_mod('header__button1_name', Theme_Defaults::HEADER_BUTTON1_NAME);
	$theme_header_button1_icon = get_theme_mod('header__button1_icon', Theme_Defaults::HEADER_BUTTON1_ICON);

	$args = array(
		'post_type'      => 'filial',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'ASC'
	);

	$filials_query = new WP_Query($args);
?>

<header class="header">
	<div class="content-wrapper header__content-block">
		<div class="header__menu-button button is-aspect-ratio-1b1 is-style-bordered">
			<span class="icon" data-type="hamburger"></span>
		</div>
		<div class="header__heading">
			<div class="header-logo">
				<a href="<? echo get_home_url(); ?>" class="logo-full">
					<?php if ($theme_header_logo != ""): ?>
						<img src="<?php echo $theme_header_logo; ?>" alt="Логотип <?php bloginfo('name'); ?>">
					<?php else: ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="Авиценна" />
					<?php endif; ?>
				</a>
			</div>
			<?php if ($filials_query->have_posts()) : ?>
				<div class="header-filial">
					<div class="dropdown-menu is-style-bordered">
						
						<ul>
							<li>
								<a>Филиалы</a>
								<ul>
									<?php while ($filials_query->have_posts()) : $filials_query->the_post(); ?>
										<li><a href="<? the_permalink(); ?>"><?php the_title(); ?></a></li>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); wp_reset_query(); ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="header__contacts">
			<?php if ($theme_contacts_tg_link != ""): ?>
				<a
					href="<?php echo $theme_contacts_tg_link; ?>"
					title="Telegram"
					target="_blank"
					class="button is-style-secondary is-size-m is-aspect-ratio-1b1"
					><span class="icon" data-type="telegramm"></span
				></a>
			<?php endif; ?>
			<?php if ($theme_contacts_vk_link != ""): ?>
				<a
					href="<?php echo $theme_contacts_vk_link; ?>"
					title="VK"
					target="_blank"
					class="button is-style-secondary is-size-m is-aspect-ratio-1b1"
					><span class="icon" data-type="vk"></span
				></a>
			<?php endif; ?>
			<?php if ($theme_contacts_max_link != ""): ?>
				<a
					href="<?php echo $theme_contacts_max_link; ?>"
					title="MAX"
					target="_blank"
					class="button is-style-secondary is-size-m is-aspect-ratio-1b1"
					><span class="icon" data-type="max"></span
				></a>
			<?php endif; ?>
			<?php if ($filials_query->have_posts()) : ?>
				<div class="header-contacts__phones">
					<?php while ($filials_query->have_posts()) : $filials_query->the_post(); ?>
						<?php $filial_phone = esc_html(get_filial_phone()); ?>
						<?php if (!empty($filial_phone)) : ?>
							<div class="header-contacts-phones__item">
								<span class="span is-size-xxs"><?php the_title(); ?></span>
								<a
									href="<?php echo 'tel:'.$filial_phone; ?>"
									class="button is-style-transparent is-size-s"
									><?php echo $filial_phone ?></a
								>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); wp_reset_query(); ?>
				</div>
			<?php endif; ?>
		</div>
		<nav class="header__nav dropdown-menu is-only-desktop">
			<?php wp_nav_menu( [
				'theme_location'  => 'header_menu',
				'menu'            => '',
				'container'       => false,
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => 'wp_page_menu',
				'before'          => '',
				'after'           => '',
				'link_before'     => '',
				'link_after'      => '',
				'depth'           => 0,
				'walker'          => '',
			] ); ?>
		</nav>
		<div class="header__actions">
			<?php if ($theme_header_button1_link != ""): ?>
				<a
					href="<?php echo $theme_header_button1_link; ?>"
					class="button is-style-accent is-wide header__target-button"
					>
					<?php if ($theme_header_button1_icon != ""): ?>
						<span class="icon" data-type="<?php echo $theme_header_button1_icon; ?>"></span>
					<?php endif; ?>
					<?php echo $theme_header_button1_name; ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</header>
