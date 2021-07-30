<?php
/**
 * Cnontent Template Part Overview Page
 * Theme custom taxonomy and post file
 */

$collection_slug = 'chateau-du-lac';//get_queried_object()->slug;
$collection_name = 'Chateau du Lac';//get_queried_object()->name;



//echo '<div id="pagetitlebox" class="innerpadding"><h2>'.$collection_name.'</h2></div>';
/*
echo '<div class="post-artifact landscape"><div class="innerpadding">';
echo '<img class="wp-post-image" src="https://webdesigndenhaag.net/lab/project/treasure/wp-content/uploads/2021/07/dehoekseschatkist_logo_rgb.jpg" />';
echo '</div></div>';
*/

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
      $classes = '';
      $artID = get_the_ID();

      //$artifact_media_types[ get_the_ID() ] = array();
      $media = get_attached_media( '', $artID ); //get_attached_media('image', the_ID() );

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
          if( !in_array( $term->slug, $types_used ) ){
            $types_used[$term->slug] = $term->name;
          }
          //$artifact_media_types[ get_the_ID() ][ $term->slug ] = $term->name;
          //print( '<pre>' . print_r($term) .'</pre>');

        endforeach;
      }
      $classes = implode(" ", $type_classes);
      // https://wordpress.stackexchange.com/questions/152335/orientation-of-featured-image-in-post
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

      $artifacts[$artID] .= '<div class="post-artifact '.$thumb_orientation.' '.$classes.'"><div class="innerpadding">';

      if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.

        $artifacts[$artID] .= '<img src="'.get_the_post_thumbnail_url().'" class="attachment-normal size-normal wp-post-image" alt="" loading="lazy" />';
        // ? get_the_post_thumbnail( $post->ID, 'thumbnail' ); //
        //the_post_thumbnail( 'normal' ); // 1180 px width..
      }

      $artifacts[$artID] .= '<div class="overlay">';
      $artifacts[$artID] .= '<h2 class="entry-title" itemprop="headline"><a href="'.get_the_permalink().'" class="entry-title-link">'.get_the_title().'</a></h2>';

      $mediatype = '';
      //echo '<div class="entry-excerpt">'.get_the_excerpt().'</div>';
      foreach ( $type_classes as $type ) :
        //echo '<p>'.$term->taxonomy . ': ';
        $mediatype .= $type.' ';

      endforeach;

      $artifacts[$artID] .= $mediatype;
      $artifacts[$artID] .= '</div>';

      $artifacts[$artID] .= '</div></div>';

    endwhile;



endif;

wp_link_pages();

wp_reset_query();


$logofilterclasses = '';
echo '<div id="postcontent"><div class="outermargin">';

echo '<div id="typemenu"><ul>';
foreach ( $types_used as $slug => $type ) :
  //echo '<p>'.$term->taxonomy . ': ';
  echo '<li data-type="'.$slug.'">'.$type.'</li>';
  $logofilterclasses .= $slug.' ';
endforeach;
echo '</ul></div>';


echo '<div id="loopcontainer">';

echo '<div class="post-artifact logobox '.$logofilterclasses.'"><div class="innerpadding">';
echo '<img class="wp-post-image" src="https://webdesigndenhaag.net/lab/project/treasure/wp-content/uploads/2021/07/dehoekseschatkist_logo_rgb.jpg" />';
echo '</div></div>';

  foreach ( $artifacts as $id => $content ) :
    echo $content;
  endforeach;

echo '</div>'; // end loopcontainer



echo '</div></div>'; // end postcontent
