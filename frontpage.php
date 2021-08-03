<?php
/**
 * frontpage 
 */

 echo '<!DOCTYPE HTML>';
 echo '<html '; language_attributes(); echo '><head>';
 echo '<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo( 'charset' ).'" />';
 echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
 echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';

 if ( ! isset( $content_width ) ) $content_width = 360;

 wp_enqueue_script("jquery"); // default wp jquery
 wp_enqueue_script( 'isotope', get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery' ), '', true );
 wp_enqueue_script( 'imagesloaded', get_template_directory_uri().'/js/imagesloaded.js', array( 'jquery' ), '', true );
 wp_enqueue_script( 'overview-jscode', get_template_directory_uri().'/js/overview.js', array( 'jquery' ), '', true );
 wp_enqueue_style( 'overview-style', get_template_directory_uri().'/css/overview.css' );
 wp_head();

echo '</head>';

echo '<body '; body_class(); echo '>';

wp_body_open();

echo '<div id="viewcontainer overviewpage">';

get_template_part('html/header');

get_template_part('html/content-overview');

get_template_part('html/footer');

echo '</div>';

wp_footer();

echo '</body></html>';
