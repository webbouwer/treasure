<?php


// global setup
function theme_setup_globals() {
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'big-thumb', 460, 9999 );
  add_image_size( 'normal', 1180, 9999 );
  add_theme_support( 'title-tag' );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'custom-header' );
  add_theme_support( 'custom-background' );
}
add_action( 'after_setup_theme', 'theme_setup_globals' );

// register menu's
function theme_setup_register_menus() {
  register_nav_menus(
    array(
      'topmenu' => __( 'Top menu' , 'treasure' ),
      'primary' => __( 'Primary (main) menu' , 'treasure' ),
      'sidemenu' => __( 'Side menu' , 'treasure' ),
      'footer' => __( 'Footer (secondary) menu' , 'treasure' )
    )
  );
}
add_action( 'init', 'theme_setup_register_menus' );

// register style sheet
function wp_main_theme_stylesheet(){
  $stylesheet = get_template_directory_uri().'/style.css';
  echo '<link rel="stylesheet" id="wp-theme-main-style"  href="'.$stylesheet.'" type="text/css" media="all" />';
}
add_action( 'wp_head', 'wp_main_theme_stylesheet', 9999 );

// register style sheet for admin editor
function theme_editor_styles() {
  add_editor_style( 'style.css' );
}
add_action( 'admin_init', 'theme_editor_styles' );
