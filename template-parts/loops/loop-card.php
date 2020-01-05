<?php
/**
* Template part for displaying posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Bulmascores
*/

?>
<div class="column is-4">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>">
			<div class="card">
				<div class="card-image">
					<figure class="image is-4by3">
					<?php
						the_post_thumbnail( 'bulmascores_thumbnail', array(
							//'class' => 'attachment-post-thumbnail my-custom-class',
							'alt' => get_the_title(),
							'title' => get_the_title(),
						) ); ?>
					</figure>
				</div> <!-- #card-image -->
				<div class="card-content">
					<main>
						<div class="content">
							<?php //the_title( '<h2 class="title is-marginless"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
							<?php the_title( '<h2 class="title is-marginless" rel="bookmark">', '</h2>' ); ?>
							<?php the_excerpt(); ?>
							<time datetime="<?php the_modified_date( 'j/m/Y' ); ?>"><?php the_modified_date( 'j/m/Y' ); ?></time>
						</div>
					</main>
				</div> <!-- #card-content -->
			</div> <!-- #card -->
		</a>
	</article><!-- #post-<?php //the_ID(); ?> -->
</div>