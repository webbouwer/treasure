<?php
$footer_display = get_theme_mod( 'treasure_footer_content_display', 'display');

if( $footer_display != 'hide' ){

echo '<div id="footer">';

// bottombar menu
if ( has_nav_menu( 'footermenu' ) ){
   echo '<div id="footermenubox" class="column"><div id="footermenu" class="pos-default"><nav><div class="innerpadding">';
     wp_nav_menu( array( 'theme_location' => 'footermenu' ) );
   echo '<div class="clr"></div></div></nav></div></div>';
}


if( function_exists('is_sidebar_active') && is_sidebar_active('footer-widgets') ){
  echo '<div id="footer_widgets" class="column">';
    dynamic_sidebar('footer-widgets');
  echo '</div>';
}

echo '<div id="footnotecontent"><div class="outermargin">';

// footnote_display
$footnote_copyright_text = get_theme_mod( 'treasure_footer_copyrighttext', 'Copyright 2021');

echo '<div id="footnote_copyright" class="column"><div class="innerpadding">';
echo $footnote_copyright_text;
echo '</div></div>';


echo '</div></div>';


echo '</div>';


}
