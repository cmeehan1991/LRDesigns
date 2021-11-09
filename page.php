<?php 

	
get_header(); ?>

<div class="container-fluid g-0">
	<div class="row page-title-row">
		<div class="col-lg-10 col-md-12 mx-auto">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-10 col-md-12 mx-auto">
			<?php 
			$breadcrumb_args = array(
				'delimiter' => ' / '
			);
			woocommerce_breadcrumb($breadcrumb_args);
			?>
		</div>
	</div>
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