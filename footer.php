  <?php
  $latestCommentsQuery = new WP_Comment_Query();
  $latestComments = $latestCommentsQuery->query( array( 
    'number' => 6
  ) );

  if ( $latestComments ) :
  ?>
  <?php $latest_comments_bg = wp_get_attachment_image_src(get_option('zhobin_footer_latest_comments_bg'), 'full'); ?>
  <!-- Latest comments ################################### -->
  <section id="latest-comments" style="background-image: url('<?php echo esc_url( $latest_comments_bg[0] ); ?>');">
    <div class="container">
      <!-- Comments list -->
      <div class="latest-comments-list">
        <!-- Lable of comments -->
        <small id="label-of-comments">آخرین دیدگاه ها</small>
        <div class="comments-swiper">
          <!-- Swiper -->
          <div class="swiper comments-swiper">
            <div class="swiper-wrapper">
              <?php
              foreach ($latestComments as $comment) :
              ?>
              <!-- Comment item -->
              <div class="swiper-slide">
                <div class="comment-item">
                  <?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
                  <div>
                    <cite><?php echo get_comment_author( $comment->comment_ID ); ?></cite>
                    <p><?php echo apply_filters( 'get_comment_text', $comment->comment_content ); ?></p>
                    <a href="<?php echo get_permalink( $comment->comment_post_ID ); ?>">مشاهده</a>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- Footer ###################################### -->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-6">
          <!-- Heading footer -->
          <div class="heading-footer">
            <b><?php bloginfo('name'); ?></b>
            <?php if ( get_option('zhobin_banner') ) : ?>
            <em><?php echo esc_html( get_option('zhobin_banner') ); ?></em>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <?php if ( get_option( 'zhobin_footer_copyright_text' ) ) : ?>
          <!-- Copy right -->
          <div class="copyright">
            <?php echo esc_html( get_option( 'zhobin_footer_copyright_text' ) ); ?>
          </div>
          <?php endif; ?>
        </div>
        <div class="col-lg-6">
          <!-- Social -->
          <div class="social">
            <?php
            // Custom wp nav menu items (Social media)
            $socialMenu = get_nav_menu_locations(); // Where menu1 can be ID, slug or title
            $socialMenuID = $socialMenu['socialMediaLocation'];
            $socialMediaItems = wp_get_nav_menu_items($socialMenuID);
            foreach($socialMediaItems as $social){
              echo '<a href="' . esc_url( $social->url ) . '"><i class="lni lni-' . esc_attr( $social->title ) . '"></i></a>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <?php wp_footer(); ?>
</body>

</html>