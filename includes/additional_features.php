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
 * @return string user role (persian)
 * @param int author id
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

/**
 * Better comments (Related to comments list)
 * @return void
 * @param string, args, depth
 */
if( ! function_exists( 'better_comments' ) ):
  function better_comments($comment, $args, $depth) { ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
      <div class="comment">
        <div class="comment-avatar">
          <?php echo get_avatar($comment); ?>
        </div>
        <div class="comment-content">
          <?php if ($comment->comment_approved == '0') : ?>
            <em><?php esc_html_e('نظر شما در صف بررسی است.','5balloons_theme') ?></em>
            <br />
          <?php endif; ?>
          <div class="comment-heading">
            <b><?php echo get_comment_author() ?></b>
            <span class="date"><?php printf(/* translators: 1: date and time(s). */ esc_html__('%1$s at %2$s' , '5balloons_theme'), get_comment_date(),  get_comment_time()) ?></span>
          </div>
          <div class="comment-body">
            <p>
              <?php comment_text() ?>
            </p>
          </div>
          <div class="comment-options">
            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            <?php edit_comment_link( __( 'ویرایش', 'textdomain' ), '  ', '' ); ?>
          </div>            
        </div>
      </div>
    </li>
  <?php
  }
endif;


/**
 * Change default gravatar
 * @param array
 * @return string (url user.png)
 */
function new_default_user_avatar ( $avatar_defaults ) {
  $customAvatar = get_template_directory_uri() . '/images/user.png';
  $avatar_defaults[$customAvatar] = "Default Gravatar";
  return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'new_default_user_avatar' );


/**
 * Redirect subscriber user to home after login
 * @return void
 */
function redirectSubsToFronted() {
  $currentUser = wp_get_current_user();
  if ( count($currentUser->roles) == 1 and $currentUser->roles[0] == 'subscriber' ) {
    wp_redirect(site_url('/'));
    exit;
  }
}
add_action('admin_init', 'redirectSubsToFronted');


/**
 * Hide admin bar in subscriber user
 * @return void
 */
function noSubsAdminBar() {
  $currentUser = wp_get_current_user();
  if (count($currentUser->roles) == 1 and $currentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}
add_action('wp_loaded', 'noSubsAdminBar');


/**
 * Customize login screen
 * @return string (url)
 */
function ourHeaderUrl() {
  return esc_url(site_url('/'));
}
add_filter('login_headerurl', 'ourHeaderUrl');


/**
 * Manually css to login screen
 * @return void
 */
function ourLoginCSS() {
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}
add_action('login_enqueue_scripts', 'ourLoginCSS');


/**
 * Manually title login screen
 * @return string (website title)
 */
function ourLoginTitle() {
  return get_bloginfo('name');
}
add_filter('login_headertext', 'ourLoginTitle');