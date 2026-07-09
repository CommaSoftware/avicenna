<?php

// Include main scsripts
foreach ( glob( get_template_directory() . '/inc/*.php' ) as $file ) {
    require_once $file;
}

// Include customizers
foreach ( glob( get_template_directory() . '/inc/customizer/*.php' ) as $file ) {
    require_once $file;
}

// Include utils
foreach ( glob( get_template_directory() . '/inc/utils/*.php' ) as $file ) {
    require_once $file;
}

// Include meta fields
foreach ( glob( get_template_directory() . '/inc/meta-fields/*.php' ) as $file ) {
    require_once $file;
}