<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>

  <?php $header_img_url = wp_get_attachment_image_src(get_option('zhobin_header_bg'), 'full'); ?>

  <!-- Header ############################### -->
  <header id="header" style="background-image: url('<?php echo $header_img_url[0]; ?>');">
    <div class="container-fluid">
      <!-- Hero -->
      <div class="hero">
        <!-- Main menu -->
        <div class="main-menu">
          <!-- Logo -->
          <div class="logo">
            <strong><a href="<?php echo site_url(); ?>"><?php bloginfo('title'); ?></a></strong>
          </div>
          <!-- Options -->
          <div class="options">
            <!-- Nav toggle -->
            <a id="nav-open" data-type="open">
              <span></span>
              <span></span>
              <span></span>
            </a>
            <!-- Search toggle -->
            <a id="nav-search-open" data-type="close" data-search="1">
              <i class="lni lni-search-alt"></i>
            </a>
          </div>
        </div>
        <!-- Showcase -->
        <div class="showcase">
          <?php if ( get_bloginfo('description') || get_option('zhobin_header_extra_description') ) : ?>
          <!-- Heading -->
          <div class="heading">
            <h1><?php bloginfo('description'); ?></h1>
            <p><?php echo get_option('zhobin_header_extra_description'); ?></p>
          </div>
          <?php endif; ?>
          <!-- Social networks -->
          <div class="social-networks">
            <?php
            // Custom wp nav menu items (Social media)
            $socialMenu = get_nav_menu_locations(); // Where menu1 can be ID, slug or title
            $socialMenuID = $socialMenu['socialMediaLocation'];
            $socialMediaItems = wp_get_nav_menu_items($socialMenuID);
            foreach($socialMediaItems as $social){
              echo '<a href="' . $social->url . '"><i class="lni lni-' . $social->title . '"></i></a>';
            }
            ?>
          </div>
          <!-- Mouse down -->
          <div class="mouse-down">
            <a href="#content" id="mouse-down-toggle"></a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Nav mask ############################# -->
  <div id="nav-mask" data-type="close"></div>

  <!-- Navigation ############################### -->
  <nav id="navigation">
    <!-- Nav options -->
    <div class="nav-options">
      <cite>
        <?php
        if ( get_option('zhobin_banner') ) :
          echo get_option('zhobin_banner');
        else:
          bloginfo('name');
        endif;
        ?>
      </cite>
      <a id="nav-close" data-type="close"><i class="lni lni-close"></i></a>
    </div>
    <!-- Nav menu -->
    <div class="nav-menu">
      <?php
        wp_nav_menu(array(
            'theme_location' => 'headerNavLocation',
            'depth' => 1
        ));
      ?>
    </div>
  </nav>

  <!-- Search overlay ################################### -->
  <div id="search-overlay">
    <div class="container">
      <!-- Search box -->
      <div class="search-box">
        <input type="text" class="search-input" placeholder="به دنبال چیزی هستید؟">
        <span class="search-case search-case-alt">
          <i id="search-alt" class="lni lni-search-alt"></i>
          <i id="spinner-alt" class="animate-rotate"></i>
        </span>
        <span class="search-case" id="nav-search-close" data-type="close" data-search="0"><i
            class="lni lni-close"></i></span>
      </div>
      <!-- Search results -->
      <div class="search-results"></div>
    </div>
  </div>
