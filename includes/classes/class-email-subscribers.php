<?php 

class EmailSubscribers{
	
	function __construct(){
		//add_action('init', array($this, 'register_subscribers_post_type'));
	}
	
	public function register_subscribers_post_type(){
		$labels = array(
			'name'                  => _x( 'Email Subscribers', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Email Subscriber', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Email Subscribers', 'text_domain' ),
			'name_admin_bar'        => __( 'Email Subscriber', 'text_domain' ),
			'archives'              => __( 'Email Subscriber Archives', 'text_domain' ),
			'attributes'            => __( 'Email Subscriber Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Subscriber:', 'text_domain' ),
			'all_items'             => __( 'All Subscribers', 'text_domain' ),
			'add_new_item'          => __( 'Add New Subscriber', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Subscriber', 'text_domain' ),
			'edit_item'             => __( 'Edit Subscriber', 'text_domain' ),
			'update_item'           => __( 'Update Subscriber', 'text_domain' ),
			'view_item'             => __( 'View Subscriber', 'text_domain' ),
			'view_items'            => __( 'View Subscribers', 'text_domain' ),
			'search_items'          => __( 'Search Subscriber', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into subscriber', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this subscriber', 'text_domain' ),
			'items_list'            => __( 'Subscribers list', 'text_domain' ),
			'items_list_navigation' => __( 'Subscribers list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter subscribers list', 'text_domain' ),
		);
		$args = array(
			'label'                 => __( 'Email Subscriber', 'text_domain' ),
			'description'           => __( 'Post Type Description', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'revisions', 'custom-fields' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 60,
			'menu_icon'             => 'dashicons-email-alt2',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		
		register_post_type( 'lr_email_subscribers', $args );
	}

	
	
	
	
}new EmailSubscribers();