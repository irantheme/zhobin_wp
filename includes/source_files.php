<?php

/**
 * Add theme file sources
 * @return void
 */
function add_theme_sources()
{
    // Adding javascript files =======================================================
    // Adding jquery js
    wp_enqueue_script('jquery-js', get_template_directory_uri() . '/assets/js/jquery-3.5.1.min.js', array('jquery'), '3.5.1', true);
    // Adding bootstrap bundle js
    wp_enqueue_script('bootstrap-bundle-js', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery-js'), '2020', true);
    // Adding swiper js
    wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), '6.4.11', true);
    // Adding aos js
    wp_enqueue_script('aos-js', get_template_directory_uri() . '/assets/js/aos.js', array(), '6.4.11', true);
    // Adding flexmasonry js
    // wp_enqueue_script('flexmasonry-js', get_template_directory_uri() . '/assets/js/flexmasonry.js', array(), '6.4.11', true);
    // Adding masonry js
    wp_enqueue_script('masonry-js', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', array(), '1.0', true);
    // Adding images loaded js
    wp_enqueue_script('images-loaded-js', get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', array(), '1.0', true);
    // Adding main js
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery-js'), '1.0', true);
    // Adding stylesheet files ======================================================
    // Adding fonts css
    wp_enqueue_style('fonts-css', get_template_directory_uri() . '/assets/css/fonts.css');
    // Adding normalize css
    wp_enqueue_style('normalize-css', get_template_directory_uri() . '/assets/css/normalize.css');
    // Adding Line icons css
    wp_enqueue_style('line-icons-css', get_template_directory_uri() . '/assets/css/lineicons.css');
    // Adding bootstrap css
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    // Adding swiper css
    wp_enqueue_style('swiper-css', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css');
    // Adding aos css
    wp_enqueue_style('aos-css', get_template_directory_uri() . '/assets/css/aos.css');
    // Adding flexmasonry css
    // wp_enqueue_style('flexmasonry-css', get_template_directory_uri() . '/assets/css/flexmasonry.css');
    // Adding inputs css
    wp_enqueue_style('inputs-css', get_template_directory_uri() . '/assets/css/inputs.css');
    // Adding style sheet (main)
    wp_enqueue_style('style', get_stylesheet_uri());
    // Access to wordpress features with custom script js
    wp_localize_script('main-js', 'wpData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}

// Run syles and scripts
add_action('wp_enqueue_scripts', 'add_theme_sources');


/**
 * Admin source files
 * @return void
 */
function add_admin_files()
{
    // We're including the farbtastic script & styles here because they're needed for the colour picker
    // If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
    wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
    // We're including the WP media scripts here because they're needed for the image upload field
    // If you're not including an image upload then you can leave this function call out
    wp_enqueue_media();
    // Admin css
    wp_register_style('admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0', 'all');
    wp_enqueue_style('admin-css');
    // Admin js
    wp_register_script('admin-script', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('admin-script');
}

// Run panel style
add_action('admin_enqueue_scripts', 'add_admin_files');
