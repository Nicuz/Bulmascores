<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bulmascores
 */

?>

<article id="post-<?php the_ID();?>" <?php post_class();?>>

	<?php bulmascores_post_meta('categories');?>
    <?php echo get_post_meta($post->ID, 'on_off',true); ?>
	<header class="post-header">
		<div class="single-post-header">
			<?php // the_title('<h1 class="title is-1 single-post-title">', '</h1>');?>
			<?php the_title('<h1 class="title is-1 single-post-title">', '</h1>');?>
			<?php if (function_exists('the_subtitle')): ?>
			<?php the_subtitle('<h2 class="subtitle">', '</h2>');?>
			<?php endif;?>

			<?php 
				if (has_post_thumbnail() ) {
					the_post_thumbnail('bulmascores_thumbnail', 
						array(
							//'class' => 'attachment-post-thumbnail my-custom-class',
							'class' => 'single-post-thumbnail',
							'alt'   => get_the_title(),
							'title' => get_the_title(),
						)
					);
				}else{
					$image_url = get_template_directory_uri(). '/assets/img/daitai_cat.jpg';
					echo '<img src='. $image_url. '>';
				}
			?>
		</div>
		
		<?php if ('post' === get_post_type()): ?>
			<div class="post-meta signle-post-meta">
				<p>
					<?php esc_html_e('Last modified&nbsp;', 'bulmascores')?><time><?php the_modified_date('Y/m/j');?></time>
					<?php // esc_html_e('by&nbsp;', 'bulmascores') . the_author_posts_link();?>
				</p>
			</div><!-- .post-meta -->
			<?php
endif;?>

		</header><!-- .post-header -->


		<div class="content">
			<?php
the_content();

wp_link_pages(array(
    'before' => '<div class="page-links">' . esc_html__('Pages:', 'bulmascores'),
    'after'  => '</div>',
));
?>
		</div><!-- .content -->

		<footer>
			<?php bulmascores_post_meta('tags');?>
			<?php get_template_part('template-parts/contents/content', 'social');?>
		</footer>

	</article><!-- #post-<?php the_ID();?> -->
