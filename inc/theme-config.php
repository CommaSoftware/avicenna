<?php
/**
 * Theme configuration file
 */

// Theme prefix (used for functions, hooks, settings)
define('THEME_PREFIX', 'avicenna');

class Theme_Defaults {

		const CONTACTS_EMAIL = 'avicenna.2013@yandex.ru';
		const CONTACTS_TG_LINK = '';
		const CONTACTS_MAX_LINK = '#!';
		const CONTACTS_VK_LINK = '#!';
		
		const HEADER_LOGO = false; 
		const HEADER_BUTTON1_ICON = ''; 
		const HEADER_BUTTON1_NAME = 'Записаться';
		const HEADER_BUTTON1_LINK = '#!';

		const FOOTER_LOGO = false;
		const FOOTER_COPYRIGHT_NAME = 'ООО Авиценна';
		const FOOTER_PRIVACY_LINK = '/privacy-policy';
		const FOOTER_OFFER_NAME = 'Информация на сайте является публичной офертой';
		const FOOTER_OFFER_LINK = '/offer-info';
		const FOOTER_LICENSES_LINK = '/licenses';


		const MAIN_BANNER_LOGO = false;
		const MAIN_BANNER_LICENSE_LINK = '#!';
		const MAIN_BANNER_HTML_BLOCK = '<iframe frameborder="0" width="150px" height="50px" src="https://widget.2gis.ru/api/widget?org_id=70000001031653121&amp;size=medium&amp;theme=light"></iframe>';

		const BLOG_HEADING = 'Публикации';
		const BLOG_LINK = '/blog';
		const BLOG_ANSWER_TO_EMPTY = 'Раздел пуст, загляните позже';
		const BLOG_SHOW_FAQS = false;
		const BLOG_SIDEBAR_SHOW_IN_BLOG = true;
		const BLOG_SIDEBAR_SHOW_IN_POST = true;
		const BLOG_SIDEBAR_THUMBNAIL = '/wp-content/themes/avicenna/assets/images/avatar.jpg';
		const BLOG_SIDEBAR_DESCRIPTION = '<ol>
			<li>УЗИ В ДЕНЬ ОБРАЩЕНИЯ!</li>
			<li>мед. осмотр при трудоустройстве на работу;</li>
			<li>справки водительские;</li>
			<li>
				справки форма 086/у, в бассейн, 001-гсу ЭЭГ, ЭКГ, лабораторные
				анализы;
			</li>
			<li>ФГДС (гастродуоденоскопия);</li>
			<li>приём врачей, справки, больничные листы;</li>
			<li>
				подбор, изготовление очков и ночных линз, аппаратное лечение
				заболеваний глаз.
			</li>
		</ol>';
		const BLOG_SIDEBAR_BUTTON1_ICON = '';
		const BLOG_SIDEBAR_BUTTON1_NAME = 'Записаться';
		const BLOG_SIDEBAR_BUTTON1_LINK = '#!';
		const BLOG_SIDEBAR_BUTTON2_ICON = '';
		const BLOG_SIDEBAR_BUTTON2_NAME = '';
		const BLOG_SIDEBAR_BUTTON2_LINK = '';
		const ARTICLE_SHARING_SHOW_LINK = true;
		const ARTICLE_SHARING_SHOW_TG = true;
		const ARTICLE_SHARING_SHOW_VK = true;

		const BLOG_VIEW_SHOW_ON_FRONT = true;
		const BLOG_VIEW_HEADING = 'Полезно знать';
		const BLOG_VIEW_DESCRIPTION = '';

		/**
		 * Get all default values as an array
		 *
		 * @return array Array of all default settings
		 */
		public static function get_all_defaults() {
				$reflection = new ReflectionClass(__CLASS__);
				$constants = $reflection->getConstants();
				
				$defaults = [];
				foreach ($constants as $key => $value) {
						$setting_name = strtolower(str_replace('_', '-', $key));
						$defaults[$setting_name] = $value;
				}
				
				return $defaults;
		}
		
		/**
		 * Get the default value for a specific setting
		 *
		 * @param string $key The configuration key
		 * @param mixed $default Default value if the constant is not found
		 * @return mixed
		 */
		public static function get($key, $default = null) {
				$constant_name = strtoupper(str_replace('-', '_', $key));
				
				if (defined("self::$constant_name")) {
						return constant("self::$constant_name");
				}
				
				return $default;
		}
		
		/**
		 * Get settings for a specific group
		 *
		 * @param string $group The settings group (GENERAL, COLORS, TYPOGRAPHY, etc.)
		 * @return array
		 */
		public static function get_group($group) {
				$prefix = strtoupper($group) . '_';
				$constants = (new ReflectionClass(__CLASS__))->getConstants();
				
				$group_defaults = [];
				foreach ($constants as $key => $value) {
						if (strpos($key, $prefix) === 0) {
								$setting_name = strtolower(str_replace('_', '-', $key));
								$group_defaults[$setting_name] = $value;
						}
				}
				
				return $group_defaults;
		}
}