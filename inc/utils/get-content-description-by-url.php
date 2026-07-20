<?php
// Функция для получения описания страницы/записи по URL
function get_content_description_by_url($url) {
  if (empty($url)) {
    return '';
  }
  
  // Получаем ID поста по URL
  $post_id = url_to_postid($url);
  
  if ($post_id) {
    $post = get_post($post_id);
    if ($post) {
      // Получаем описание (excerpt) или обрезаем контент
      if (!empty($post->post_excerpt)) {
        return wp_trim_words($post->post_excerpt, 20, '...');
      } else {
        return wp_trim_words(strip_tags($post->post_content), 20, '...');
      }
    }
  }
  
  return '';
}
?>