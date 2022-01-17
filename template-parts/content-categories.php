<!-- Heading -->
<div class="content-heading">
  <h2>
    <?php
      if ( is_archive() ) {
        echo get_the_archive_title();
      } else if ( is_search() ) { 
        echo 'نتایج یافت شده';
      } else if ( get_option( 'zhobin_content_heading' ) ) {
        echo __( get_option( 'zhobin_content_heading' ) );
      }
    ?>
  </h2>
  <p>
    <?php
      if ( is_archive() ) {
        echo get_the_archive_description();
      } else if ( is_search() ) { 
        echo 'کلمه جستجو شده :‌ ' . esc_html( get_search_query(false) ) . '&rdquo;';
      } else if ( get_option('zhobin_content_description') ) {
        echo __( get_option('zhobin_content_description') );
      }
    ?>
  </p>
</div>

<?php
$categories = get_categories( array( 'parent' => 0, 'hide_empty' => 0 ) );
if ( count($categories) ) : ?>
<!-- Category -->
<div class="content-category">
  <ul>
    <li>
      <a id="all-categories" class="active">همه</a>
    </li>
    <?php
    $categories = get_categories( array( 
      'orderby' => 'name',
      'parent' => 0
    ) );
    foreach ( $categories as $category ) {
      echo '<li><a data-cate="' . esc_attr( $category->term_id ) . '">' . __( $category->name ) . '</a></li>';
    }
    ?>
  </ul>
</div>
<?php endif; ?>