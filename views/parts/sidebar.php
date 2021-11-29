<?php
// sidebar
if ( has_nav_menu( 'sidemenu' ) || ( function_exists('is_sidebar_active') && is_sidebar_active('sidebar') ) ){

echo '<div id="sidebar"><div class="innerpadding">';

// sidemenu
if ( has_nav_menu( 'sidemenu' ) ){
  echo '<div id="sidemenubox"><div id="sidemenu" class="pos-default"><nav><div class="innerpadding">';
    wp_nav_menu( array( 'theme_location' => 'sidemenu' ) );
  echo '</div></nav></div></div>';
}
// sidebar
if( function_exists('is_sidebar_active') && is_sidebar_active('sidebar') ){
  echo '<div id="sidebar_widgets"><div class="widgets_outermargin">';
    dynamic_sidebar('sidebar');
  echo '</div></div>';
}

echo '</div></div>';

}
