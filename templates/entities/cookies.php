<?php
	$theme_title_tagline_counter_alert = get_theme_mod('title_tagline__counter_alert', Theme_Defaults::TITLE_TAGLINE_COUNTER_ALERT);
?>

<div id="cookie_overlay" class="cookie-overlay">
	<div class="content-wrapper">
		<div class="cookie-overlay__block">
			<div class="span is-size-xss"><?php echo $theme_title_tagline_counter_alert; ?></div>
			<div class="button cookie-overlay__btn is-hilight">
				Принять
				<span class="icon" data-type="check"></span>
			</div>
		</div>
	</div>
</div>