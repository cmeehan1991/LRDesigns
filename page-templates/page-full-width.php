<?php /*Template Name: Full Width Container */
get_header(); ?>
<div class="row g-0 d-flex justify-content-center">
	<?php 
	if(have_posts()){
		while(have_posts()){
			the_post();
			
			the_content();
				
		} // endwhile
	} // endif
	?>

<?php get_footer();