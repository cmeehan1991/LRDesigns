<?php

get_header();
?>

<div class="container-fluid">
	<div class="row">		

		<div class="col-lg-6 order-lg-2 order-xl-2">
			<div class="row woocommerce ">
				<?php 
					$breadcrumb_args = array(
						'delimiter' => '<i class="fas fa-chevron-right"></i>'
					);
					woocommerce_breadcrumb($breadcrumb_args);
				?>
				<?php woocommerce_content(); ?>
			</div>
		</div>
		<div class="col-sm-12 col-lg-3 order-md-1 order-lg-1">
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
