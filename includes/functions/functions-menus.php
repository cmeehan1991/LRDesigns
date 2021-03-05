<?php 

add_action( 'after_theme_setup', 'register_menu' );	
function register_menu() {
	register_nav_menu('header-menu',__( 'Header Menu' ));
}

