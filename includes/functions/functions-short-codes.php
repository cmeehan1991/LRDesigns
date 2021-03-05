<?php 
	
add_shortcode('lr_product_categories', 'product_categories_shortcode');
function product_categories_shortcode(){
	$taxonomy = 'product_cat'; 
	$orderby = 'name';
	$show_count = 0;
	$pad_counts = 0;
	$hierarchical = 1;
	$title = '';
	$empty = 0;
	
	$args = array(
		'taxonomy' => $taxonomy,
		'orderby' => $orderby,
		'show_count' => $show_count,
		'pad_counts' => $pad_counts, 
		'hierarchical' => $hierarchical,
		'title_li' => $title, 
		'hide_empty' => $empty
	);
	
	$all_categories = get_categories($args);
	$categories =  "<p>";
	$categories .= "<ul class='product-categories-home'>";
	foreach($all_categories as $category){
		if($category->category_parent == 0) {
	        $category_id = $category->term_id;       
	        $thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
	        $image = wp_get_attachment_url($thumbnail_id);
	        $categories .= '<li class="product-categories-single">';
	        $categories .= '<a href="'. get_term_link($category->slug, 'product_cat') .'">';
	        $categories .= '<img src="' . $image . '" class="category-image-home" alt="' . $category->name . '"/>';
	        $categories .= '<p class="category-name-home">' . $category->name . '</p>';
	        $categories .= '</a>';
	        $categories .= '</li>';
        }
	}
	$categories .= "</ul>";
	$categories .= "</p>";
	
	return $categories;
}