<?php
/*
Class Name: Bulma_Walker
Description: Custom walker using Bulma components (tested with Bulma 0.6.2 on Wordpress 4.9.4)
Version: 0.3
Author: Domenico Majorana
Source: https://github.com/Nicuz/Bulma-WordPress-snippets/blob/master/class-bulma-walker.php
Credit: Based on https://www.microdot.io/simpler-wp-nav-menu-markup/
*/

class Bulma_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '<div class="navbar-dropdown is-boxed">';
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</div> <!-- .navbar-dropdown -->';
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes = array();
		if ( ! empty( $item->classes ) ) {
			$classes = (array) $item->classes;
		}

		$url = '';
		if ( ! empty( $item->url ) ) {
			$url = $item->url;
		}
		if ( in_array( 'menu-item-has-children',$item->classes ) ) {
			$output .= '<div class="navbar-item has-dropdown is-hoverable"><a class="navbar-link" href="' . $url . '">' . $item->title . '</a>';
		} else {
			$output .= '<a class="navbar-item" href="' . $url . '">' . $item->title . '</a>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( in_array( 'menu-item-has-children',$item->classes ) ) {
			$output .= '</div> <!-- .has-dropdown -->';
		} else {
			$output .= '';
		}
	}
}
