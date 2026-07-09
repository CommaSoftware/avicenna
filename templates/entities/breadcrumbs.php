<?php
/**
 * Breadcrumbs Template
 * 
 * @var array $args: ['name', 'href']
 * 
 * Usage:
 * get_template_part('breadcrumbs', null, [
 *   ['name' => 'Блог', 'href' => '/blog'],
 *   ['name' => 'Статья', 'href' => '/blog/article']
 * ]);
 */

$breadcrumbs = isset($args) && is_array($args) ? $args : [];
?>

<div class="breadcrumbs">
	<span class="breadcrumbs__item">
		<a href="<?php echo esc_url(home_url('/')); ?>">Главная</a>
	</span>
	
	<?php foreach ($breadcrumbs as $index => $item) : ?>
			<?php if (empty($item['name'])) continue; ?>
			<span class="breadcrumbs__item">
				<?php if (!empty($item['href'])) : ?>
					<a href="<?php echo $item['href']; ?>">
						<?php echo esc_html($item['name']); ?>
					</a>
				<?php else : ?>
					<?php echo esc_html($item['name']); ?>
				<?php endif; ?>
			</span>
	<?php endforeach; ?>
</div>