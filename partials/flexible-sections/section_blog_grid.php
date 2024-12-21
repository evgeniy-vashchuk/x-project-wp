<?php
  $hide_section = get_sub_field("hide_section");
?>

<?php if (!$hide_section) : ?>
  <!-- SECTION -->
  <section>
    <div class="container">
      <?php get_template_part('loop'); ?>

      <?php get_template_part('pagination'); ?>
    </div>
  </section>
  <!-- SECTION END -->
<?php endif; ?>