<?php
  // Получаем меню по локации
  $menu_location = 'for_patient';
  $menu_locations = get_nav_menu_locations();
  
  if (!isset($menu_locations[$menu_location])) {
    return false;
  }
  
  $menu_id = $menu_locations[$menu_location];
  $menu_items = wp_get_nav_menu_items($menu_id);
  
  if (empty($menu_items)) {
      return false;
  }
?>

<section id="for_patients">
  <div class="content-wrapper">
    <div class="heading-block">
      <h2 class="heading is-size-h2">Пациенту</h2>
    </div>
  </div>
  <div class="content-wrapper is-grid-4">
    <?php foreach ($menu_items as $item) : ?>
      <div class="for-patients-card">
        <div class="for-patients-card__header">
          <h3 class="heading is-size-h5">
            <a href="<?php echo esc_url($item->url); ?>">
              <?php echo esc_html($item->title); ?>
            </a>
          </h3>
          <span class="icon" data-type="arrow-up-right-md"></span>
        </div>
        <?php $description = $item->description; ?>
        <?php if (!empty($description)) : ?>
          <div class="for-patients-card__content">
            <p><?php echo esc_html($description); ?></p>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
