<?php 

class SocialMediaWidget extends WP_Widget{
	function __construct(){
		parent::__construct('social_media_widget','Social Media Widget');}
	
	/*
	* Create widget front-end
	*/
	public function widget($args, $instance){
		
		$widget_id = 'widget_' . $args['widget_id'];
		
		$accounts = get_field('accounts', $widget_id);
		
		if($accounts){
			echo '<ul class="social-media-accounts">';
			foreach($accounts as $account){
				
				$target = get_field('open_in_new_window') ? '_blank' : '_self';
				
				echo '<li>';
				
				echo '<a href="' . $account['url'] . '" style="color:' . get_field('icon_color', $widget_id). '" target="' . $target . '">';
				
				echo $account['icon'];
				
				echo '</a>';
				
				echo '</li>';
			}
			echo '</ul>'; 
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
	public function upate($new_instance, $old_instance){
		return $instance;
	}
	
	
}

add_action('widgets_init', 'lr_load_social_media_widget');
function lr_load_social_media_widget(){
	register_widget('SocialMediaWidget');
}