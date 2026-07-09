<?php

function styles_n_scripts() {
	// Main styles
	enqueue_versioned_style( 'style-main',                       '/style.css' );
	enqueue_versioned_style( 'style-cms-content',                '/assets/css/cms-content.css' );
	enqueue_versioned_style( 'style-fonts',                      '/assets/css/fonts.css' );
	enqueue_versioned_style( 'style-normalize',                  '/assets/css/normalize.css' );
	enqueue_versioned_style( 'style-root',                       '/assets/css/root.css' );
	enqueue_versioned_style( 'style-ui',                         '/assets/css/ui.css' );
	
	// Shared components
	enqueue_versioned_style( 'style-shared-button',              '/assets/css/shared/button.css' );
	enqueue_versioned_style( 'style-shared-dropdown-menu',       '/assets/css/shared/dropdown-menu.css' );
	enqueue_versioned_style( 'style-shared-flex',                '/assets/css/shared/flex.css' );
	enqueue_versioned_style( 'style-shared-heading',             '/assets/css/shared/heading.css' );
	enqueue_versioned_style( 'style-shared-icons',               '/assets/css/shared/icons.css' );
	enqueue_versioned_style( 'style-shared-logo',                '/assets/css/shared/logo.css' );
	enqueue_versioned_style( 'style-shared-span',                '/assets/css/shared/span.css' );
	
	// Entity components
	enqueue_versioned_style( 'style-entities-bg-highlight',      '/assets/css/entities/bg-highlight.css' );
	enqueue_versioned_style( 'style-entities-blog-card',         '/assets/css/entities/blog-card.css' );
	enqueue_versioned_style( 'style-entities-breadcrumbs',       '/assets/css/entities/breadcrumbs.css' );
	enqueue_versioned_style( 'style-entities-buttons-block',     '/assets/css/entities/buttons-block.css' );
	enqueue_versioned_style( 'style-entities-content-wrapper',   '/assets/css/entities/content-wrapper.css' );
	enqueue_versioned_style( 'style-entities-cookie-overlay',    '/assets/css/entities/cookie-overlay.css' );
	enqueue_versioned_style( 'style-entities-filial-card',       '/assets/css/entities/filial-card.css' );
	enqueue_versioned_style( 'style-entities-float-img',         '/assets/css/entities/float-img.css' );
	enqueue_versioned_style( 'style-entities-for-patients-card', '/assets/css/entities/for-patients-card.css' );
	enqueue_versioned_style( 'style-entities-heading-block',     '/assets/css/entities/heading-block.css' );
	enqueue_versioned_style( 'style-entities-pagination',        '/assets/css/entities/pagination.css' );
	enqueue_versioned_style( 'style-entities-popup',             '/assets/css/entities/popup.css' );
	enqueue_versioned_style( 'style-entities-section-header',    '/assets/css/entities/section-header.css' );
	enqueue_versioned_style( 'style-entities-specialist-card',   '/assets/css/entities/specialist-card.css' );
	
	// Widget components
	enqueue_versioned_style( 'style-widgets-blog',               '/assets/css/widgets/blog.css' );
	enqueue_versioned_style( 'style-widgets-faq',                '/assets/css/widgets/faq.css' );
	enqueue_versioned_style( 'style-widgets-filial-content',     '/assets/css/widgets/filial-content.css' );
	enqueue_versioned_style( 'style-widgets-filials',            '/assets/css/widgets/filials.css' );
	enqueue_versioned_style( 'style-widgets-footer',             '/assets/css/widgets/footer.css' );
	enqueue_versioned_style( 'style-widgets-header',             '/assets/css/widgets/header.css' );
	enqueue_versioned_style( 'style-widgets-main-banner',        '/assets/css/widgets/main-banner.css' );
	enqueue_versioned_style( 'style-widgets-not-found',          '/assets/css/widgets/not-found.css' );
	enqueue_versioned_style( 'style-widgets-single',             '/assets/css/widgets/single.css' );
	
	// Scripts
	enqueue_versioned_script( 'script-clipboard',                '/assets/js/clipboard.js', array(), true );
	enqueue_versioned_script( 'script-cookie',                   '/assets/js/cookie.js', array(), true );
	enqueue_versioned_script( 'script-float-img-win',            '/assets/js/float-img-win.js', array(), true );
	enqueue_versioned_script( 'script-header',                   '/assets/js/header.js', array(), true );
	enqueue_versioned_script( 'script-popup',                    '/assets/js/popup.js', array(), true );
	enqueue_versioned_script( 'script-smooth-scroll',            '/assets/js/smooth-scroll.js', array(), true );

}
add_action( 'wp_enqueue_scripts', 'styles_n_scripts' );

// Dynamic versioning of files with styles
function enqueue_versioned_script( $handle, $src = false, $deps = array(), $in_footer = false ) {
	wp_enqueue_script( $handle, get_stylesheet_directory_uri() . $src, $deps, filemtime( get_stylesheet_directory() . $src ), $in_footer );
}
function enqueue_versioned_style( $handle, $src = false, $deps = array(), $media = 'all' ) {
	wp_enqueue_style( $handle, get_stylesheet_directory_uri() . $src, $deps = array(), filemtime( get_stylesheet_directory() . $src ), $media );
} 