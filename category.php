<?php get_header(); ?>

  <!-- SECTION -->
  <section>
    <div class="container">
      <h1><?php 'Categories for ' . single_cat_title(); ?></h1>

      <?php get_template_part('loop'); ?>
      <?php get_template_part('pagination'); ?>
    </div>
  </section>
  <!-- SECTION END -->

<?php get_footer(); ?>