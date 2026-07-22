<?php
	$theme_main_banner_logo = get_theme_mod('main_banner__logo', Theme_Defaults::MAIN_BANNER_LOGO);
	$theme_main_banner_license_link = get_theme_mod('main_banner__license_link', Theme_Defaults::MAIN_BANNER_LICENSE_LINK);
	$theme_main_banner_html_block = get_theme_mod('main_banner__html_block', Theme_Defaults::MAIN_BANNER_HTML_BLOCK);
?>

<section id="main_banner" class="main-banner bg-highlight is-has-gradient">
	<div class="content-wrapper main-banner__logo">
		<div class="logo-full">
			<?php if (!empty($theme_main_banner_logo)): ?>
				<img src="<?php echo $theme_main_banner_logo; ?>" alt="Логотип <?php bloginfo('name'); ?>">
			<?php else: ?>
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="Авиценна" />
			<?php endif; ?>
		</div>
		<?php if (!empty($theme_main_banner_license_link)): ?>
			<a href="<?php echo $theme_main_banner_license_link; ?>" class="button is-style-secondary-alt is-size-l is-wide">
				<span class="icon is-color-highlight" data-type="shield"></span>
				Действительная лицензия
				<span class="icon" data-type="chervon-right"></span>
			</a>
		<?php endif; ?>
		<?php if (!empty($theme_main_banner_html_block)): ?>
			<?php echo $theme_main_banner_html_block; ?>
		<?php endif; ?>
	</div>
</section>