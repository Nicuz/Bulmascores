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

<div id="primary" class="content-area">

	<main id="main" class="container">

		<div class="columns">
			<div class="column is-8">

				<?php if ( is_search() ) { ?>
					<h1 class="title">
						<?php // translators:
						printf( esc_html__( 'Search Results for: %s', 'bulmascores' ), get_search_query() );
						?>
					</h1>
				<?php } elseif ( is_category() || is_tag() ) { ?>
					<section class="breadcrumb" aria-label="breadcrumbs">
						<ul>
							<li><a href="<?php echo esc_url_raw( home_url() );?>"><?php bloginfo( 'name' ); ?></a></li>

							<?php //Add the posts page if enabled under Settings>Reading
							if ( get_option( 'page_for_posts' ) ) { ?>
								<li><a href="<?php echo esc_url_raw( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></a></li>
							<?php } ?>

							<li class="is-active"><a href="" aria-current="page"><h1><?php echo single_cat_title(); ?></h1></a></li>
						</ul>
					</section>
				<?php } ?>

				<?php
				if ( have_posts() ) :
					/* Start the Loop */
					while ( have_posts() ) : the_post();
						get_template_part( 'loop-parts/loop', get_post_format() );
					endwhile;

				else :
					get_template_part( 'loop-parts/content', 'none' );

				endif;
				?>

				<nav class="pagination is-centered" role="navigation" aria-label="pagination">
					<?php echo bulma_pagination(); ?>
				</nav>

			</div><!-- .columns is-8 -->

			<div class="column is-4">
				<?php get_sidebar(); ?>
			</div><!-- .columns is-4 -->

		</div><!-- .columns -->

	</main><!-- #main -->
</div><!-- #primary -->


<?php get_footer(); ?>
