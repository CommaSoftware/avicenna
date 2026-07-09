<?php
function get_custom_post_date() {
    $post_date = get_the_date('U'); // Получаем timestamp даты поста
    $current_year = date('Y');
    $post_year = date('Y', $post_date);
    
    // Форматируем дату
    if ($post_year == $current_year) {
        // Текущий год - выводим только день и месяц
        $date_format = 'j F';
    } else {
        // Не текущий год - добавляем год с апострофом
        $date_format = 'j F \'y';
    }
    
    return get_the_date($date_format);
}
?>