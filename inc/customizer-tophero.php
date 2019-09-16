<?php
/*
*/
define('IMG_SECTION', 'img_scheme');
define('LOGO_IMAGE_URL','logo_img_url');

define('HERO_BG_IMAGE_URL','bg_img_url');

function original_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'origin_scheme',array(
		'title'     => 'オリジナル項目',
		'priority'  =>  200,
		'description' => 'サイトのトップに表示する項目'
	) );
	$wp_customize->add_section(IMG_SECTION,array(
		'title'     => '画像挿入',
		'priority'  =>  59,
		'description' => 'ここに画像をアップロードしてください'
	) );
	$wp_customize->add_setting( LOGO_IMAGE_URL, array(
		'transport' =>  'postMessage',
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,LOGO_IMAGE_URL,array(
		'section'   =>  IMG_SECTION,
		'settings'  =>  LOGO_IMAGE_URL,
		'label'     =>  'トップページだけに表示するロゴ',
		'description' => '100px x 100px 画像を入れてください'
	)));
	$wp_customize->add_setting( HERO_BG_IMAGE_URL, array(
		'transport' =>  'postMessage',
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,HERO_BG_IMAGE_URL,array(
		'section'   =>  IMG_SECTION,
		'settings'  =>  HERO_BG_IMAGE_URL,
		'label'     =>  'トップページだけに表示する背景画像',
		'description' => '1980px x 1080px 以上の画像を入れてください'
	)));
	$wp_customize->add_setting( 'top_hero_option_1',array(
		'default'   =>  'MD参加ボタン',
		'type'      =>  'option',
		'transport' =>  'postMessage',
	) );
	$wp_customize->add_control( 'my_theme_top_hero_option_1',array(
		'settings'  =>  'top_hero_option_1',
		'label'     =>  'MD参加ボタンの項目',
		'section'   =>  'origin_scheme',
		'type'      =>  'text',
	) );
	$wp_customize->add_setting( 'top_hero_option_2',array(
		'default'   =>  '2019/12/7',
		'type'      =>  'option',
		'transport' =>  'postMessage',
	) );
	$wp_customize->add_control( 'my_theme_top_hero_option_2',array(
		'settings'  =>  'top_hero_option_2',
		'label'     =>  'MD開催日',
		'section'   =>  'origin_scheme',
		'type'      =>  'text',
	) );
	$wp_customize->add_setting( 'top_hero_option_3',array(
		'default'   =>  '集合場所',
		'type'      =>  'option',
		'transport' =>  'postMessage',
	) );
	$wp_customize->add_control( 'my_theme_top_hero_option_3',array(
		'settings'  =>  'top_hero_option_3',
		'label'     =>  'MDの場所',
		'section'   =>  'origin_scheme',
		'type'      =>  'text',
    ) );
}// #original_customize_register
add_action( 'customize_register', 'original_customize_register' );

// LOGOを呼び出す独自関数
function get_the_hero_logo_img_url(){
	return esc_url( get_theme_mod( 'logo_img_url' ) );
}
// HEROの背景画像
function get_the_hero_background_img_url(){
	return esc_url( get_theme_mod( 'bg_img_url' ) );
}
