<?php 

class LR_WC_Product_Collection_Widget extends WP_Widget{
	function __construct(){
		parent::__construct('lr_wc_product_collection_widget','Product Collection Widget');}
	
	/*
	* Create widget front-end
	*/
	public function widget($args, $instance){
		
		global $woocommerce;
		
		$widget_id = 'widget_' . $args['widget_id'];
		
		$title = get_field('title', $widget_id);
		
		$hide_empty_collections = get_field('hide_empty_collections', $widget_id);
		
		$collections = get_terms(array(
			'taxonomy'		=> 'lr_product_collection',
			'hide_empty'	=> $hide_empty_collections,
		) );
		

		
		if($collections){
					
			if($title){
			
				echo "<h3 class='widget-title'>" . $title . "</h3>";
			
			}
			?>
			<ul class="collections-widget">
			<?php
			foreach($collections as $collection){
				
				$url = get_term_link($collection->term_id, 'lr_product_collection');
				
				?>
				<li class="collection-item collection-item-<?php echo $collection->term_id; ?>"><a href="<?php echo $url; ?>"><?php echo $collection->name; ?></a></li>
				<?php 
			}
			?>
			</ul>
			<?php
		}
		
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

add_action('widgets_init', 'lr_load_wc_product_collection_widget');
function lr_load_wc_product_collection_widget(){
	register_widget('LR_WC_Product_Collection_Widget');
}