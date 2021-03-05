<?php 
	function lrdesigns_widget_init(){		
		register_sidebar(array(
			'name'          => __('Shop Sidebar: Left', LR_TEXTDOMAIN),
			'id'            => 'shop-sidebar-left',
			'before_widget' => '<ul class="shop-sidebar-left">',
			'after_wideget' => '</ul>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		register_sidebar(array(
			'name'          => __('Shop Sidebar: Right', LR_TEXTDOMAIN),
			'id'            => 'shop-sidebar-right',
			'before_widget' => '<ul class="shop-sidebar-right">',
			'after_wideget' => '</ul>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		register_sidebar(array(
			'name'          => __('Left Secondary Nav', LR_TEXTDOMAIN),
			'id'            => 'secondary-navbar-left',
			'before_widget' => '<ul class="secondary-navbar-left">',
			'after_wideget' => '</ul>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		register_sidebar(array(
			'name'          => __('Center Secondary Nav', LR_TEXTDOMAIN),
			'id'            => 'secondary-navbar-center',
			'before_widget' => '<ul class="secondary-navbar-center">',
			'after_wideget' => '</ul>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		register_sidebar(array(
			'name'          => __('Right Secondary Nav', LR_TEXTDOMAIN),
			'id'            => 'secondary-navbar-right',
			'before_widget' => '<ul class="secondary-navbar-right">',
			'after_wideget' => '</ul>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		register_sidebar(array(
			'name'          => __('Right Primary Nav', LR_TEXTDOMAIN),
			'id'            => 'primary-navbar-right',
			'before_widget' => '<ul class="primaryew-navbar-right">',
			'after_wideget' => '</ul>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
	}
	
	add_action('widgets_init', 'lrdesigns_widget_init');