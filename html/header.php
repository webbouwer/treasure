<?php
echo '<div id="header">';

echo '<div id="mainbar" class=""><div class="outermargin">';

// mainbar logo
if ( get_theme_mod( 'treasure_logo_image' ) ){
  echo '<div id="logobox"><div class="innerpadding">';
  echo '<a href="'.esc_url( home_url( '/' ) ).'" class="site-logo" ';
  echo 'title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" ';
  echo 'rel="home"><img src="'.get_theme_mod( 'treasure_logo_image' ).'" ';
  echo 'alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).' - '.get_bloginfo( 'description' ).'"></a>';
  echo '</div></div>';
}else{
  echo '<div id="logobox"><div class="innerpadding"><hgroup><h1 class="site-title">';
  echo '<a href="'.esc_url( home_url( '/' ) ).'" id="site-logo" ';
  echo 'title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" ';
  echo 'rel="home">'.esc_attr( get_bloginfo( 'name', 'display' ) ).'</a>';
  echo '</h1>';
  echo '<h2 class="site-description">'.get_bloginfo( 'description' ).'</h2>';
  echo '</hgroup></div></div>';
}

// mainbar menu
echo '<div id="mainmenubox"><div id="mainmenu" class="pos-default"><nav><div class="innerpadding">';
  wp_nav_menu( array( 'theme_location' => 'mainmenu' ) );
echo '</div></nav></div></div>';

// mainbar widgets
if( function_exists('is_sidebar_active') && is_sidebar_active('mainbar-widgets') ){
  echo '<div id="mainbar-widgets">';
    dynamic_sidebar('mainbar-widgets');
  echo '</div>';
}

echo '</div></div>';

echo '</div>';
