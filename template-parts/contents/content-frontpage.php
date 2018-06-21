<?php
/**
* Template part for displaying posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Bulmascores
*/

?>

<!-- Flickity Carousel -->
<div class="carousel" data-flickity='{ "wrapAround": true }'>

<?php
// The Query
$bulmascores_the_query = new WP_Query( $args = array(
	'posts_per_page' => 3,
	'ignore_sticky_posts' => 1,
) );

// The Loop
while ( $bulmascores_the_query->have_posts() ) :
	$bulmascores_the_query->the_post(); ?>

	<?php
	//Get post thumbnail URL
	$bulmascores_img_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'bulmascores_full' );?>

	<section style="background: linear-gradient(rgba(0,0,0, 0.4),rgba(0,0,0, 0.4)), url(<?php echo esc_url_raw( $bulmascores_img_attributes[0] );?>); background-size: cover; background-position: center center;" class="hero is-primary is-medium carousel-cell">
		<div class="hero-body">
			<div class="container has-text-centered">
				<a href="<?php the_permalink(); ?>"><h1 class="title">
					<?php the_title(); ?>
				</h1></a>
				<h2 class="subtitle">
					<?php
					//WP Subtitle plugin: https://it.wordpress.org/plugins/wp-subtitle/
					the_subtitle();
					?>
				</h2>
			</div>
		</div>
	</section>

<?php endwhile;

// Restore original Post Data
wp_reset_query();
wp_reset_postdata(); ?>

</div><!-- .carousel -->

<main id="main" class="container">

	<div class="columns">
		<div class="column is-8">

			<?php
			// The Query
			$bulmascores_the_query = new WP_Query( $args = 'posts_per_page=5' );

			// The Loop
			if ( $bulmascores_the_query->have_posts() ) :
				while ( $bulmascores_the_query->have_posts() ) :
					$bulmascores_the_query->the_post();

					get_template_part( 'template-parts/loops/loop', get_post_format() );
				endwhile;

			else :
				get_template_part( 'template-parts/contents/content', 'none' );

			endif;

			// Restore original Post Data
			wp_reset_query();
			wp_reset_postdata();
			?>

			<a class="button is-large" href="<?php echo esc_url_raw( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'View all posts', 'bulmascores' ); ?></a>

		</div><!-- .columns is-8 -->

		<div class="column is-4">
			<?php get_sidebar(); ?>
		</div><!-- .columns is-4 -->

	</div><!-- .columns -->


</main><!-- #main -->
