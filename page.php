<?php 

	
get_header(); ?>

<div class="container-fluid">

	<div class="row">

		<div class="col-sm-12 col-md-10 col-lg-8 mx-auto d-flex flex-column justify-items-center">
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