<?php
/**
 * Cnontent Template Part Overview Page
 * Theme custom taxonomy and post file
 */


/*
require get_stylesheet_directory() . '/assets/data_collection.php';

$artifacts = get_all_artifacts();

echo '<div id="postcontent"><div class="outermargin">';

echo '<div id="loopcontainer">';

echo json_encode( $artifacts );

echo '</div>'; // end loopcontainer

echo '</div></div>'; // end postcontent
*/





$typeparent =get_terms( 'types', array('hide_empty' => 0, 'parent' => 4 ));
$types = array();
foreach ($typeparent as $child) {
  $types[$child->slug] = $child->slug;
  $type_names[$child->slug] = $child->name;
}

$logofilterclasses = '';


echo '<div id="header">';

echo '<div id="menubar" class=""><div class="outermargin">';



echo '<div id="typemenu"><div class="innerpadding"><ul>';

  foreach ( $type_names as $slug => $type ) :

    echo '<li data-type="'.$slug.'" class="icon-button but-'.$slug.'"><span>'.$type.'</span></li>';

    $logofilterclasses .= $slug.' ';

  endforeach;

  echo '<li id="menubutton" class="but-menu icon-button"><span>info</span></li>';

echo '</ul></div></div>';

echo '<div id="navmenu"><div id="mainmenu" class="pos-default"><nav><div class="innerpadding">';
  wp_nav_menu( array( 'theme_location' => 'mainmenu' ) );
echo '</div></nav></div></div>';

echo '</div></div></div>';



echo '<div id="postcontent"><div class="outermargin">';

echo '<div id="loopcontainer">';

echo '<div id="logobox" class="post-artifact '.$logofilterclasses.'"><div class="innerpadding"><a href="'.get_home_url().'">';
echo '<img class="wp-post-image" src="https://webdesigndenhaag.net/lab/project/treasure/wp-content/uploads/2021/07/dehoekseschatkist_logo_rgb.jpg" />';
echo '</a></div></div>';



$collection_slug = 'chateau-du-lac';//get_queried_object()->slug;
$collection_name = 'Chateau du Lac';//get_queried_object()->name;

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
  $artifacts = array();
  $types_used = array();

  while($collection_posts->have_posts()) : $collection_posts->the_post();

      $type_classes = array();
      $type_count = array();
      $classes = '';
      $artID = get_the_ID();

      $media = get_attached_media( '', $artID );

      foreach($media as $element) {

        $terms = wp_get_post_terms( $element->ID, array( 'types' ) );

        foreach ( $terms as $term ) :
          $type_count[$term->slug]++;
          if( !in_array( $term->slug, $type_classes ) ){
            $type_classes[$term->slug] = $term->slug;
          }
          if( !in_array( $term->slug, $types_used ) ){
            $types_used[$term->slug] = $term->name;
          }

        endforeach;
      }
      $classes = implode(" ", $type_classes);

      $thumb_orientation = 'portrait';
      $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '');
      $image_w = $image[1];
      $image_h = $image[2];

      if ($image_w > (2.3 * $image_h) ) {
        $thumb_orientation = 'panorama';
      }else if ($image_w > $image_h) {
        $thumb_orientation = 'landscape';
      }else if ($image_w == $image_h) {
        $thumb_orientation = 'square';
      }else {
        $thumb_orientation = 'portrait';
      }

      echo '<div class="post-artifact '.$thumb_orientation.' '.$classes.'" data-id="'.$artID .'"><div class="innerpadding">';

      if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.

        echo '<img src="'.get_the_post_thumbnail_url().'" class="attachment-normal size-normal wp-post-image" alt="" loading="lazy" />';

      }

      echo '<div class="overlay">';
      echo '<h2 class="entry-title" itemprop="headline"><a href="'.get_the_permalink().'" class="entry-title-link">'.get_the_title().'</a></h2>';


      echo '<div class="item-icons"><ul>';
      foreach ( $types_used as $slug => $type ) :
        if( $type_count[$slug] != '' ){
          echo '<li data-type="'.$slug.'" class="icon-button but-'.$slug.'"><span>'.$type.'('.$type_count[$slug].')</span></li>';
        }
      endforeach;
      echo '</ul></div>';

      echo '<div class="item-excerpt">';
      echo get_the_excerpt();
      echo '</div>';


      echo '</div>';
      echo '</div></div>';

    endwhile;

endif;

wp_link_pages();

wp_reset_query();

echo '</div>'; // end loopcontainer

echo '</div></div>'; // end postcontent
