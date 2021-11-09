<?php

define('BLOG_URI', get_template_directory_uri());
define('BLOG_PATH', get_template_directory());
define('LR_VERSION', '0.0.1');
define('LR_TEXTDOMAIN', 'lrdesign');

/* Functions - REQUIRED */
include(BLOG_PATH . '/includes/functions/functions-assets.php');
include(BLOG_PATH . '/includes/functions/functions-sidebars.php');
include(BLOG_PATH . '/includes/functions/functions-theme-supports.php');
include(BLOG_PATH . '/includes/functions/functions-menus.php');
include(BLOG_PATH . '/includes/functions/functions-acf.php');


/*Classes - Required */
include(BLOG_PATH . '/includes/classes/class-bootstrap-nav-menu.php');
include(BLOG_PATH . '/includes/classes/class-vendors.php');
include(BLOG_PATH . '/includes/classes/class-woocommerce.php');

/* Widgets */
//include(BLOG_PATH . '/includes/widgets/class-social-media-widget.php');
include(BLOG_PATH . '/includes/widgets/class-wc-account-widget.php');
include(BLOG_PATH . '/includes/widgets/class-wc-cart-widget.php');
include(BLOG_PATH . '/includes/widgets/class-wc-product-collection-widget.php');

// Include custom editor UI - REQUIRED
//include(BLOG_PATH . '/includes/editor/classes/general.php');
//include(BLOG_PATH . '/includes/editor/classes/advanced-elements.php');

// Manually add ACF groups
foreach (glob(BLOG_PATH . '/includes/acf/groups/*_active.php') as $filename) {
	include_once $filename;
}

//Hide the admin bar
show_admin_bar(true);

