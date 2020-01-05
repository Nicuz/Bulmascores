<?php
/**
* The main template file
*
* This is the most generic template file in a WordPress theme
* and one of the two required files for a theme (the other being style.css).
* It is used to display a page when nothing more specific matches a query.
* E.g., it puts together the home page when no home.php file exists.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Bulmascores
*/

get_header(); ?>

<div id="primary" class="content-area primary-content--index">

	<main id="main" class="container">

		<div class="columns">
			<div class="column is-12">

				<?php if ( is_search() ) { ?>
					<h1 class="title">
						<?php // translators:
						printf( esc_html__( 'Search Results for: %s', 'bulmascores' ), get_search_query() );
						?>
					</h1>
				<?php } ?>
				<?php
				if ( have_posts() ) : 
					/* Start the Loop */ ?>
					<div class="columns">
					<?php while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/loops/loop', 'card' );
					    	endwhile;
                    ?>
					</div>
				
				<?php else :
					get_template_part( 'template-parts/contents/content', 'none' );

				endif;
				?>

				<nav class="pagination is-centered" role="navigation" aria-label="pagination">
					<?php echo bulma_pagination(); ?>
				</nav>

			</div><!-- .columns is-12 -->

			<?php // <div class="column is-4"> ?>
			<?php // get_sidebar(); ?>
			<?php // </div><!-- .columns is-4 --> ?>

		</div><!-- .columns -->

	</main><!-- #main -->
</div><!-- #primary -->


<?php get_footer(); ?>