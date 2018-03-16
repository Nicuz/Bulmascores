<?php
/**
* The template for displaying the footer
*
* Contains the closing of the #content div and all content after.
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package Bulmascores
*/

?>

<footer class="footer is-light">
	<div class="container">
		<?php
		/* translators: 1: Theme name, 2: Theme author. */
		printf( esc_html__( 'Theme: %1$s by %2$s.', 'bulmascores' ), 'bulmascores', '<a href="https://github.com/Nicuz" target="_blank">Domenico Majorana</a>' );
		?>
	</div><!-- .container -->
</footer><!-- #site-footer -->

<?php wp_footer(); ?>

</body>
</html>
