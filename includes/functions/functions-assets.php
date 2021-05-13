<?php

function lrdesigns_custom_styles(){
    //wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css', array(), '2.2.1');
    wp_enqueue_style('allstyles', BLOG_URI.'/assets/styles/dist/allstyles.css', array(), rand());
}
add_action('wp_enqueue_scripts','lrdesigns_custom_styles');


// Javascript files - front end
add_action('wp_enqueue_scripts','lrdesigns_scripts');
function lrdesigns_scripts(){
    wp_register_script('allscripts', BLOG_URI . '/assets/scripts/js/dist/allscripts.min.js', array(), rand(), false);
    wp_localize_script('allscripts', 'rest_api', array(
	    'base'			=> get_rest_url(),
	    'get_vendors'	=> get_rest_url(get_current_blog_id(), 'lr/v1/get-vendors'),
    ) );
    
    wp_enqueue_script('allscripts');
    
}



