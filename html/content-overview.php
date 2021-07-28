<?php
/**
 * Cnontent Template Part Overview Page
 * Theme custom taxonomy and post file
 */

$collection_slug = 'example-top-collection';//get_queried_object()->slug;
$collection_name = 'Example collectie';//get_queried_object()->name;

echo '<div id="postcontent"><div class="outermargin">';


echo '<div id="loopcontainer">';


echo '<div id="pagetitlebox" class="innerpadding"><h2>'.$collection_name.'</h2></div>';

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

  while($collection_posts->have_posts()) : $collection_posts->the_post();

      //$artifact_media_types[ get_the_ID() ] = array();
      $media = get_attached_media( '', get_the_ID() ); //get_attached_media('image', the_ID() );

      $type_classes = array();
      $classes = '';

      foreach($media as $element) {
        //echo '<img src="'.wp_get_attachment_image_src($image->ID,'full').'" />';
        //print( '<pre>' . print_r($element) .'</pre>');
        $terms = wp_get_post_terms( $element->ID, array( 'types' ) );

        foreach ( $terms as $term ) :
          //echo '<p>'.$term->taxonomy . ': ';
          //echo $term->slug .'</p>';
          if( !in_array( $term->slug, $type_classes ) ){
            $type_classes[$term->slug] = $term->slug;
          }
          //$artifact_media_types[ get_the_ID() ][ $term->slug ] = $term->name;
          //print( '<pre>' . print_r($term) .'</pre>');

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

      echo '<div class="post-artifact '.$thumb_orientation.' '.$classes.'"><div class="innerpadding">';

      if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
        the_post_thumbnail( 'normal' ); // 1180 px width..
      }

      echo '<div class="overlay">';
      echo '<h2 class="entry-title" itemprop="headline"><a href="'.get_the_permalink().'" class="entry-title-link">'.get_the_title().'</a></h2>';

      //echo '<div class="entry-excerpt">'.get_the_excerpt().'</div>';
      foreach ( $type_classes as $type ) :
        //echo '<p>'.$term->taxonomy . ': ';
        echo $type.' ';

      endforeach;

      echo '</div>';

      echo '</div></div>';

    endwhile;

endif;

wp_link_pages();

wp_reset_query();

echo '</div>'; // end loopcontainer

echo '</div></div>'; // end postcontent