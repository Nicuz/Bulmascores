<?php
/**
* The template for displaying 404 pages (not found)
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
* @package Bulmascores
*/

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<section class="hero is-medium is-bold">
			<div class="hero-body has-text-centered">
				
				<div class="container">
					<h1 class="title is-1"><?php esc_html_e( '404', 'bulmascores' ); ?></h1>
					<h2 class="subtitle">
						<?php esc_html_e( 'Oops! That page can&rsquo;t be found. Why don&rsquo;t you try to search something?', 'bulmascores' ); ?>
					</h2>
					
					<div class="columns is-mobile is-centered">
						
						<div class="column is-half">
							<?php get_search_form(); ?>
						</div><!-- .column -->

					</div><!-- .columns -->
				</div><!-- .container -->

			</div><!-- .hero-body -->
		</section><!-- .hero -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
