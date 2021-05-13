<?php

get_header();
?>
<div class="container-fluid">

	<div class="row">
		<div class="col-ld-12">
			<?php 
			if(is_product_category()){
			global $wp_query;
			
			$cat = $wp_query->get_queried_object();
			
			$thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
			
			$image = wp_get_attachment_url($thumbnail_id);
			
			?>
			
			<div class="category-hero d-flex flex-column">
			<?php 
					$breadcrumb_args = array(
						'delimiter' => ' / '
					);
					woocommerce_breadcrumb($breadcrumb_args);
			?>
				<div class="d-flex flex-row">
					<h1 class="category-hero--title align-self-center"><?php echo $cat->name; ?></h1>
					
					<?php if($image){ ?>
					<div class="category-hero--image d-flex flex-row justify-content-center">
						<img src="<?php echo $image; ?>" alt=" <?php echo $cat->name; ?>"/>
					</div>
					<?php } ?>
				</div>
			</div>
		<?php }?>
			
		</div>
	</div>
	
	<div class="row">		

		<div class="col-lg-6 order-lg-2 order-xl-2">

			<div class="row woocommerce ">

				
				
				<?php woocommerce_content(); ?>
			</div>
		</div>
		<div class="col-sm-12 col-lg-3 order-md-1 order-lg-1 d-flex justify-content-center">
			<?php dynamic_sidebar('shop-sidebar-left'); ?>
		</div>
		<div class="col-sm-12 col-lg-3 order-md-3">
			<?php dynamic_sidebar('shop-sidebar-right'); ?>
		</div>
	</div>
</div>


</div>

<?php 

get_footer();
