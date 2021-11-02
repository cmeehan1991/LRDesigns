<!DOCTYPE html>
<html>
    <head>
	    <?php 
		get_template_part('partials/header', 'meta');
		get_template_part('partials/header', 'tags');
	    ?>
			
        <title><?php wp_title('|', true, 'right'); ?></title>

        <?php wp_head(); ?>
    </head>
    <body>
		<nav class="navbar navbar-expand-xs navbar-dark bg-dark secondary-nav">
		    <div class="container-fluid">
				    <div class="col-md-3 d-flex d-none d-md-flex">
					   	<?php 
						dynamic_sidebar('secondary-navbar-left');
						?>
				    </div>
				    <div class="col-md-6 col-sm-10 mx-auto d-flex justify-content-center">
					    
					   	<?php 
						dynamic_sidebar('secondary-navbar-center');
						?>
				    </div>
				    <div class="col-md-3 d-flex d-none d-md-flex justify-content-end">
					   	<?php 
						dynamic_sidebar('secondary-navbar-right');
						?>
				    </div>
		    </div>
	    </nav>
		<nav class="navbar navbar-expand-lg navbar-light bg-light primary-nav">
			<div class="container-fluid">
					<div class="col-1">
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
					</div>
					<div class="col-10 mx-auto d-flex justify-content-center">
						<a class="navbar-brand" href="<?php bloginfo('url');?>">
							<?php 
							
							$custom_logo_id = get_theme_mod('custom_logo');
							$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
							
							if(has_custom_logo()){
								echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';	
							}else{
								echo get_bloginfo('name');
							}
							
							?>
						</a>	
					</div>
					<div class="col-1 d-flex justify-content-center">
						<?php dynamic_sidebar('primary-navbar-right'); ?>
					</div>
			</div>
		</nav>
		<nav class="navbar navbar-expand-lg navbar-light bg-light primary-nav primary-nav--navigation">
			<div class="container-fluid">	
			    <?php 
				
				$nav_menu_args = array(
					'theme_location'	=> 'header-menu', 
					'menu_class'		=> 'navbar-nav',
					'menu_id'			=> '', 
					'container'			=> 'div', 
					'container_class'	=> 'collapse navbar-collapse justify-content-center', 
					'container_id'		=> 'navbarSupportedContent', 
					'walker'			=> new WP_Bootstrap_Navwalker(),
				); 
				
				wp_nav_menu($nav_menu_args);  
				?>
				
			</div>
		</nav>
			