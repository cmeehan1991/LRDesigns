<?php
class LR_Woocommerce{
	function __construct(){
		add_action('after_theme_setup', array($this, 'woocommerce'));
		add_filter('get_product_search_form' , array($this, 'woo_custom_product_searchform')); // Product search form
		add_filter('woocommerce_get_price_html', array($this, 'lr_change_product_price_display'), 10, 2);
		add_filter('woocommerce_is_purchasable', array($this, 'lr_add_to_cart_button'));
		add_filter('woocommerce_get_catalog_ordering_args', array($this, 'sv_add_sku_sorting' ));
		add_filter('woocommerce_catalog_orderby', array($this, 'sv_sku_sorting_orderby' ));
		add_filter('woocommerce_default_catalog_orderby_options', array($this, 'sv_sku_sorting_orderby' ));
		add_action('user_register', array($this, 'set_new_user_status'));
		add_filter('manage_users_custom_column', array($this, 'user_status_column'), 10, 3);
		add_filter('manage_users_columns', array($this, 'modify_user_table'));
		add_action('edit_user_profile', array($this, 'user_profile_form'));
		add_action('edit_user_profile_update', array($this, 'save_user_profile_fields'));
		add_filter('authenticate', array($this, 'check_user_status'), 100, 3);
		add_filter('woocommerce_registration_auth_new_customer', array($this, 'authenticate_new_customer'), 10, 2);
	}
	
	public function authenticate_new_customer($auth, $new_customer){
		return false;
	}
	
	public function check_user_status($user, $username, $password){
		$user_status = get_user_meta($user->ID, 'status', true);
		
		if($user_status){
		
			if(user_can($user, 'edit_posts')){
				$user = $user;
			}else{
				if($user_status != 'Approved'){
					$user = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Your account has not been approved yet.'));
				}
			}
		}
		
		return $user;
	}

	
	public function user_profile_form($user){
		
		$status = get_user_meta($user->ID, 'status', true);
		?>
		<h2>Status</h2>
		<table class="form-table">
			<tr>
				<th><label for="user_status">Status</label></th>
				<td>
					<select name="user_status" id="user_status" value="<?php echo $status; ?>">
						<option value="Pending"<?php echo $status == "Pending" ? 'selected' : '';?>>Pending</option>
						<option value="Approved"<?php echo $status == "Approved" ? 'selected' : '';?>>Approved</option>
						<option value="Denied"<?php echo $status == "Denied" ? 'selected' : '';?>>Denied</option>
					</select>
				</td>
			</tr>
		</table>
		<?php
	}
	
	public function save_user_profile_fields($user_id){
		
		$old_status = get_user_meta($user_id, 'status', true);
		
		$new_status = $_POST['user_status'];
		
		if($old_status != $new_status){
			update_user_meta($user_id, 'status', $new_status);
			
			$this->notify_user($user_id);
		}
	}
	
	public function notify_user($user_id){
		
		$user_data = get_user_by('id', $user_id);
		
		$email = $user_data->user_email;
		
		$to = $email;
		$subject = 'Lucas Robert Designs Account Status Change';
		$message = 'Your account status has been updated.';
		$headers = array('Content-Type: text/html; charset=UTF-8', 'From: Lucas Robert Designs <lucasrober2004@aol.com>');
		
		wp_mail($to, $subject, $message, $headers);
	}
	
	public function modify_user_table($column){
		$column['status'] = 'Status';
		
		return $column;
	}
	
	public function user_status_column($value, $column_name, $user_id){
	
		if($column_name == 'status'){
			$value = get_user_meta($user_id, 'status', true);
		}
		
		return $value;
	}
	
	public function set_new_user_status($user_id){
		update_user_meta($user_id, 'status', 'Pending');
	} 
	
	/**
	* Adds theme support for woocommerce
	* 
	* Required by Woocommerce
	*/
	public function woocommerce_support(){
		add_theme_support('woocommerce');
	}
	
	/**
	* Edit the product search form
	*/
	public function woo_custom_product_searchform( $form ) {
		
		$form = 
		'<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
			<div>
				<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search for items...', 'woocommerce' ) . '" class="product-search-form"/>
				<button type="submit" id="searchsubmit" value="'. esc_attr__('Search', 'woocommerce') . '" class="search-button glyphicon glyphicon-search"></button>
				<input type="hidden" name="post_type" value="product" />
			</div>
		</form>'; 
		
		return $form;
		
	}
	
	/**
	* Change the price based on if the user is signed in
	* Retailers should see the wholesale price
	* Non-retailers should see the MSRP = wholesale * 3
	*/
	public function lr_change_product_price_display($price, $product){
		
		if(is_user_logged_in()){
			$price = "Wholesale: " . $price;
		}else{
			$price = doubleval($product->get_price());
			setlocale(LC_MONETARY, 'en_US');
			$price = "MSRP: " . money_format("%n", $price * 3);
		}
		
		
		return $price;
	}


	/**
	* 
	*/
	public function lr_add_to_cart_button(){
		if(is_user_logged_in()){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Adds the ability to sort products in the shop based on the SKU
	 * Can be combined with tips here to display the SKU on the shop page: https://www.skyverge.com/blog/add-information-to-woocommerce-shop-page/
	 *
	 * @param array $args the sorting args
	 * @return array updated args
	 */
	public function sv_add_sku_sorting( $args ) {
	
		$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	
		if ( 'sku' == $orderby_value ) {
			$args['orderby'] = 'meta_value';
			$args['order'] = 'asc'; // lists SKUs alphabetically 0-9, a-z; change to desc for reverse alphabetical
			$args['meta_key'] = '_sku';
		}
	
		return $args;
	}

	/**
	 * Add the option to the orderby dropdown.
	 *
	 * @param array $sortby the sortby options
	 * @return array updated sortby
	 */
	public function sv_sku_sorting_orderby( $sortby ) {
	
		// Change text above as desired; this shows in the sorting dropdown
		$sortby['sku'] = __( 'Sort by SKU', LR_TEXTDOMAIN );
	
		return $sortby;
	}
	
	
}	

new LR_Woocommerce();	