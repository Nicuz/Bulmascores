<?php
/**
* The main template file
* Template Name: Front Page
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

<div id="primary" class="content-area"> <!-- this is frontpage -->

	<?php get_template_part( 'template-parts/contents/content', 'frontpage' ); ?>

</div><!-- #primary -->


<?php get_footer(); ?>
