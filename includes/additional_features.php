<?php

// Features includes ====================================================

/**
 * Add features
 * @return void
 */
function include_features()
{
  // Register nav header
  register_nav_menu('headerNavLocation', 'منوی شناور اصلی');
  // Register nav social media
  register_nav_menu('socialMediaLocation', 'شبکه های اجتماعی');
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
// Run above
add_filter( 'shortcode_atts_gallery', 'modify_gallery_image_size', 10, 3 );


/**
 * @return role string
 * @param author_ID author
 */
function author_role_text( $authorID ) {
  // Data of user role
  $theAuthorDataRole = get_userdata($authorID);
  // Convert to text role
  $theRoleAuthor = $theAuthorDataRole->roles;
  $theRoleAuthor = ''.implode('', $theRoleAuthor);
  // Temp of converted author role
  $user_role = '';
  // Check user roles
  switch ( $theRoleAuthor ) {
    case 'administrator':
    case 'Administrator':
      $user_role = 'مدیریت کل';
      break;
    case 'editor':
    case 'Editor':
      $user_role = 'ویرایشگر';
      break;
    case 'author':
    case 'Author':
      $user_role = 'نویسنده';
      break;
    case 'contributor':
    case 'Contributor':
      $user_role = 'مشارکت کننده';
      break;
    case 'subscriber':
    case 'Subscriber':
      $user_role = 'مشترک';
      break;
    case 'shop_manager':
    case 'Shop_manager':
      $user_role = 'مدیر فروشگاه';
      break;
    case 'customer':
    case 'Customer':
      $user_role = 'مشتری';
      break;
    default:
      $user_role = 'کاربر';
      break;
  }
  return $user_role;
}