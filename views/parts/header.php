<?php
$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_header_text', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';

$blog_info    = esc_attr( get_bloginfo( 'name', 'display' ) );
$description  = get_bloginfo( 'description', 'display' );
$show_title   = get_theme_mod( 'display_header_text', false );

echo '<header id="masthead" class="'. esc_attr( $wrapper_classes ) .'" role="banner"><div id="header">';

if ( has_nav_menu( 'topmenu' ) || is_sidebar_active('topbar-widgets') ){

echo '<div id="topbar"><div class="outermargin">';

if ( has_nav_menu( 'topmenu' ) ){
// topbar menu
echo '<div id="topmenubox" class="secondary-navigation"><div id="topmenu" class="pos-default"><nav><div class="innerpadding">';
  wp_nav_menu( array( 'theme_location' => 'topmenu' ) );
echo '</div></nav></div></div>';
}
// topbar widgets
if( is_sidebar_active('topbar-widgets') ){
  echo '<div id="topbar-widgets">';
    dynamic_sidebar('topbar-widgets');
  echo '</div>';
}

echo '</div></div>';

} // end topbar

if ( get_theme_mod( 'treasure_logo_image' ) || has_custom_logo() || has_nav_menu( 'primary' ) || is_sidebar_active('mainbar-widgets') || $show_title ){

echo '<div id="mainbar"><div class="outermargin">';

// mainbar logo
if ( get_theme_mod( 'treasure_logo_image' ) ){
  echo '<div id="logobox" class="site-logo"><div class="innerpadding">';
  echo '<a href="'.esc_url( home_url( '/' ) ).'" class="site-logo" ';
  echo 'title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" ';
  echo 'rel="home"><img src="'.get_theme_mod( 'treasure_logo_image' ).'" ';
  echo 'alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).' - '.get_bloginfo( 'description' ).'"></a>';
  echo '</div></div>';
}else if ( has_custom_logo() && ! $show_title ){
  echo '<div class="site-logo">';
  the_custom_logo();
  echo '</div>';
}

if ( $show_title ){
  echo '<div id="titlebox" class="site-title"><div class="innerpadding"><hgroup><h1 class="site-title">';
  echo '<a href="'.esc_url( home_url( '/' ) ).'" id="site-logo" ';
  echo 'title="'.$blog_info.'" ';
  echo 'rel="home">'.$blog_info.'</a>';
  echo '</h1>';
  echo '<h2 class="site-description">'.$description.'</h2>';
  echo '</hgroup></div></div>';
}

if ( has_nav_menu( 'primary' ) ){
// mainbar menu
echo '<div id="primarymenubox" class="primary-navigation"><div id="primarymenu" class="pos-default"><nav><div class="innerpadding">';
  wp_nav_menu( array( 'theme_location' => 'primary' ) );
echo '</div></nav></div></div>';
}

// mainbar widgets
if( is_sidebar_active('mainbar-widgets') ){
  echo '<div id="mainbar-widgets">';
    dynamic_sidebar('mainbar-widgets');
  echo '</div>';
}

echo '</div></div>';

} // end mainbar

echo '</div></header>';
