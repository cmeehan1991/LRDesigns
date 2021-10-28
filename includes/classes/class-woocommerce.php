<?php
class LR_Woocommerce{
	function __construct(){
		
		/**
		 * Actions
		 */
		add_action('after_setup_theme', array($this, 'woocommerce_support'));
		add_action('user_register', array($this, 'set_new_user_status'));
		add_action('edit_user_profile', array($this, 'user_profile_form'));
		add_action('edit_user_profile_update', array($this, 'save_user_profile_fields'));
		add_action('init', array($this, 'register_custom_shop_collections_taxonomies'));
		add_action('woocommerce_single_product_summary', array($this, 'replace_single_add_to_cart_button'));
		add_action('init', array($this, 'wc_custom_account_endpoints'));
		
		/**
		 * Filters
		 */
		add_filter('get_product_search_form' , array($this, 'woo_custom_product_searchform')); // Product search form
		add_filter('woocommerce_get_price_html', array($this, 'lr_change_product_price_display'), 10, 2);
		add_filter('woocommerce_is_purchasable', array($this, 'lr_add_to_cart_button'));
		add_filter('woocommerce_get_catalog_ordering_args', array($this, 'sv_add_sku_sorting' ));
		add_filter('woocommerce_catalog_orderby', array($this, 'sv_sku_sorting_orderby' ));
		add_filter('woocommerce_default_catalog_orderby_options', array($this, 'sv_sku_sorting_orderby' ));
		add_filter('manage_users_custom_column', array($this, 'user_status_column'), 10, 3);
		add_filter('manage_users_columns', array($this, 'modify_user_table'));
		add_filter('authenticate', array($this, 'check_user_status'), 100, 3);
		add_filter('woocommerce_registration_auth_new_customer', array($this, 'authenticate_new_customer'), 10, 2);
		add_filter('woocommerce_page_title', array($this, 'woocommerce_page_title'));		
		add_filter('woocommerce_loop_add_to_cart_link', array($this, 'replace_loop_add_to_cart_button'), 10, 3);
		add_filter('woocommerce_checkout_fields', array($this, 'add_bootstrap_to_checkout_fields'));
		add_filter('woocommerce_account_menu_items', array($this, 'manage_my_account_links'));
		add_filter('woocommerce_form_field_args', array($this, 'add_bootstrap_form_field_classes'), 10, 3);
		add_filter('woocommerce_account_menu_item_classes', array($this, 'add_bootstrap_classes_menu_items'), 10,2);
		
	}
	
	public function add_bootstrap_classes_menu_items($classes, $endpoint){

		$classes[] = 'nav-item';
		
		//var_dump($classes);
		return $classes;
	}
	
		
	public function add_bootstrap_form_field_classes($args, $key, $value){		
		$args['class'][] = 'form-group';
		
		$args['input_class'][] = 'form-control';
		
		return $args;
	}
		
	public function wc_custom_account_endpoints(){
		add_rewrite_endpoint('documents', EP_ROOT | EP_PAGES);
	}
	
	
	public function manage_my_account_links($menu_links){

		
		unset($menu_links['downloads']);
		
		
		$menu_links['dashboard'] = 'My Account';
		$menu_links['edit-account'] = 'Account Details';
		
		
		return $menu_links;
	}
	
	/**
	 * Add bootstrap to the checkout fields
	 */
	public function add_bootstrap_to_checkout_fields($fields){
		if($fields){
			foreach($fields as &$fieldset){
				foreach($fieldset as &$field){
					// add form-group class around the label and input
					$field['class'][] = 'form-group';
					
					// add form-control to the input
					$field['input_class'][] = 'form-control';
				}
			}
		}
		
		return $fields;
	}

	/**
	 * Replace the add to cart button on the variable product page for users that are not logged in.
	 */
	public function replace_loop_add_to_cart_button($button, $product, $args){
				
		// Check if the user is logged in
		if(!is_user_logged_in()){
			$button_text = __("Locate a Retailer", TEXTDOMAIN);
			
			$button_link = get_field('locate_a_retailer_page', 'option');
			
			$button = '<a class="button" href="' . $button_link . '">' . $button_text . '</a>';
		}
		
		return $button;
	}
	
	/**
	 * Replace the add to cart button on the single product page for users that are not logged in. 
	 */
	public function replace_single_add_to_cart_button(){
		global $product;
		
		if(!is_user_logged_in()){
			if($product->is_type('variable')){
	            remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );			
				add_action('woocommerce_single_variation', array($this, 'custom_product_button'), 20);

			}else{            
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				add_action('woocommerce_single_product_summary', array($this, 'custom_product_button'), 30);
			}
		}
		
	}
	
	
	public function custom_product_button(){
		$button_link = get_field('locate_a_retailer_page', 'option');
		$button_text = __('Locate a Retailer', TEXTDOMAIN);

		echo '<a class="button" href="'.$button_link.'">' . $button_text . '</a>';
	}

	public function woocommerce_page_title($echo = true){
		
		if(is_product_category()){
			$page_title = '';	
		}
		
		return $page_title;
		
	}

	public function register_custom_shop_collections_taxonomies(){
		$labels = array(
			'name'                       => _x( 'Collections', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Collection', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Collections', 'text_domain' ),
			'all_items'                  => __( 'All Collections', 'text_domain' ),
			'parent_item'                => __( 'Parent Collection', 'text_domain' ),
			'parent_item_colon'          => __( 'Parent Collection:', 'text_domain' ),
			'new_item_name'              => __( 'New Collection Name', 'text_domain' ),
			'add_new_item'               => __( 'Add New Collection', 'text_domain' ),
			'edit_item'                  => __( 'Edit Collection', 'text_domain' ),
			'update_item'                => __( 'Update Collection', 'text_domain' ),
			'view_item'                  => __( 'View Collection', 'text_domain' ),
			'separate_items_with_commas' => __( 'Separate collections with commas', 'text_domain' ),
			'add_or_remove_items'        => __( 'Add or remove collections', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
			'popular_items'              => __( 'Popular Collections', 'text_domain' ),
			'search_items'               => __( 'Search Collections', 'text_domain' ),
			'not_found'                  => __( 'Not Found', 'text_domain' ),
			'no_terms'                   => __( 'No collections', 'text_domain' ),
			'items_list'                 => __( 'Collections list', 'text_domain' ),
			'items_list_navigation'      => __( 'Collections list navigation', 'text_domain' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'					 => array('slug' => 'collections')
		);
		register_taxonomy( 'lr_product_collection', array( 'product' ), $args );
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
//		add_theme_support( 'wc-product-gallery-zoom' );
	    add_theme_support( 'wc-product-gallery-lightbox' );
	    add_theme_support( 'wc-product-gallery-slider' );

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