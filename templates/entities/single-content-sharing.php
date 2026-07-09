<?php
/**
 * Template For Content Sharing Panel On Single Page
 */
?>

<?php 
	if (!get_post_status(get_the_ID())) {
			return;
	}

	$title = get_the_title();
	$permalink = get_permalink();

	$theme_article_sharing_show_copy_link = get_theme_mod('article_sharing__show_copy_link', Theme_Defaults::ARTICLE_SHARING_SHOW_LINK);
	$theme_article_sharing_show_tg = get_theme_mod('article_sharing__show_tg', Theme_Defaults::ARTICLE_SHARING_SHOW_TG);
	$theme_article_sharing_show_vk = get_theme_mod('article_sharing__show_vk', Theme_Defaults::ARTICLE_SHARING_SHOW_VK);
?>

<?php if ($theme_article_sharing_show_copy_link || $theme_article_sharing_show_tg || $theme_article_sharing_show_vk) : ?>
	<div class="single-content-sharing">
		<div class="single-content-sharing__content">
			<?php if ($theme_article_sharing_show_copy_link) : ?>
				<div class="button is-aspect-ratio-1b1" onclick="copyWithPopup('<?php echo $permalink; ?>')">
					<span class="icon" data-type="link-horizontal"></span>
				</div>
			<?php endif; ?>
			<?php if ($theme_article_sharing_show_tg) : ?>
				<a href="https://t.me/share/url?url=<?php echo $permalink ?>&text=<?php echo $title ?>" target="_blank" class="button is-aspect-ratio-1b1">
					<span class="icon" data-type="telegramm"></span>
				</a>
			<?php endif; ?>
			<?php if ($theme_article_sharing_show_vk) : ?>
				<a href="https://vk.com/share.php?url=<?php echo $permalink ?>&title=<?php echo $title ?>" target="_blank" class="button is-aspect-ratio-1b1">
					<span class="icon" data-type="vk"></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>