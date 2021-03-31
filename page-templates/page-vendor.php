<?php 
/*Template Name: Vendor Page */	

get_header();

?>

<div class="container-fluid">
	
	<?php 
	if(have_posts()){
		while(have_posts()){
			the_post();
			?>
	
			<div class="row">
				<div class="col-md-12 d-flex justify-content-center">
					<?php		
					// Display any page content first. 
					the_content();
					?>
				</div>
			</div>
			<div class="row vendors-section">
				<div class="loading-section">				
				<i class="fas fa-spinner fa-pulse vendors-loading"></i>
				</div>
				<div class="col-md-6 mx-auto d-flex justify-content-center">
					<?php get_template_part('template-parts/page', 'vendor-list'); ?>
				</div>
				<!--<div class="col-md-6 d-flex justify-content-center">
					<?php get_template_part('template-parts/page', 'vendor-map'); ?>
				</div>-->
			</div>
			<?php
		} // endwhile
	} // endif	
	?>
</div>

<?php get_footer(); 
	
