<!-- Post -->
<?php
// Get parent id category of post
$category = get_the_category();
// $category_parent_list = array();
$category_parents_id = '';
foreach( $category as $cate ) {
  if ( $cate->parent ) {
    // From your child category, grab parent ID
    $parent = $cate->parent;

    // Load object for parent category
    $parent_id = get_category( $parent );

    // Grab a category name
    $parent_id = $parent_id->term_id;
    $category_parents_id .= strval( $parent_id ).',';
  } else {
    $category_parents_id .= strval( $cate->term_id ).',';
  }
}
?>
<div class="post-holder grid-item" data-cate="<?php echo esc_attr( $category_parents_id ); ?>">
  <article class="post">

    <?php
    // Get all category of posts
    $categories = get_the_category();
    $categories_output = '';

    // Get post format
    $post_format = get_post_format();

    // Get gallery post, (true, false) -> related to html output or data
    $gallery_post = get_post_gallery( get_the_ID(), false );

    // Init url video
    $video_url =  wp_get_attachment_url( get_the_ID() );
    $videoElement = wp_video_shortcode( array( 'src' => esc_url( $video_url ) ) );

    // Check video format
    if ( $post_format == 'video' && $videoElement ) :
    ?>
    <!-- Post video -->
    <div class="post-video">
      <?php
      echo $videoElement;
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
              <div class="swiper-slide"><img src="<?php echo esc_url( $gallery_src ); ?>" alt="گالری"></div>
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
              $categories_output .= '<span>' . __( $category->name ) . '</span>';
            }
            echo trim( __( $categories_output ), '' );
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
            $categories_output .= '<span>' . __( $category->name ) . '</span>';
          }
          echo trim( __( $categories_output ), '' );
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
          $categories_output .= '<a href=" ' . esc_attr( $category->link ) . '">' . __( $category->name ) . '</a>';
        }
        echo trim( esc_html( $categories_output ), '' );
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
        <img src="<?php echo get_avatar_url( get_the_author_meta('ID') ); ?>" alt="Author">
        <div>
          <cite><?php echo get_the_author_posts_link(); ?></cite>
          <span><?php echo author_role_text( get_the_author_meta('ID') ); ?></span>
        </div>
      </div>
    </div>
  </article>
</div>