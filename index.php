<?php get_header(); ?>

<?php
	if ( have_rows('content', get_queried_object_id()) ):
		while ( have_rows('content', get_queried_object_id()) ) : the_row();
			get_template_part( 'partials/flexible-sections/' . get_row_layout() );
		endwhile;
	endif;
?>

<?php get_footer(); ?>