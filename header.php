<?php

get_template_part('views/parts/htmlhead');

echo '<body '; body_class(); echo '>';

wp_body_open();

echo '<div id="page" class="site">';

get_template_part('views/parts/header');

echo '<div id="content" class="site-content"><div id="primary" class="content-area outermargin"><main id="main" class="site-main" role="main">';
