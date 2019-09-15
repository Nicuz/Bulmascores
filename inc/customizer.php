<?php
/**
 * Bulmascores Theme Customizer
 *
 * @package Bulmascores
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bulmascores_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'background_image' );

	$wp_customize->add_section( 'origin_scheme',array(
		'title'     => 'オリジナル項目',
		'priority'  =>  200,
	) );
	$wp_customize->add_setting( 'top_hero_option_1',array(
		'default'   =>  'MD参加ボタン',
		'type'      =>  'option',
		'transport' =>  'postMessage',
	) );
	$wp_customize->add_control( 'my_theme_top_hero_option',array(
		'settings'  =>  'top_hero_option_1',
		'label'     =>  'MD参加ボタンの項目',
		'section'   =>  'origin_scheme',
		'type'      =>  'text',
	) );

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'bulmascores_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'bulmascores_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'bulmascores_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function bulmascores_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function bulmascores_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bulmascores_customize_preview_js() {
	wp_enqueue_script( 'bulmascores-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'bulmascores_customize_preview_js' );
