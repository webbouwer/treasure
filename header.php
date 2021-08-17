<?php

get_template_part('html/htmlhead');

echo '<body '; body_class(); echo '>';

wp_body_open();

echo '<div id="viewcontainer">';

get_template_part('html/header');

echo '<div id="postcontent"><div class="outermargin">';
