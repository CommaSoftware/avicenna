<?php
	$theme_blog_name = get_bloginfo('name');

	$theme_contacts_tg_link = get_theme_mod('contacts__tg_link', Theme_Defaults::CONTACTS_TG_LINK);
	$theme_contacts_vk_link = get_theme_mod('contacts__vk_link', Theme_Defaults::CONTACTS_VK_LINK);
	$theme_contacts_max_link = get_theme_mod('contacts__max_link', Theme_Defaults::CONTACTS_MAX_LINK);

	$theme_blog_sidebar_thumbnail = get_theme_mod("blog_sidebar__thumbnail", Theme_Defaults::BLOG_SIDEBAR_THUMBNAIL);
	$theme_blog_sidebar_description = get_theme_mod("blog_sidebar__description", Theme_Defaults::BLOG_SIDEBAR_DESCRIPTION);
	$theme_blog_sidebar_button1_link = get_theme_mod('blog_sidebar__button1_link', Theme_Defaults::BLOG_SIDEBAR_BUTTON1_LINK);
	$theme_blog_sidebar_button1_name = get_theme_mod('blog_sidebar__button1_name', Theme_Defaults::BLOG_SIDEBAR_BUTTON1_NAME);
	$theme_blog_sidebar_button1_icon = get_theme_mod('blog_sidebar__button1_icon', Theme_Defaults::BLOG_SIDEBAR_BUTTON1_ICON);
	$theme_blog_sidebar_button2_link = get_theme_mod('blog_sidebar__button2_link', Theme_Defaults::BLOG_SIDEBAR_BUTTON2_LINK);
	$theme_blog_sidebar_button2_name = get_theme_mod('blog_sidebar__button2_name', Theme_Defaults::BLOG_SIDEBAR_BUTTON2_NAME);
	$theme_blog_sidebar_button2_icon = get_theme_mod('blog_sidebar__button2_icon', Theme_Defaults::BLOG_SIDEBAR_BUTTON2_ICON);
?>


<div class="blog-author">
	<span class="blog-author__subheading span is-size-xs is-hilight"
		>Автор</span
	>
	<div class="blog-author__header">
		<?php if($theme_blog_sidebar_thumbnail != '') : ?>
			<img
				src="<?php echo $theme_blog_sidebar_thumbnail; ?>"
				class="blog-author-header__avatar"
				alt="<?php echo $theme_blog_name; ?>"
			/>
		<?php endif; ?>
		<div class="blog-author-header__name">
			<h3 class="heading is-size-h5"><?php echo $theme_blog_name; ?></h3>
			<span class="span is-size-xs is-highlight">Медицинский центр</span>
		</div>
	</div>
	<?php if($theme_blog_sidebar_description != '') : ?>
		<div class="cms-content">
			<?php echo $theme_blog_sidebar_description; ?>
		</div>
	<?php endif; ?>
	<?php if($theme_contacts_tg_link != '' || $theme_contacts_max_link != '') : ?>
		<div class="blog-author__actions">
			<?php if ($theme_contacts_tg_link != ""): ?>
				<a
					href="<?php echo $theme_contacts_tg_link; ?>"
					title="Telegram"
					target="_blank"
					class="button is-size-s is-style-bordered is-aspect-ratio-1b1"
					><span class="icon" data-type="telegramm"></span
				></a>
			<?php endif; ?>
			<?php if ($theme_contacts_vk_link != ""): ?>
				<a
					href="<?php echo $theme_contacts_vk_link; ?>"
					title="VK"
					target="_blank"
					class="button is-size-s is-style-bordered is-aspect-ratio-1b1"
					><span class="icon" data-type="vk"></span
				></a>
			<?php endif; ?>
			<?php if ($theme_contacts_max_link != ""): ?>
				<a
					href="<?php echo $theme_contacts_max_link; ?>"
					title="MAX"
					target="_blank"
					class="button is-size-s is-style-bordered is-aspect-ratio-1b1"
					><span class="icon" data-type="max"></span
				></a>
			<?php endif; ?>
			<?php if ($theme_blog_sidebar_button2_link != ""): ?>
					<a
						href="<?php echo $theme_blog_sidebar_button2_link; ?>"
						class="button is-size-l is-wide-full is-style-bordered"
						>
						<?php if ($theme_blog_sidebar_button2_icon != ""): ?>
							<span class="icon" data-type="<?php echo $theme_blog_sidebar_button2_icon; ?>"></span>
						<?php endif; ?>
						<?php echo $theme_blog_sidebar_button2_name; ?>
					</a>
				<?php endif; ?>
				<?php if ($theme_blog_sidebar_button1_link != ""): ?>
					<a
						href="<?php echo $theme_blog_sidebar_button1_link; ?>"
						class="button is-size-l is-wide-full is-style-accent"
						>
						<?php if ($theme_blog_sidebar_button1_icon != ""): ?>
							<span class="icon" data-type="<?php echo $theme_blog_sidebar_button1_icon; ?>"></span>
						<?php endif; ?>
						<?php echo $theme_blog_sidebar_button1_name; ?>
					</a>
				<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
