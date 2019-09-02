<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bulmascores
 */

?>
<!-- front page template -->
<?php if (function_exists('the_subtitle')): ?>

<!-- Flickity Carousel -->
        <h2 class="title is-3 front-section__heading">新着記事</h2>
<div class="carousel" data-flickity='{ "wrapAround": true }'>

<?php
// The Query
$bulmascores_the_query = new WP_Query($args = array(
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => 1,
));

// The Loop
while ($bulmascores_the_query->have_posts()):
    $bulmascores_the_query->the_post();?>

		<?php
    //Get post thumbnail URL
    $bulmascores_img_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'bulmascores_full');?>
		<section style="background: linear-gradient(rgba(0,0,0, 0.4),rgba(0,0,0, 0.4)), url(<?php echo esc_url_raw($bulmascores_img_attributes[0]); ?>); background-size: cover; background-position: center center;" class="hero is-primary is-medium carousel-cell">
			<div class="hero-body">
				<div class="container has-text-centered">
					<a href="<?php the_permalink();?>"><h1 class="title">
						<?php the_title();?>
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
wp_reset_postdata();?>

</div><!-- .carousel -->

<?php endif;?>


<main id="main" class="front-main--container">

	<div class="columns">
		<div class="column is-12">

			<?php
			  bulma_get_front_custom_posts(); 
			  bulma_get_archive_custom_posts(); 
			?>

		</div><!-- .columns is-12 -->

	</div><!-- .columns -->


</main><!-- #main -->
