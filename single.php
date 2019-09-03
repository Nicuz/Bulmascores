<?php
/**
* The template for displaying all single posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*
* @package Bulmascores
*/

get_header(); ?>

<div id="primary" class="content-area primary-content"> <!-- This is Single -->
	<main id="main" class="container">

		<div class="columns is-desktop">
		<?php //<div class="columns is-centered"> ?>
			<div class="column is-8">
				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/loops/loop', 'single' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</div><!-- .columns is-8 -->

			<div class="column is-4">
				<?php get_sidebar(); ?>
			</div><!-- .columns is-4 -->

		</div><!-- .columns -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
