<?php

// Features includes ====================================================

if (!function_exists('irantheme_include_features')) {
  /**
   * Add features
   * @return void
   */
  function irantheme_include_features()
  {
    // Register nav header
    register_nav_menu('headerNavLocation', 'منوی شناور اصلی');
    // Add title tag
    add_theme_support('title-tag');
    // Add thumbnail image to posts
    add_theme_support('post-thumbnails');
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');
    // Search form support
    add_theme_support('html5', array('search-form'));
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
        // 'audio',
        // 'chat',
      )
    );
    // Add image size
    // add_image_size('professorLandscape', 400, 260, true);
    // add_image_size('professorPortraite', 480, 650, true);
    // add_image_size('pageBanner', 1500, 350, true);

    @ini_set(
      'upload_max_size',
      '64M'
    );
    @ini_set('post_max_size', '64M');
    @ini_set(
      'max_execution_time',
      '300'
    );
  }
  add_action('after_setup_theme', 'irantheme_include_features');
}


if (!function_exists('irantheme_modify_gallery_image_size')) {
  /**
   * Modifying gallery image sizes
   * @return array
   * @param output, pairs atts
   */
  function irantheme_modify_gallery_image_size($output, $pairs, $atts)
  {
    $atts = shortcode_atts(array(
      'columns' => '2',
      'size' => 'large',
    ), $atts);

    $output['columns'] = $atts['columns'];
    $output['size'] = $atts['size'];

    return $output;
  }
  add_filter('shortcode_atts_gallery', 'irantheme_modify_gallery_image_size', 10, 3);
}


if (!function_exists('irantheme_author_role_text')) {
  /**
   * @return string user role (persian)
   * @param int author id
   */
  function irantheme_author_role_text($authorID)
  {
    // Data of user role
    $theAuthorDataRole = get_userdata($authorID);
    // Convert to text role
    $theRoleAuthor = $theAuthorDataRole->roles;
    $theRoleAuthor = '' . implode('', $theRoleAuthor);
    // Temp of converted author role
    $user_role = '';
    // Check user roles
    switch ($theRoleAuthor) {
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
    return __($user_role);
  }
}

/**
 * Better comments (Related to comments list)
 * @return void
 * @param string, args, depth
 */
if (!function_exists('irantheme_better_comments')) {
  function irantheme_better_comments($comment, $args, $depth)
  { ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
      <div class="comment">
        <div class="comment-avatar">
          <?php echo get_avatar($comment); ?>
        </div>
        <div class="comment-content">
          <?php if ($comment->comment_approved == '0') : ?>
            <em><?php esc_html_e('نظر شما در صف بررسی است.', '5balloons_theme') ?></em>
            <br />
          <?php endif; ?>
          <div class="comment-heading">
            <b><?php echo get_comment_author() ?></b>
            <span class="date"><?php printf(/* translators: 1: date and time(s). */esc_html__('%1$s at %2$s', '5balloons_theme'), get_comment_date(),  get_comment_time()) ?></span>
          </div>
          <div class="comment-body">
            <p>
              <?php comment_text() ?>
            </p>
          </div>
          <div class="comment-options">
            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            <?php edit_comment_link(__('ویرایش', 'textdomain'), '  ', ''); ?>
          </div>
        </div>
      </div>
    </li>
<?php
  }
};


if (!function_exists('irantheme_redirect_subscriber_to_fronted')) {
  /**
   * Redirect subscriber user to home after login
   * @return void
   */
  function irantheme_redirect_subscriber_to_fronted()
  {
    $currentUser = wp_get_current_user();
    if (count($currentUser->roles) == 1 and $currentUser->roles[0] == 'subscriber') {
      wp_redirect(site_url('/'));
      exit;
    }
  }
  add_action('admin_init', 'irantheme_redirect_subscriber_to_fronted');
}


if (!function_exists('irantheme_no_subscriber_admin_bar')) {
  /**
   * Hide admin bar in subscriber user
   * @return void
   */
  function irantheme_no_subscriber_admin_bar()
  {
    $currentUser = wp_get_current_user();
    if (count($currentUser->roles) == 1 and $currentUser->roles[0] == 'subscriber') {
      show_admin_bar(false);
    }
  }
  add_action('wp_loaded', 'irantheme_no_subscriber_admin_bar');
}


if (!function_exists('irantheme_login_header_url')) {
  /**
   * Customize login screen
   * @return string (url)
   */
  function irantheme_login_header_url()
  {
    return esc_url(site_url('/'));
  }
  add_filter('login_headerurl', 'irantheme_login_header_url');
}


if (!function_exists('irantheme_add_css_to_login')) {
  /**
   * Manually css to login screen
   * @return void
   */
  function irantheme_add_css_to_login()
  {
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
  }
  add_action('login_enqueue_scripts', 'irantheme_add_css_to_login');
}


if (!function_exists('irantheme_login_title')) {
  /**
   * Manually title login screen
   * @return string (website title)
   */
  function irantheme_login_title()
  {
    return get_bloginfo('name');
  }
  add_filter('login_headertext', 'irantheme_login_title');
}
