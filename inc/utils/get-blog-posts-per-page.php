<?php
/**
 * Получает количество публикаций на странице блога
 * 
 * @return int Количество постов на странице
 */

function get_blog_posts_per_page() {
  return (int) get_option('posts_per_page');
}
