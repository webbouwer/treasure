<?php
/**
 * Template Name: Overview Page
 * Theme custom taxonomy and post file
 */

get_template_part('html/htmlhead');

echo '<body '; body_class(); echo '>';

wp_body_open();

echo '<div id="viewcontainer overviewpage">';

get_template_part('html/header');

get_template_part('html/content-overview');

get_template_part('html/footer');

echo '</div>';

wp_footer();

echo '</body></html>';
