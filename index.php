  <?php get_header(); ?>

  <!-- Content #####################3 -->
  <section id="content">
    <div class="container">

      <?php if ( get_option('zhobin_content_heading') || get_option('zhobin_content_description') ) : ?>
      <!-- Heading -->
      <div class="content-heading">
        <h2><?php echo get_option('zhobin_content_heading'); ?></h2>
        <p><?php echo get_option('zhobin_content_description'); ?></p>
      </div>
      <?php endif; ?>

      <?php
      $categories = get_categories( array( 'parent' => 0, 'hide_empty' => 0 ) );
      if ( count($categories) ) : ?>
      <!-- Category -->
      <div class="content-category">
        <ul>
          <li>
            <a href="#" class="active">همه</a>
          </li>
          <?php wp_list_categories(array(
            'depth' => 1,
            'style' => 'list',
            'separator' => '',
            'show_option_none' => '',
            'title_li' => ''
          )); ?>
        </ul>
      </div>
      <?php endif; ?>

    </div>

    <?php
    // Create new query with all post type for display posts
    $args = array(
        'post_type' => array( 'post' )
    );
    $post_custom_types = new WP_Query( $args);
    // Checking have post or no
    if ( $post_custom_types->have_posts() ) : ?>

    <!-- Posts ############################### -->
    <main id="posts">
      <div class="container">
        <!-- Masonry style post -->
        <div class="grid-masonry">
          <div class="grid-sizer"></div>
          <?php while ( $post_custom_types->have_posts()) : $post_custom_types->the_post(); ?>
          <!-- Post -->
          <div class="post-holder grid-item">
            <article class="post">

              <?php
              // Get all category of posts
              $categories = get_the_category();
              $categories_output = '';

              // Get post format
              $post_format = get_post_format();

              // Get gallery post, (true, false) -> related to html output or data
              $gallery_post = get_post_gallery( get_the_ID(), false);

              // Check video format
              if ( $post_format == 'video' ) :
              ?>
              <!-- Post video -->
              <div class="post-video">
                <?php
                $video_url =  wp_get_attachment_url( get_the_ID() );
                echo wp_video_shortcode( array(
                  'src' => $video_url
                ) );
                ?>
              </div>

              <?php

              elseif ( $post_format == 'gallery' && $gallery_post ) : ?>
              <!-- Post gallery -->
              <div class="post-slider">
                <a href="<?php echo get_the_permalink(); ?>" class="post-slider-link">
                  <!-- Swiper slider -->
                  <div class="swiper gallery-swiper">
                    <div class="swiper-wrapper">
                      <?php if ( has_post_thumbnail() ) : ?>
                      <div class="swiper-slide"><img src="<?php the_post_thumbnail_url('large'); ?>" alt="تصویر اصلی"></div>
                      <?php endif; ?>
                      <?php foreach ( $gallery_post['src'] as $gallery_src ) : ?>
                        <div class="swiper-slide"><img src="<?php echo $gallery_src; ?>" alt="گالری"></div>
                      <?php endforeach; ?>
                    </div>
                    <!-- Slider buttons -->
                    <div class="post-image-slider-buttons">
                      <div class="post-image-next"><i class="lni lni-chevron-right"></i>
                      </div>
                      <div class="post-image-prev"><i class="lni lni-chevron-left"></i>
                      </div>
                    </div>
                    <?php if ( ! empty( $categories ) ) : ?>
                    <!-- Post category -->
                    <div class="post-category">
                      <?php
                      foreach( $categories as $category ) {
                        $categories_output .= '<span>' . esc_html( $category->name ) . '</span>';
                      }
                      echo trim( $categories_output, '' );
                      ?>
                    </div>
                    <?php endif; ?>
                  </div>
                </a>
              </div>

              <?php elseif ( has_post_thumbnail() ) : ?>
              <!-- Post image -->
              <div class="post-image">
                <a href="<?php echo get_the_permalink(); ?>" class="post-image-link">
                  <img src="<?php the_post_thumbnail_url('large'); ?>" alt="Image post">
                  <?php if ( ! empty( $categories ) ) : ?>
                  <!-- Post category -->
                  <div class="post-category">
                    <?php
                    // Adding all category of post
                    foreach( $categories as $category ) {
                      $categories_output .= '<span>' . esc_html( $category->name ) . '</span>';
                    }
                    echo trim( $categories_output, '' );
                    ?>
                  </div>
                  <?php endif; ?>
                </a>
              </div>

              <?php else : 
              if ( ! empty( $categories ) ) : ?>
              <!-- Post category -->
              <div class="post-category">
                <?php
                  foreach( $categories as $category ) {
                    $categories_output .= '<a href=" ' . esc_html( $category->link ) . '">' . esc_html( $category->name ) . '</a>';
                  }
                  echo trim( $categories_output, '' );
                ?>
              </div>
              <?php endif;
              endif; ?>

              <!-- Post content -->
              <div class="post-content">
                <!-- Post date -->
                <div class="post-date">
                  <span><?php echo get_the_date('j, F Y'); ?></span>
                </div>
                <!-- Post heading -->
                <div class="post-heading">
                  <h2><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
                </div>
                <!-- Post text -->
                <div class="post-text">
                  <p><?php echo wp_trim_words( strip_shortcodes( get_the_excerpt() ), 43); ?></p>
                </div>
              </div>

              <!-- Post info -->
              <div class="post-info">
                <!-- Post author -->
                <div class="post-author">
                  <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="Author">
                  <div>
                    <cite><?php echo get_the_author_posts_link(); ?></cite>
                    <?php if ( get_the_author_meta('nickname') ) : ?>
                    <span><?php echo get_the_author_meta('nickname'); ?></span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </article>
          </div>
          <?php endwhile; ?>

        </div>
      </div>
    </main>

    <!-- Load more -->
    <div class="load-more">
      <div class="container">
        <!-- Button loading more -->
        <button id="loading-more" class="active">
          <cite>بارگذاری</cite>
          <span><i class="lni lni-reload"></i></span>
        </button>
      </div>
    </div>

    <?php endif; ?>
  </section>

  <?php get_footer(); ?>
