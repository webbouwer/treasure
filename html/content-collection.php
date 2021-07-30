<?php

echo '<div id="postcontent"><div class="outermargin">';

echo '<div id="loopcontainer"><div class="innerpadding">';

//echo '<h1>Collection template</h1>';


// getCollections();
// see functions.php
//getCollectionsAndPosts();

// ==>get media from content:: https://core.trac.wordpress.org/browser/tags/5.8/src/wp-includes/media.php#L4639

$collection_slug = get_queried_object()->slug;
$collection_name = get_queried_object()->name;

echo '<h2>'.$collection_name.'</h2>';

$get_post_args = array(
  'post_type' => 'artifact', // Your Post type Name that You Registered
  'posts_per_page' => 999,
  'order' => 'ASC',
  'tax_query' => array(
    array(
      'taxonomy' => 'collection',
      'field' => 'slug',
      'terms' => $collection_slug
    )
  )
);
$collection_posts = new WP_Query($get_post_args);

if($collection_posts->have_posts()) :


  // media type taxonmies for each post artifact id
  //$artifact_media_types = array();

  while($collection_posts->have_posts()) : $collection_posts->the_post();

      //$artifact_media_types[ get_the_ID() ] = array();

      echo '<div class="post-artifact">';

      if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
        the_post_thumbnail( 'thumb' );
      }

      $media = get_attached_media( '', get_the_ID() ); //get_attached_media('image', the_ID() );
      // https://developer.wordpress.org/reference/functions/get_attached_media/
      // https://developer.wordpress.org/reference/functions/wp_get_attachment_metadata/
      // https://developer.wordpress.org/reference/hooks/get_attached_media_args/

      foreach($media as $element) {
        //echo '<img src="'.wp_get_attachment_image_src($image->ID,'full').'" />';
        //print( '<pre>' . print_r($element) .'</pre>');
        $terms = wp_get_post_terms( $element->ID, array( 'types' ) );
        foreach ( $terms as $term ) :
          echo '<p>'.$term->taxonomy . ': ';
          echo $term->slug .'</p>';
          //$artifact_media_types[ get_the_ID() ][ $term->slug ] = $term->name;
          //print( '<pre>' . print_r($term) .'</pre>');

        endforeach;
      }

      echo '<h2 class="entry-title" itemprop="headline"><a href="'.get_the_permalink().'" class="entry-title-link">'.get_the_title().'</a></h2>';
      echo '<div class="entry-excerpt">'.get_the_excerpt().'</div></div>';

    endwhile;


        /*
        // Get the current post type
        $postType = get_post_type();
        echo '<hr /><a href="' . get_post_type_archive_link($postType) . '">Visit the '.$postType.' archive</a>';
        */

endif;

wp_link_pages();

wp_reset_query();

echo '</div></div>'; // end loopcontainer


// sidebar
if ( has_nav_menu( 'sidemenu' ) || ( function_exists('is_sidebar_active') && is_sidebar_active('sidebar') ) ){

echo '<div id="sidebar"><div class="sidebarmargin">';

// sidemenu
if ( has_nav_menu( 'sidemenu' ) ){
  echo '<div id="sidemenubox"><div id="sidemenu" class="pos-default"><nav><div class="innerpadding">';
    wp_nav_menu( array( 'theme_location' => 'sidemenu' ) );
  echo '<div class="clr"></div></div></nav></div></div>';
}
// sidebar
if( function_exists('is_sidebar_active') && is_sidebar_active('sidebar') ){
  echo '<div id="sidebar_widgets"><div class="widgets_outermargin">';
    dynamic_sidebar('sidebar');
  echo '<div class="clr"></div></div></div>';
}

echo '<div class="clr"></div></div></div>';

}

echo '</div></div>'; // end postcontent
