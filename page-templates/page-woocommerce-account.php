<?php 
/**
* Template name: Woocommerce Account Template
*/	
get_header(); 

?>

<div class="container-fluid">

			
	<?php 
	if(have_posts()){
		while(have_posts()){
			the_post();
			?>
			<div class="row">
				<div class="col-8 mx-auto">
					<h2><?php the_title(); ?></h2>
				</div>
			</div>
			<div class="row">
		
				<div class="col-md-12 d-flex justify-content-center">
					<?php 
					the_content(); 
					?>
			
				</div>
				
			</div>
			<?php 
			
		} // end while
	}else{
		?>	
		<div class="row">
			<div class="col-md-12 d-flex justify-content-center">
				No content
			</div>
		</div>
	<?php }// Endif ?>

</div>


<?php get_footer(); 