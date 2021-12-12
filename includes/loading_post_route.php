<?php


/**
 * Register custom json search url
 * @return void
 */
function registerLoadingPosts() {
  register_rest_route( 'json/v1', 'post', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'resultsPosts',
    'permission_callback' => '__return_true'
  ) );
}
// Run above
add_action( 'rest_api_init', 'registerLoadingPosts' );


/**
 * Pin results to custom search
 * @return array
 * @param array data
 */
function resultsPosts( $data ) {

  // Getting new query for post and page type
  $mainQuery = new WP_Query( array(
    'post_type' => array( 'post' ),
    's' => sanitize_text_field( $data['term'] ) // Sanitize is more security for wordpress functions
  ) );

  // Create results for maintenance created json data
  $results = array(
    'post' => array()
  );

  // Check of of them posts
  while ( $mainQuery->have_posts() ) {
    $mainQuery->the_post();

    $category_temp = array();
    if (has_category()) {
      // Get all category of posts
      $categories = get_the_category();
      foreach($categories as $category) {
        array_push($category_temp, array($category->name => get_category_link($category->term_id)));
      }
    }
    // Init temporaries
    $video_temp = null;
    $gallery_temp = null;
    // Get post format
    $post_format = get_post_format();
    if ($post_format == 'gallery') {
      // Get gallery post, (true, false) -> related to html output or data
      $gallery_post = get_post_gallery( get_the_ID(), false);
      $gallery_temp = array();
      foreach ($gallery_post['src'] as $src) {
        array_push($gallery_temp, $src);
      }
    } else if ($post_format == 'video') {
      // Video init
      $video_url =  wp_get_attachment_url( get_the_ID() );
      $video_temp = wp_video_shortcode( array( 'src' => $video_url ) );
    }
    // Get parent id category of post
    $category = get_the_category();
    // $category_parent_list = array();
    $category_parents_id = '';
    foreach($category as $cate) {
      if ($cate->parent) {
        // From your child category, grab parent ID
        $parent = $cate->parent;

        // Load object for parent category
        $parent_id = get_category($parent);

        // Grab a category name
        $parent_id = $parent_id->term_id;
        $category_parents_id .= strval($parent_id).',';
      } else {
        $category_parents_id .= strval($cate->term_id).',';
      }
    }
    // Appending data to results array
    if ( get_post_type() == 'post' ) {
      array_push( $results['post'], array(
        'title' => get_the_title(),
        'content' => wp_trim_words( strip_shortcodes( get_the_excerpt() ), 43),
        'permalink' => get_the_permalink(),
        'imageSrc' => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
        'postFormat' => $post_format,
        'video' => $video_temp,
        'gallery' => $gallery_temp,
        'category' => $category_temp,
        'date' => get_the_date('j, F Y'),
        'author' => get_the_author_posts_link(),
        'authorNickname' => get_the_author_meta('nickname'),
        'authorAvatar' => get_avatar_url(get_the_author_meta('ID')),
        'dataCategory' => $category_parents_id
      ) );
    }
  }

  // $results['post'] = array_values(array_unique($results['post'], SORT_REGULAR));
  return $results;
} 