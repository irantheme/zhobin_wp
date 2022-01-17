  <?php get_header(); ?>

  <?php while ( have_posts() ) : the_post(); ?>

  <!-- Content #####################3 -->
  <section id="content">
    <!-- Single ############################### -->
    <main id="single">
      <div class="container">
        <!-- Single post -->
        <article class="single-post p-4">
          <div class="row">
            <div class="col-lg-12">
              <!-- Single gallery -->
              <div class="single-gallery">
                <?php if ( has_post_thumbnail() ) : ?>
                <!-- Single gallery main img -->
                <div class="single-gallery-img">
                  <img src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="Image gallery">
                </div>
                <?php endif; ?>
              </div>
              <!-- Single content -->
              <div class="single-content">
                <!-- Single heading -->
                <div class="single-heading">
                  <h1><?php the_title(); ?></h1>
                </div>
                <!-- Single text -->
                <div class="single-text"><?php the_content(); ?></div>
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