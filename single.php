  <?php get_header(); ?>

  <?php while ( have_posts() ) : the_post(); ?>

  <?php
  // Get all category of posts
  $categories = get_the_category();
  // Get post format
  $post_format = get_post_format();

  // Get gallery post, (true, false) -> related to html output or data
  $gallery_post = get_post_gallery( get_the_ID(), false);

  // Init url video
  $video_url =  wp_get_attachment_url( get_the_ID() );
  $videoElement = wp_video_shortcode( array( 'src' => $video_url ) );

  if ( $post_format == 'gallery' && $gallery_post ) : 
  ?>

  <!-- Single gallery overlay -->
  <div class="single-gallery-overlay">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 mx-auto">
          <!-- Swiper -->
          <div class="swiper swiper-gallery-overlay">
            <div class="swiper-wrapper">
              <?php if ( has_post_thumbnail() ) : ?>
              <div class="swiper-slide"><img src="<?php the_post_thumbnail_url('large'); ?>" alt="Image gallery"></div>
              <?php endif;
              foreach ( $gallery_post['src'] as $gallery_src ) : ?>
              ?>
              <div class="swiper-slide"><img src="<?php echo $gallery_src; ?>" alt="Image gallery"></div>
              <?php endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Close gallery overlay -->
    <span id="close-gallery-overlay"><i class="lni lni-close"></i></span>
  </div>

  <?php endif; ?>

  <!-- Content #####################3 -->
  <section id="content">
    <!-- Single ############################### -->
    <main id="single">
      <div class="container">
        <!-- Single post -->
        <article class="single-post">
          <div class="row">
            <div class="col-lg-6">
              <!-- Single gallery -->
              <div class="single-gallery <?php if ( $post_format == 'gallery' && $gallery_post ) { echo 'active'; } ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                <!-- Single gallery main img -->
                <div class="single-gallery-img">
                  <img src="<?php the_post_thumbnail_url('large'); ?>" alt="Image gallery">
                </div>
                <?php endif;
                if ( $post_format == 'gallery' && $gallery_post ) : 
                ?>
                <!-- Single gallery list img -->
                <ul class="single-gallery-list">
                  <?php
                  $counterDataGallery = 1;
                  foreach ( $gallery_post['src'] as $gallery_src ) : ?>
                  <li><img src="<?php echo $gallery_src; ?>" data-gallery="<?php echo $counterDataGallery; ?>" alt="Image gallery"></li>
                  <?php
                  $counterDataGallery++;
                  endforeach;
                  ?>
                </ul>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-lg-6">
              <!-- Single content -->
              <div class="single-content">
                <!-- Single heading -->
                <div class="single-heading">
                  <h1><?php the_title(); ?></h1>
                </div>
                <!-- Single text -->
                <div class="single-text"><?php the_content(); ?></div>
                <!-- Single info -->
                <div class="single-info">
                  <ul>
                    <?php if ( has_category() ) : ?>
                    <!-- Category & date -->
                    <li>
                      <b>دسته بندی</b>
                      <span>
                        <?php
                        foreach ( $categories as $category ) {
                          echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>';
                        }
                        ?>
                      </span>
                    </li>
                    <?php endif; ?>
                    <li>
                      <b>تاریخ انتشار</b>
                      <span><?php echo get_the_date('j, F Y'); ?></span>
                    </li>
                  </ul>
                  <!-- Author & Share -->
                  <ul>
                    <li>
                      <b>نویسنده</b>
                      <span>
                        <?php echo get_the_author_posts_link(); ?>
                      </span>
                    </li>
                    <li>
                      <b>اشتراک گذاری</b>
                      <span class="single-share">
                        <a href="https://www.facebook.com/sharer?u=<?php the_permalink();?>;?t=<?php the_title(); ?>;" data-toggle="tooltip" data-placement="top" title="اشتراک گذاری در فیس بوک" target="_blank"><i class="lni lni-facebook-filled"></i></a>
                        <a href="http://twitter.com/share?url=<?php the_title(); ?><?php the_permalink();?>" data-toggle="tooltip" data-placement="top" title="اشتراک گذاری در توئیتر" target="_blank"><i class="lni lni-twitter-filled"></i></a>
                        <a href="http://www.linkedin.com/shareArticle?mini=true?url=<?php the_permalink() ?>?title=<?php the_title(); ?>?summary=?source=<?php bloginfo('name'); ?>" data-toggle="tooltip" data-placement="top" title="اشتراک گذاری در لینکدین" target="_blank"><i class="lni lni-linkedin"></i></a>
                        <a href="whatsapp://send?text=<?php the_title(); ?><?php the_permalink();?>" data-toggle="tooltip" data-placement="top" title="اشتراک گذاری در واتس آپ" target="_blank"><i class="lni lni-whatsapp"></i></a>
                        <a href="https://t.me/share/url?url=<?php the_title(); ?><?php the_permalink(); ?>" data-toggle="tooltip" data-placement="top" title="اشتراک گذاری در تلگرام" target="_blank"><i class="lni lni-telegram"></i></a>
                      </span>
                    </li>
                  </ul>
                  <?php if ( has_tag() ) : ?>
                  <!-- Labels -->
                  <ul class="single-labels">
                    <li>
                      <b>برچسب ها</b>
                      <span>
                        <?php the_tags( '', '', '' ); ?>
                      </span>
                    </li>
                  </ul>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </article>
      </div>
    </main>
  </section>
  
  <?php
  // If comments are open or we have at least one comment, load up the comment template.
  if ( comments_open() || get_comments_number() ) :
      comments_template();
  endif;
  ?>
  

  <?php endwhile; ?>

  <?php get_footer(); ?>