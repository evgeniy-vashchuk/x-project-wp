<?php
  $hide_section = get_sub_field("hide_section");
  $text = get_sub_field("text");
?>

<?php if (!$hide_section && $text) : ?>
<!-- SECTION -->
<section class="section">
  <div class="container">
    <?php echo $text; ?>
  </div>
</section>
<!-- SECTION END -->
<?php endif; ?>