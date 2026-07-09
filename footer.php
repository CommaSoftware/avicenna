<?php 

$theme_logo = get_theme_mod('header__logo', Theme_Defaults::HEADER_LOGO);
$theme_copyright_name = get_theme_mod('footer__copyright_name', Theme_Defaults::FOOTER_COPYRIGHT_NAME);
$theme_privacy_link = get_theme_mod('footer__privacy_link', Theme_Defaults::FOOTER_PRIVACY_LINK);
$theme_offer_name = get_theme_mod('footer__offer_name', Theme_Defaults::FOOTER_OFFER_NAME);
$theme_offer_link = get_theme_mod('footer__offer_link', Theme_Defaults::FOOTER_OFFER_LINK);
$theme_licenses = get_theme_mod('footer__licenses', Theme_Defaults::FOOTER_LICENSES_LINK);

$theme_contacts_email = get_theme_mod('contacts__email', Theme_Defaults::CONTACTS_EMAIL);
$theme_contacts_tg_link = get_theme_mod('contacts__tg_link', Theme_Defaults::CONTACTS_TG_LINK);
$theme_contacts_vk_link = get_theme_mod('contacts__vk_link', Theme_Defaults::CONTACTS_VK_LINK);
$theme_contacts_max_link = get_theme_mod('contacts__max_link', Theme_Defaults::CONTACTS_MAX_LINK);

$args = array(
  'post_type'      => 'filial',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'orderby'        => 'date',
  'order'          => 'ASC'
);

$filials_query = new WP_Query($args);

?>

<?php get_template_part("templates/entities/cookies") ?>


<footer class="footer">
  <div class="footer__content">
    <div class="content-wrapper">
      <div class="footer-content__logo">
        <a href="<? echo get_home_url(); ?>" class="logo-full">
          <?php if ($theme_logo != ""): ?>
            <img src="<?php echo $theme_logo; ?>" alt="Логотип <?php bloginfo('name'); ?>">
          <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="Авиценна" />
          <?php endif; ?>
        </a>
      </div>
      <div class="footer-content__info">
        <div class="footer-content-info__contacts">
          <?php if ($filials_query->have_posts()) : ?>
            <div class="footer-contacts-line">
              <div
                class="footer-contacts-line__icon button is-size-s is-style-transparent is-highlight is-aspect-ratio-1b1"
              >
                <span class="icon" data-type="phone"></span>
              </div>
              <div class="footer-phone-group">
                <?php while ($filials_query->have_posts()) : $filials_query->the_post(); ?>
                  <?php $filial_phone = esc_html(get_filial_phone()); ?>
                  <?php if (!empty($filial_phone)) : ?>
                    <div class="footer-phone-group__line">
                      <span
                        class="button is-size-s is-style-transparent is-highlight is-no-hover"
                        ><?php the_title(); ?>
                      </span>
                      <a
                        href="<?php echo 'tel:'.$filial_phone; ?>"
                        class="button is-size-s is-style-transparent"
                        target="_blank"
                        ><?php echo $filial_phone ?>
                      </a>
                    </div>
                  <?php endif; ?>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); wp_reset_query(); ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if($theme_contacts_email != ''): ?>
            <div class="footer-contacts-line">
              <div
                class="footer-contacts-line__icon button is-size-s is-style-transparent is-hilight is-aspect-ratio-1b1"
              >
                <span class="icon" data-type="email"></span>
              </div>
              <a
                href="mailto:<?php echo $theme_contacts_email; ?>"
                target="_blank"
                class="button is-size-s is-style-transparent"
                ><?php echo $theme_contacts_email; ?>
              </a>
            </div>
          <?php endif; ?>
        </div>
        <div class="footer-content-info__socials">
          <?php if ($theme_contacts_tg_link != ""): ?>
            <a
              href="<?php echo $theme_contacts_tg_link; ?>"
              title="Telegram"
              target="_blank"
              class="button is-size-m is-style-bordered is-aspect-ratio-1b1"
              ><span class="icon" data-type="telegramm"></span
            ></a>
          <?php endif; ?>
          <?php if ($theme_contacts_vk_link != ""): ?>
            <a
              href="<?php echo $theme_contacts_vk_link; ?>"
              title="VK"
              target="_blank"
              class="button is-size-m is-style-bordered is-aspect-ratio-1b1"
              ><span class="icon" data-type="vk"></span
            ></a>
          <?php endif; ?>
          <?php if ($theme_contacts_max_link != ""): ?>
            <a
              href="<?php echo $theme_contacts_max_link; ?>"
              title="MAX"
              target="_blank"
              class="button is-size-m is-style-bordered is-aspect-ratio-1b1"
              ><span class="icon" data-type="max"></span
            ></a>
          <?php endif; ?>
        </div>
      </div>
      <div class="footer-content__nav">
        <?php wp_nav_menu( [
					'theme_location'  => 'footer_menu',
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
      </div>
    </div>
  </div>
  <div class="footer__copyright">
    <div class="content-wrapper">
      <span class="footer-copyright__label span is-size-xs"
        >&copy; <?php echo date('Y'); ?><?php if ($theme_copyright_name != '') { echo ' «'.$theme_copyright_name.'»'; } ?></span
      >
      <div class="footer-copyright__actions">
        <?php if($theme_privacy_link != ''): ?>
					<a
						href="<?php echo $theme_privacy_link; ?>"
						class="button is-size-s is-style-transparent is-hilight is-highlight"
					>Пользовательское соглашение</a>
				<?php endif; ?>
				<?php if($theme_offer_link != '' || $theme_offer_name != ''): ?>
					<a
						href="<?php echo $theme_offer_link; ?>"
						class="button is-size-s is-style-transparent is-hilight is-highlight <?php if ($theme_offer_link == '') { echo 'is-no-hover'; } ?>"
						><?php echo $theme_offer_name; ?></a
					>
				<?php endif; ?>
				<?php if($theme_licenses != ''): ?>
					<a
						href="<?php echo $theme_licenses; ?>"
						class="button is-size-s is-style-transparent is-hilight is-highlight"
					>Licenses</a>
				<?php endif; ?>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
<?php wp_footer(); ?>