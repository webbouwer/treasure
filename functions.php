<?php
/* Treasure
 * functions.php
 */


require get_stylesheet_directory() . '/customizer.php';
require get_stylesheet_directory() . '/assets/taxonomy_types.php';
require get_stylesheet_directory() . '/assets/taxonomy_collection.php';
require get_stylesheet_directory() . '/assets/post_artifact.php';


/*
 * Register Theme Support
 */
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
/*
 * Register menu's
 */
function theme_setup_register_menus() {
	register_nav_menus(
		array(
			'topmenu' => __( 'Top menu' , 'treasure' ),
			'mainmenu' => __( 'Main menu' , 'treasure' ),
			'sidemenu' => __( 'Side menu' , 'treasure' ),
			'footermenu' => __( 'Footer menu' , 'treasure' )
			)
		);
	}
	add_action( 'init', 'theme_setup_register_menus' );

/*
 * Editor style WP THEME STANDARD
 */

 // register global customizer variables
 function wp_main_theme_global_js() {
     // add jquery
     wp_enqueue_script("jquery"); // default wp jquery
     wp_register_script( 'global_js', get_template_directory_uri().'/js/functions.js', 99, '1.0', false); // register the script
     /*
		 global $wp_global_data; // get global data var
 		 wp_localize_script( 'global_js', 'site_data', $wp_global_data ); // localize the global data list for the script
		 */
		 // localize the script with specific data.
     //$color_array = array( 'color1' => get_theme_mod('color1'), 'color2' => '#000099' );
     //wp_localize_script( 'custom_global_js', 'object_name', $color_array );
     // The script can be enqueued now or later.
     wp_enqueue_script( 'global_js');
 }
 add_action('wp_enqueue_scripts', 'wp_main_theme_global_js');


 // register style sheet
 function wp_main_theme_stylesheet(){
     $stylesheet = get_template_directory_uri().'/style.css';
     echo '<link rel="stylesheet" id="wp-theme-main-style"  href="'.$stylesheet.'" type="text/css" media="all" />';
 }
 add_action( 'wp_head', 'wp_main_theme_stylesheet', 9999 );

 // for admin editor
function theme_editor_styles() {
	add_editor_style( 'style.css' );
	//add_editor_style( get_theme_mod('onepiece_identity_stylelayout_stylesheet', 'default.css') );
}
add_action( 'admin_init', 'theme_editor_styles' );


/* Widgets */
function theme_setup_widgets_init() {
	if (function_exists('register_sidebar')) {

		// the topbar side widgets
		register_sidebar(array(
			'name' => 'Topbar widgets',
			'id'   => 'topbar-widgets',
			'description'   => 'This is the topbar widgetized area.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));


		// the mainbar side widgets
		register_sidebar(array(
			'name' => 'Mainbar widgets',
			'id'   => 'mainbar-widgets',
			'description'   => 'This is the mainbar widgetized area.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));

		// the content sidebar widget
		register_sidebar(array(
			'name' => 'Content sidebar (Widgets Default)',
			'id'   => 'sidebar',
			'description'   => 'This is a standard wordpress sidebar widgetized area.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));

		register_sidebar(array(
			'name' => 'Footer widgetbox',
			'id'   => 'footer-widgets',
			'description'   => 'Footer widgets in column 5.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));

	}
}
add_action( 'widgets_init', 'theme_setup_widgets_init' );


/*
 * Active widgets
 */
function is_sidebar_active( $sidebar_id ){
    $the_sidebars = wp_get_sidebars_widgets();
    if( !isset( $the_sidebars[$sidebar_id] ) )
        return false;
    else
        return count( $the_sidebars[$sidebar_id] );
}

/*
 * Time posted ago format
 */
function wp_time_ago( $t ) {
// https://codex.wordpress.org/Function_Reference/human_time_diff
//get_the_time( 'U' )
	printf( _x( '%s '.__('geleden', 'protago' ), '%s = human-readable time difference', 'protago' ), human_time_diff( $t, current_time( 'timestamp' ) ) );
}
function time_post_public( $t , $display = 'ago') {

	if( $display == 'ago' ){
		echo wp_time_ago( $t );
		return;
	}

}

/**** *****/

function getCollections(){

  $tax = 'collection';
  //return json_encode( get_terms( $tax ) );
	// https://developer.wordpress.org/reference/functions/the_terms/
  $collections = get_terms( $tax, array(
  	'taxonomy' => $tax,
  	'hide_empty' => false,
  	'parent' => 0,
  ) );

  //print_r($my_terms);
	foreach($collections as $collection) {
		echo '<a class="btn  btn-default " href="' . get_category_link($collection->term_id) . '">' . $collection->name . '</a>';
 	}
}

function getCollectionsAndPosts(){

	$collection_slug = get_queried_object()->slug;
	$collection_name = get_queried_object()->name;

	echo '<h2>'.$collection_name.'</h2>';

	$get_post_args = array(
	                    'post_type' => 'artifact', // Your Post type Name that You Registered
	                    'posts_per_page' => 999,
	                    'order' => 'ASC',
	                    'tax_query' => array(
	                        array(
	                            'taxonomy' => 'collection',
	                            'field' => 'slug',
	                            'terms' => $collection_slug
	                        )
	                    )
	                );
	$collection_posts = new WP_Query($get_post_args);

	if($collection_posts->have_posts()) :
	                 while($collection_posts->have_posts()) :
	                      $collection_posts->the_post();
	                      echo '<div class="post-artifact">';
												if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
														the_post_thumbnail( 'thumb' );
												}
	          echo '<h2 class="entry-title" itemprop="headline"><a href="'.get_the_permalink().'" class="entry-title-link">'.get_the_title().'</a></h2>
	                      <div class="entry-excerpt">'.get_the_excerpt().'</div></div>';

	    endwhile;
	endif;
}

function getArtifacts(){

  $pst = 'artifact';

  $my_posts = array(
    'post_type' => $pst,
    'posts_per_page' => -1
  );
  $the_query = new WP_Query( $my_posts );
  //print_r($the_query);
  while ( $the_query->have_posts() ) : $the_query->the_post();

    echo '<h1><a href="'.get_the_permalink().'">'.get_the_title().'</a></h1>';
    echo apply_filters('the_content', the_content());

  endwhile;

}
