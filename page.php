<?php get_header(); ?>

<?php
	if ( have_rows('content') ):
		while ( have_rows('content') ) : the_row();
			get_template_part( 'partials/flexible-sections/' . get_row_layout() );
		endwhile;
	endif;
?>

<?php get_footer(); ?>