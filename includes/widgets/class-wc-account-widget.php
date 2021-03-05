<?php 

class LR_WC_Account_Widget extends WP_Widget{
	function __construct(){
		parent::__construct('lr_wc_account_widget','Account Widget');}
	
	/*
	* Create widget front-end
	*/
	public function widget($args, $instance){
		
		$widget_id = 'widget_' . $args['widget_id'];
		
		echo 'Welcome, ';
		
		$accounts_permalink = get_permalink(get_option('woocommerce_myaccount_page_id'));
		
		echo '<a href="' . $accounts_permalink . '">';
		
		if(is_user_logged_in()){
			$user = wp_get_current_user();
			
			echo $user->display_name;
		}else{
			echo ' Sign In';
		}
		
		echo '</a>';
		
		
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

add_action('widgets_init', 'lr_load_wc_account_widget');
function lr_load_wc_account_widget(){
	register_widget('LR_WC_Account_Widget');
}