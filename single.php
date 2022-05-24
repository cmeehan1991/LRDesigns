<?php get_header(); ?>

<div class="container-fluid">
	<div class="row">
		<?php if(have_posts()){
			while(have_posts()){
				the_post();
				?>
				
				<div class="col-md-10 mx-auto">
					<?php the_content(); ?>
				</div>
			<?php	
			}
		} ?>
	</div>
</div>