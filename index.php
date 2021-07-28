<?php
/* Protago
 * index.php
 * default theme file
 */

// $options = get_option( 'protago_settings' );

get_template_part('html/htmlhead');

echo '<body '; body_class(); echo '>';

wp_body_open();

echo '<div id="viewcontainer">';

get_template_part('html/header');

get_template_part('html/content');

get_template_part('html/footer');

echo '</div>';

wp_footer();

echo '</body></html>';
