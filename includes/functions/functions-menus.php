<?php 

add_action( 'after_setup_theme', 'register_menu' );	
function register_menu() {
	register_nav_menu('header-menu',__( 'Header Menu' ));
}

