<?php
/* treasure
 * htmlhead.php
 */
echo '<!DOCTYPE HTML>';
echo '<html '; language_attributes(); echo '><head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo( 'charset' ).'" />';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
if ( ! isset( $content_width ) ) $content_width = 360;
wp_head();
echo '</head>';
