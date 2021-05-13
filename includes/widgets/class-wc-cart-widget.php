<?php 

class LR_WC_Cart_Widget extends WP_Widget{
	function __construct(){
		parent::__construct('lr_wc_cart_widget','Cart Widget');}
	
	/*
	* Create widget front-end
	*/
	public function widget($args, $instance){
		
		global $woocommerce;
		
		$widget_id = 'widget_' . $args['widget_id'];
		
		$items = $woocommerce->cart->get_cart();
				
		$accounts_permalink = get_permalink(get_option('woocommerce_myaccount_page_id'));
		?>
		<ul class="navbar-nav">
			<li class="nav-item dropdown cart-widget">
				<a class="nav-link cart-widget-link" href="<?php echo wc_get_cart_url(); ?>" id="cartWidgetDropdownMenuLink"aria-expanded="false">
					<i class="fas fa-shopping-bag"></i>
				</a>
				
				<ul class="dropdown-menu" aria-labelledby="cartWidgetDropdownMenuLink">
					<li><h2 class="cart-widget--title">Cart Summary</h2></li>
					<ul class="cart-list--list">
						<?php 
							
						if(!is_user_logged_in()){
							?>
							<li class="cart-list--item__message">Please <a href="https://www.google.com">sign in</a> to add to view your cart.</li>
							<?php
						}else if(is_user_logged_in() && $items){
							
							$subtotal = 0;
							$quantity = 0;
							
							foreach($items as $key => $item){							
								$product_id = $item['product_id'];
								$product = wc_get_product($item['product_id']);
								?>
								
								<li class="cart-list--item">
									<div>
										<a href="<?php echo wc_get_cart_remove_url($key); ?>"><i class="fas fa-times-circle"></i></a>
										<a href="<?php echo get_the_permalink($product_id); ?>">
											<?php echo get_the_post_thumbnail($product_id, 'thumbnail', array()); ?>
											<h3><?php echo get_the_title($product_id); ?></h3>
										</a>
									</div>
									<p class='item-price-quantity'>
										<span class="item-price"> $<?php echo $product->get_price(); ?> </span>
										<span class="item-quantity">Qty: <?php echo $item['quantity']; ?></span>
									</p>
								</li>
								
								<?php 
	
								$subtotal = $subtotal + ($product->get_price() * $item['quantity']);
								$quantity = $quantity + $item['quantity'];
							}
							?>
							
							<?php 
							setlocale(LC_MONETARY, 'en_US.UTF-8');	
							
							?>
							<h4 class="cart-list--subtotal-quantity">
								<span class="subtotal">
									<strong>Subtotal: </strong>
									<?php echo money_format('%.2n', $subtotal);?>
								</span>
								<span class="quantity">
									<strong>Quantity: </strong>
									<?php echo $quantity; ?>
								</span>
							</h4>
							<a class="button" href="<?php echo wc_get_cart_url(); ?>">View Cart</a>

							<?php
							
						}else{
							?>
							<li class="cart-list--item__message">There are no items in your cart.</li>
							<?php
						}
						?>
						
					</ul>
					
				</ul>
			</li>
		</ul>
		<?php 
	}
	
	/*
	* Creating widget backend
	*/
	public function form($instance){
		
	}
	
	/*
	* Updating widget replacing old instances with new
	*/
	public function update($new_instance, $old_instance){
		return $instance;
	}
	
	
}

add_action('widgets_init', 'lr_load_wc_cart_widget');
function lr_load_wc_cart_widget(){
	register_widget('LR_WC_Cart_Widget');
}