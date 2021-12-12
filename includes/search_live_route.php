<?php


/**
 * Register custom json search url
 * @return void
 */
function registerSearch() {
  register_rest_route( 'json/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'resultsSearch',
    'permission_callback' => '__return_true'
  ) );
}
// Run above
add_action( 'rest_api_init', 'registerSearch' );


/**
 * Pin results to custom search
 * @return array
 * @param array data
 */
function resultsSearch( $data ) {

  // Getting new query for post and page type
  $mainQuery = new WP_Query( array(
    'post_type' => array( 'post', 'page' ),
    's' => sanitize_text_field( $data['term'] ) // Sanitize is more security for wordpress functions
  ) );

  // Create results for maintenance created json data
  $results = array(
    'generalInfo' => array()
  );

  // Check of of them posts
  while ( $mainQuery->have_posts() ) {
    $mainQuery->the_post();
    // Appending data to results array
    if ( get_post_type() == 'post' || get_post_type() == 'page' ) {
      array_push( $results['generalInfo'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'content' => get_the_excerpt(),
        'imageSrc' => get_the_post_thumbnail_url( get_the_ID(), 'large' )
      ) );
    }
  }

  return $results;
} 