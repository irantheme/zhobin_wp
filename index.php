  <?php get_header(); ?>

  <!-- Content ###################### -->
  <section id="content">
    <div class="container">

      <?php get_template_part( 'template-parts/content', 'categories' ); ?>

    </div>

    <?php
    // Create new query with all post type for display posts
    $args = array(
        'post_type' => array( 'post' )
    );
    $post_custom_types = new WP_Query( $args );
    // Checking have post or no
    if ( $post_custom_types->have_posts() ) : ?>

    <!-- Posts ############################### -->
    <main id="posts">
      <div class="container">
        <!-- Masonry style post -->
        <div class="grid-masonry">
          <div class="grid-sizer"></div>
          <?php while ( $post_custom_types->have_posts() ) : $post_custom_types->the_post(); ?>
          
          <?php get_template_part( 'template-parts/content', 'post' ); ?>

          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
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
