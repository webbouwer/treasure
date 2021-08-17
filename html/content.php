<?php

echo '<div id="loopcontainer">';

if ( have_posts() ) :

  while( have_posts() ) : the_post();

  ?>

    <div id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>
    <div class="innerpadding">
    <?php

    if ( is_super_admin() && ( is_single() || is_page() ) ) {
      edit_post_link( __( 'Edit' , 'treasure' ), '<span class="edit-link">', '</span>' );
    }

    // post meta
    // time_post_public

    if( is_single() || is_page() ){

        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						the_post_thumbnail( 'full' );
				}

        echo '<h1><a href="'.get_the_permalink().'">'.get_the_title().'</a></h1>';


        echo apply_filters('the_content', get_the_content());

        if( is_single() && ( comments_open() || get_comments_number() ) ){
            comments_template( '/html/comments.php' );
        }

    }else{
        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
            the_post_thumbnail( 'thumb' );
        }
        echo '<h1><a href="'.get_the_permalink().'">'.get_the_title().'</a></h1>';
        echo apply_filters('the_excerpt', get_the_excerpt()); // the_excerpt_length( 32 );

    }

    echo '</div></div>';

  endwhile;

endif;

wp_link_pages();

wp_reset_query();

echo '</div>'; // end loopcontainer



// sidebar
if ( has_nav_menu( 'sidemenu' ) || ( function_exists('is_sidebar_active') && is_sidebar_active('sidebar') ) ){

echo '<div id="sidebar"><div class="sidebarmargin">';

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
