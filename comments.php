<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
 
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
  return;
?>
 
<section id="comments">
  <div class="container">
    <!-- Comment form -->
    <?php comment_form(); ?>
    
    <!-- Check have comment -->
    <?php if ( have_comments() ) : ?>

      <div class="comments-holder">
        <ul class="comments-list">
          <?php
          wp_list_comments( array(
            'avatar_size' => 100,
            'style'      => 'ul',
            'short_ping' => true,
            'callback' => 'better_comments',
            'reverse_top_level' => true,
            // 'per_page' => 2
          ) );
          ?>
        </ul><!-- .comment-list -->
  
        <?php
          // Are there comments to navigate through?
          if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
        ?>
        <!-- Pagination comments list -->
        <div class="pagination">
          <?php paginate_comments_links(); ?>
        </div>
        <?php endif; // Check for comment navigation ?>
      </div>
    
    <?php endif; // have_comments() ?>
  </div>
 
    
 
</section><!-- #comments -->
