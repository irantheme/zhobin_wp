<?php get_header(); ?>

<!-- Content ###################### -->
<section id="content">
  <div class="container">

    <?php get_template_part('template-parts/content', 'categories'); ?>

  </div>

  <!-- Posts ############################### -->
  <main id="posts">
    <div class="container">
      <!-- Masonry style post -->
      <div class="grid-masonry">
        <div class="grid-sizer"></div>
        <?php while ( have_posts()) : the_post(); ?>
        
        <?php get_template_part('template-parts/content', 'post'); ?>

        <?php endwhile; ?>
      </div>
    </div>
  </main>
  
  <?php if ( paginate_links() ) : ?>
  <!-- Pagination -->
  <div class="pagination">
    <div class="container">
      <?php echo paginate_links(); ?>
    </div>
  </div>
  <?php endif; ?>

</section>

<?php get_footer(); ?>