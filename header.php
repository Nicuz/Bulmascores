<?php
/**
* The header for our theme
*
* This is the template that displays all of the <head> section and everything up until <div id="content">
	*
	* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	*
	* @package Bulmascores
	*/
	?>
	<!doctype html>
	<html <?php language_attributes();?>>
		<head>
			<meta charset="<?php bloginfo('charset');?>">
			<meta name="description" content="<?php bloginfo('description');?>">
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
			<link rel="profile" href="http://gmpg.org/xfn/11">
			<?php wp_head();?>
		</head>
		<body <?php body_class();?>>
			<!-- Navbar Menu -->
			<header id="masthead" class="site-header">
				<!-- <nav class="navbar is-light"> -->
				<nav class="navbar is-dark">
					<div class="container">
						<div class="navbar-brand">
							<a class="navbar-item" href="<?php echo esc_url_raw(home_url()); ?>">
							<?php
							if (has_custom_logo()) {
								$custom_logo_id = get_theme_mod('custom_logo');
								// $custom_logo_attributes = wp_get_attachment_image_src($custom_logo_id);
								echo wp_get_attachment_image($custom_logo_id,false,false,array('class'=>'custom-logo') );
							?>
								<h1><?php bloginfo('name');?></h1>
							</a>
							<?php }?>
							<div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</div><!-- .navbar-brand -->

						<div id="navbarExampleTransparentExample" class="navbar-menu">
							<!-- <div class="navbar-start"> -->
							<div class="navbar-end">
								<?php wp_nav_menu(array(
								'theme_location' => 'menu-1', //change it according to your register_nav_menus() function
								'depth'          => 2,
								'container'      => 'navbar-start',
								'items_wrap'     => '%3$s',
								'walker'         => new Bulma_Walker(),
								));
								?>
							</div>
							<!-- <div class="navbar-end"> -->
								<!-- <div class="navbar-item"> -->
									<!-- <div id="social-icons" class="field is-grouped"> -->
										<!-- <a class="navbar-item" href="#"><i class="fab fa-github"></i></a> -->
										<!-- <a class="navbar-item" href="#"><i class="fab fa-twitter"></i></a> -->
										<!-- <a class="navbar-item" href="#"><i class="fab fa-linkedin"></i></a> -->
										<!-- <a class="navbar-item" href="#"><i class="fab fa-youtube"></i></a> -->
									<!-- </div>.field -->
								<!-- </div>.navbar-item -->
							<!-- </div>.navbar-end -->
						</div>
					</div><!-- .container -->
				</nav>
				<?php breadcrumb(); ?>
			</header><!-- #masthead -->