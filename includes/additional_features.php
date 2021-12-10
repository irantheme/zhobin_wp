<?php

// Features includes ====================================================

/**
 * Add features
 * @return void
 */
function include_features()
{
    // Register nav header
    register_nav_menu('headerNavLocation', 'Header Navigate Location');
    // Add title tag
    add_theme_support('title-tag');
    // Add thumbnail image to posts
    add_theme_support('post-thumbnails');
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    // Add post format features
    add_theme_support(
        'post-formats',
        array(
            // 'link',
            // 'aside',
            'gallery',
            // 'image',
            'quote',
            // 'status',
            'video',
            'audio',
            // 'chat',
        )
    );
    // Add image size
    // add_image_size('professorLandscape', 400, 260, true);
    // add_image_size('professorPortraite', 480, 650, true);
    // add_image_size('pageBanner', 1500, 350, true);
}

// Run above
add_action('after_setup_theme', 'include_features');


/**
 * Modifying gallery image sizes
 * @return array
 * @param output, pairs atts
 */
function modify_gallery_image_size( $output, $pairs, $atts ) {
    $atts = shortcode_atts( array(
      'columns' => '2',
      'size' => 'large',
    ), $atts );
 
    $output['columns'] = $atts['columns'];
    $output['size'] = $atts['size'];
 
    return $output;
 
}
add_filter( 'shortcode_atts_gallery', 'modify_gallery_image_size', 10, 3 );