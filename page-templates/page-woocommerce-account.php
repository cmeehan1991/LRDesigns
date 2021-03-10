<?php 
/**
* Template name: Woocommerce Account Template
*/	
get_header(); 
?>

<div class="container-fluid">

	<div class="row">

		<div class="col-md-12 d-flex justify-content-center">
			
			<?php 
			if(have_posts()){
				while(have_posts()){
					the_post();
					
					the_content(); 
				} // end while
			}else{
				echo "No content";
			}// Endif
			?>
		</div>
		
	</div>

</div>


<?php get_footer(); 