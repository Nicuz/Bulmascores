<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Bulmascores
 */

if ( ! function_exists( 'bulmascores_post_meta' ) ) :
	function bulmascores_post_meta( $info ) {
		// Hide category and tags for pages.
		if ( 'post' === get_post_type() ) {

			echo '<div class="tags">';

			if ( 'categories' == $info ) {
				$categories = get_the_category();
				foreach ( $categories as $category ) {
					echo '<a class="tag is-medium" href="' . esc_url( get_category_link( $category->cat_ID ) ) . '">' . $category->name . '</a>';
				}
			} elseif ( 'tags' == $info ) {
				if ( get_the_tags() ) {
					$tags = get_the_tags();
					foreach ( $tags as $tag ) {
						echo '<a class="tag is-medium" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . $tag->name . '</a>';
					}
				}
			}

			echo '</div>';
		}
	}
endif;
