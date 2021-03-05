<?php 

class LR_Vendors{
	function __construct(){
		
		add_action( 'init', array($this, 'register_lr_vendors_post_type'), 0 );
		add_action('rest_api_init', array($this, 'rest_endpoints'));
	}
	
	public function rest_endpoints(){
		register_rest_route('lr/v1', 'get-vendors', array( 
			'methods'	=> array('GET', 'POST'), 
			'callback'	=> array($this, 'get_vendors'),
			'permission_callback'	=> '__return_true'
		) );
	}
	
	public function get_vendors($args){
		$vendors_args = array(
			'post_type'		=> 'lr_vendor', 
			'post_status'	=> 'publish'
		);
		
		$vendors = get_posts($vendors_args);
		
		$all_vendors = array();
		
		if($vendors){
			foreach($vendors as $vendor){
				$vendor_id = $vendor->ID;
				
				$all_vendors[] = array(
					'vendor_id'			=> $vendor_id,
					'display_name'		=> get_field('display_name', $vendor_id),
					'primary_address'	=> get_field('primary_address', $vendor_id),
					'secondary_address'	=> get_field('secondary_address', $vendor_id),
					'city'				=> get_field('city', $vendor_id),
					'state'				=> get_field('state', $vendor_id),
					'postal_code'		=> get_field('postal_code', $vendor_id),
					'phone_number'		=> get_field('phone_number', $vendor_id),
					'website'			=> get_field('website', $vendor_id),
					'lat'				=> get_field('latitude', $vendor_id),
					'lng'				=> get_field('longitude', $vendor_id),
				);		
			}
		}
		
		
		return $all_vendors;
	}
	
	
	
	// Register Custom Post Type
	public function register_lr_vendors_post_type() {
	
		$labels = array(
			'name'                  => _x( 'Vendors', 'Post Type General Name', LR_TEXTDOMAIN ),
			'singular_name'         => _x( 'Vendor', 'Post Type Singular Name', LR_TEXTDOMAIN ),
			'menu_name'             => __( 'Vendors', LR_TEXTDOMAIN ),
			'name_admin_bar'        => __( 'Vendor', LR_TEXTDOMAIN ),
			'archives'              => __( 'Vendor Archives', LR_TEXTDOMAIN ),
			'attributes'            => __( 'Vendor Attributes', LR_TEXTDOMAIN ),
			'parent_item_colon'     => __( 'Parent Vendor:', LR_TEXTDOMAIN ),
			'all_items'             => __( 'All Vendors', LR_TEXTDOMAIN ),
			'add_new_item'          => __( 'Add New Vendor', LR_TEXTDOMAIN ),
			'add_new'               => __( 'Add New', LR_TEXTDOMAIN ),
			'new_item'              => __( 'New Vendor', LR_TEXTDOMAIN ),
			'edit_item'             => __( 'Edit Vendor', LR_TEXTDOMAIN ),
			'update_item'           => __( 'Update Vendor', LR_TEXTDOMAIN ),
			'view_item'             => __( 'View Vendor', LR_TEXTDOMAIN ),
			'view_items'            => __( 'View Vendors', LR_TEXTDOMAIN ),
			'search_items'          => __( 'Search Vendor', LR_TEXTDOMAIN ),
			'not_found'             => __( 'Not found', LR_TEXTDOMAIN ),
			'not_found_in_trash'    => __( 'Not found in Trash', LR_TEXTDOMAIN ),
			'featured_image'        => __( 'Featured Image', LR_TEXTDOMAIN ),
			'set_featured_image'    => __( 'Set featured image', LR_TEXTDOMAIN ),
			'remove_featured_image' => __( 'Remove featured image', LR_TEXTDOMAIN ),
			'use_featured_image'    => __( 'Use as featured image', LR_TEXTDOMAIN ),
			'insert_into_item'      => __( 'Insert into vendor', LR_TEXTDOMAIN ),
			'uploaded_to_this_item' => __( 'Uploaded to this vendor', LR_TEXTDOMAIN ),
			'items_list'            => __( 'Vendors list', LR_TEXTDOMAIN ),
			'items_list_navigation' => __( 'Vendors list navigation', LR_TEXTDOMAIN ),
			'filter_items_list'     => __( 'Filter vendors list', LR_TEXTDOMAIN ),
		);
		$args = array(
			'label'                 => __( 'Vendor', LR_TEXTDOMAIN ),
			'description'           => __( 'Post Type Description', LR_TEXTDOMAIN ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'lr_vendor', $args );
	
	}
	
	
}

new LR_Vendors();