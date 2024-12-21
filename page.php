<?php

get_header();

if (is_plugin_active('woocommerce/woocommerce.php') && is_cart()):

  if (have_posts()):
    while (have_posts()) : the_post();
      the_content();
    endwhile;
  endif;

else:

  if ( have_rows('content') ):
    while ( have_rows('content') ) : the_row();
      get_template_part( 'partials/flexible-sections/' . get_row_layout() );
    endwhile;
  endif;

endif;

get_footer();