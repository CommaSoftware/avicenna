<?php 
$custom_html_show = get_theme_mod('custom_html__show', Theme_Defaults::CUSTOM_HTML_SHOW);
$custom_html_code = get_theme_mod('custom_html__code', Theme_Defaults::CUSTOM_HTML_CODE);

if ($custom_html_show) {
	echo $custom_html_code;
}
?>

