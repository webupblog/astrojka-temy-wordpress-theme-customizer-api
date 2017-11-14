<?php

add_action( 'wp_enqueue_scripts', 'cd_assets' );
function cd_assets() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' );
}

add_filter( 'show_admin_bar', '__return_false' );

add_action( 'after_setup_theme', 'cd_setup' );
function cd_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}

add_action( 'wp_head', 'cd_customizer_css');
function cd_customizer_css()
{
    ?>
         <style type="text/css">
             body { background: #<?php echo get_theme_mod('background_color', '#43C6E4'); ?>; }
         </style>
    <?php
}

add_action( 'customize_preview_init', 'cd_customizer' );

function cd_customizer() {
	wp_enqueue_script('cd_customizer',get_template_directory_uri() . '/customizer.js', array( 'jquery','customize-preview' ), '', true);
}

include('customizer.php');
