<?php


/* Widget area's */
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

// active widgets
function is_sidebar_active( $sidebar_id ){
    $the_sidebars = wp_get_sidebars_widgets();
    if( !isset( $the_sidebars[$sidebar_id] ) )
        return false;
    else
        return count( $the_sidebars[$sidebar_id] );
}
