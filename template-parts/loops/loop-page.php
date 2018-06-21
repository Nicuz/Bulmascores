<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bulmascores
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header has-text-centered">
		<?php the_title( '<h1 class="title">', '</h1>' ); ?>
		<?php the_post_thumbnail( 'bulmascores_thumbnail', array(
			//'class' => 'attachment-post-thumbnail my-custom-class',
			'alt' => get_the_title(),
			'title' => get_the_title(),
			)
		); ?>
	</header><!-- .page-header -->


	<div class="page-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bulmascores' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .page-content -->

</article><!-- #post-<?php the_ID(); ?> -->
