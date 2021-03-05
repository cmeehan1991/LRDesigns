<?php 
// Add theme support for woocommerce
add_action('after_setup_theme','woocommerce_support');
function woocommerce_support(){
add_theme_support('woocommerce');
}
	
/**
	Woocommerce customization
*/

// Edit the product search form
add_filter( 'get_product_search_form' , 'woo_custom_product_searchform' );
function woo_custom_product_searchform( $form ) {
	
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

// Change the price based on if the user is signed in
// Retailers should see the wholesale price
// Non-retailers should see the MSRP = wholesale * 2.5
add_filter('woocommerce_get_price_html', 'lr_change_product_price_display', 10, 2);
function lr_change_product_price_display($price, $product){
	
	if(is_user_logged_in()){
		$price = "Wholesale: " . $price;
	}else{
		$price = doubleval($product->get_price());
		setlocale(LC_MONETARY, 'en_US');
		$price = "MSRP: " . money_format("%n", $price * 2.5);
	}
	
	
	return $price;
}

// Hide add to cart button if user is not logged in
add_filter('woocommerce_is_purchasable', 'lr_add_to_cart_button');
function lr_add_to_cart_button(){
	if(is_user_logged_in()){
		return true;
	}else{
		return false;
	}
}

// Function to check starting char of a string
function startsWith($haystack, $needle){
return $needle === '' || strpos($haystack, $needle) === 0;
}

// Customize the account registration form
add_action( 'woocommerce_register_form_start', 'lr_extra_register_fields' );
function lr_extra_register_fields(){ ?>
       	
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="billing_company"><?php _e( 'Company Name', LR_TEXTDOMAIN ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_company" id="billing_company" value="<?php if(! empty($_POST['billing_company'])) $_POST['billing_company']; ?>"/>
   	</p>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="billing_address_1"><?php _e( 'Address Line 1', LR_TEXTDOMAIN ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_address_1" id="billing_address_1" value="<?php if(! empty($_POST['billing_address_1'])) esc_attr_e($_POST['billing_address_1']); ?>"/>
   	</p>
   	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="billing_address_2"><?php _e( 'Address Line 2', LR_TEXTDOMAIN ); ?></label>
		<input type="text" class="input-text" name="billing_address_2" id="billing_address_2" value="<?php if(!empty($_POST['billing_address_2'])) esc_attr_e($_POST['billing_address_2']); ?>" />
   	</p>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="billing_city"><?php _e( 'City', LR_TEXTDOMAIN ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_city" id="billing_city" value="<?php if(! empty($_POST['billing_city'])) esc_attr_e($_POST['billing_city']); ?>"/>
   	</p>
   	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="billing_postcode"><?php _e( 'Postcode/Zip', LR_TEXTDOMAIN ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_postcode" id="billing_postcode" value="<?php if(!empty($_POST['billing_postcode'])) esc_attr_e($_POST['billing_postcode']); ?>" />
   	</p>
   	<p>
       	<label for="billing_country"><?php _e( 'Country', LR_TEXTDOMAIN ); ?><span class="required">*</span></label>
       	<script>
	       	$(document).ready(function(){
		       	$('select').select2();
		       	$('.country-dropdown').on('change', function(){
			       	var country = $("#billing_country").val();
			       	if(country !== "US"){
				       	$("#billing_state").attr('disabled', 'disabled');
			       	}else{
				       	$("#billing_state").enabled(true);
			       	}
			       	console.log($("#billing_country").val());	
		       	});
	       	});
       	</script>
       	<?php 
		global $woocommerce;
	    $countries_obj   = new WC_Countries();
	    $countries   = $countries_obj->__get('countries');
	
	    woocommerce_form_field('billing_country', array(
	    'type'       => 'select',
	    'class'      => array( 'country-dropdown' ),
	    'placeholder'    => __('Enter Somthing'),
	    'options'    => $countries,
	    'default' => __('US')
	    )
	    );
    	?>
   	</p>
   	
   	<p>
       	<label for="billing_state"><?php _e( 'State', LR_TEXTDOMAIN ); ?><span class="required">*</span></label>
       	<?php
       	global $woocommerce;
	    $countries_obj   = new WC_Countries();
	    $countries   = $countries_obj->__get('countries');
	    $default_country = $countries_obj->get_base_country();
	    $default_country_states = $countries_obj->get_states( $default_country );
	
	    woocommerce_form_field('billing_state', array(
	    'type'       => 'select',
	    'class'      => array( 'state-dropdown' ),
	    'placeholder'    => __('Billing State'),
	    'options'    => $default_country_states
	    )
	    );
	    ?>
   	</p>
   	
   	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="billing_phone"><?php _e( 'Phone', LR_TEXTDOMAIN ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_phone" id="billing_phone" value="<?php if(!empty($_POST['billing_phone'])) esc_attr_e($_POST['billing_address_2']); ?>" />
   	</p>
   	<?php 
}
	
// Validate the extra fields
add_action('woocommerce_register_post', 'lr_validate_extra_fields', 10, 3);
function lr_validate_extra_fields($username, $email, $errors ){		
		
	if(empty($_POST['billing_company'])){
		$errors->add( 'billing_company_error', __( 'Company Name is required!', LR_TEXTDOMAIN ) );
	}
		if(empty($_POST['billing_address_1'])){
		$errors->add( 'billing_address_1_error', __( 'Address is required!', LR_TEXTDOMAIN ) );
	}
	
	if(empty($_POST['billing_city'])){
		$errors->add( 'billing_city_error', __( 'City is required!', LR_TEXTDOMAIN ) );
	}
	
	if(empty($_POST['billing_postcode'])){
		$errors->add( 'billing_postcode_error', __( 'Postcode/Zip is required!', LR_TEXTDOMAIN ) );
	}
	
	if(empty($_POST['billing_country'])){
		$errors->add( 'billing_country_error', __( 'Country is required!', LR_TEXTDOMAIN ) );
	}
	
	if(empty($_POST['billing_state'])){
		$errors->add( 'billing_state_error', __( 'State is required!', LR_TEXTDOMAIN ) );
	}
	
	if(empty($_POST['billing_phone'])){
		$errors->add( 'billing_phone_error', __( 'Phone number is required!', LR_TEXTDOMAIN ) );
	}
	return $errors;
}

// Save the extra data
add_action('woocommerce_created_customer', 'lr_save_extra_fields');
function lr_save_extra_fields($customer_id){
	
	/*global $woocommerce;
	$address = $_POST; 
	foreach($address as $key => $field){
		if(startsWith($key, 'billing_')){
			// Condition to add firstname and last name to user meta table
            if($key == 'billing_first_name' || $key == 'billing_last_name'){
                $new_key = explode('billing_',$key);
                update_user_meta( $user_id, $new_key[1], $_POST[$key] );
            }
        update_user_meta( $user_id, $key, $_POST[$key] );
		}
	} */
	
	if(isset($_POST['billing_company'])){
		update_user_meta($customer_id, 'billing_company', sanitize_text_field($_POST['billing_company']));
	}
	if(isset($_POST['billing_address_1'])){
		update_user_meta($customer_id, 'billing_address_1', $_POST['billing_address_1']);
	}
	
	if(isset($_POST['billing_address_2'])){
		update_user_meta($customer_id, 'billing_address_2', $_POST['billing_address_2']);
	}
	
	if(isset($_POST['billing_city'])){
		update_user_meta($customer_id, 'billing_city', $_POST['billing_city']);
	}
	
	if(isset($_POST['billing_postcode'])){
		update_user_meta($customer_id, 'billing_postcode', $_POST['billing_postcode']);
	}
	
	if(isset($_POST['billing_country'])){
		update_user_meta($customer_id, 'billing_country', $_POST['billing_country']);
	}
	
	if(isset($_POST['billing_state'])){
		update_user_meta($customer_id, 'billing_state', $_POST['billing_state']);
	}
	
	if(isset($_POST['billing_phone'])){
		update_user_meta($customer_id, 'billing_phone', $_POST['billing_phone']);
	}

}

add_action('woocommerce_edit_account_form', 'lr_edit_account_form', 10, 0);
function lr_edit_account_form(){ ?>
<fieldset> 
	<legend>Company Information</legend>
   	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-last">
		<label for="company_name"><?php _e( 'Company Name', LR_TEXTDOMAIN ); ?></label>
		<input type="text" class="input-text" name="company_name" id="company_name" value="<?php echo get_user_meta(wp_get_current_user()->ID, 'company_name', true);?>"  />
   	</p>
</fieldset>

   	<?php
}

add_action('woocommerce_save_account_details', 'lr_save_additional_account_details');
function lr_save_additional_account_details($user_ID){
	
	if(isset($_POST['company_name'])){
		update_user_meta($user_ID, 'billing_company', $_POST['company_name']);
	}
	
	
	if(isset($_POST['billing_address_1'])){
		update_user_meta($user_ID, 'billing_address_1', $_POST['billing_address_1']);
	}
	
	if(isset($_POST['billing_address_2'])){
		update_user_meta($user_ID, 'billing_address_2', $_POST['billing_address_2']);
	}
	
	if(isset($_POST['billing_city'])){
		update_user_meta($user_ID, 'billing_city', $_POST['billing_city']);
	}
	
	if(isset($_POST['billing_postcode'])){
		update_user_meta($user_ID, 'billing_postcode', $_POST['billing_postcode']);
	}
	
	if(isset($_POST['billing_country'])){
		update_user_meta($user_ID, 'billing_country', $_POST['billing_country']);
	}
	
	if(isset($_POST['billing_state'])){
		update_user_meta($user_ID, 'billing_state', $_POST['billing_state']);
	}
	
	if(isset($_POST['billing_phone'])){
		update_user_meta($user_ID, 'billing_phone', $_POST['billing_phone']);
	}
	
}

// Adjust the password meter strength requirement
add_filter( 'woocommerce_min_password_strength', 'lr_min_password_strength', 10, 1); 
function lr_min_password_strength($int){
	$int = 0;
	return $int;	
}

/** Adjust the account pages to be more responsive */
//add_action('woocommerce_account_content', 'lr_before_edit_account_form');
//add_action('woocommerce_before_edit_account_form', 'lr_before_edit_account_form');
//add_action('woocommerce_before_edit_account_address_form', 'lr_before_edit_account_form');
function lr_before_edit_account_form($args = null){
	echo "<div class='col-md-10'>";
}

//add_action('woocommerce_after_edit_account_form', 'lr_after_edit_account_form');
//add_action('woocommerce_after_edit_account_address_form', 'lr_before_edit_account_form');
//add_action('woocommerce_after_account_orders', 'lr_after_edit_account_form');
function lr_after_edit_account_form(){
	echo "</div>";
}

//add_action('woocommerce_before_account_navigation', 'lr_before_before_navigation');
function lr_before_before_navigation(){
	echo "<div class='col-md-2'>";
	
}

//add_action('woocommerce_after_account_navigation', 'lr_after_account_navigation');
function lr_after_account_navigation(){
	echo "</div>";
}


// Add tax id column and company name column to users page in admin
function new_modify_user_table( $column ) {
    $column['company_name'] = 'Company Name';
    return $column;
}
add_filter('manage_users_columns', 'new_modify_user_table');

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'company_name' :
            return get_the_author_meta( 'billing_company', $user_id );
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );

add_filter('loop_shop_per_page', 'lr_loop_shop_per_page', 10);
function lr_loop_shop_per_page($cols){
	// $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 12;
  return $cols;
}


