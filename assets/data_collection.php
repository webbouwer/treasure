<?php
/* data get all item data from a collection */
function get_all_artifacts(){
  $get_post_args = array(
    'post_type' => 'artifact', // Your Post type Name that You Registered
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'order' => 'ASC',
    /*'tax_query' => array(
      array(
        'taxonomy' => 'collection',
        'field' => 'slug',
        'terms' => $collection_slug
      )
    )*/
  );
  
  //.. get_post_taxonomies( $post = 0 )
  $artifact_postdata = new WP_Query($get_post_args);

  return $artifact_postdata;
}


function get_collection_artifacts( $collection_slug ){

  /**/
  if( !empty($collection_slug) && $collection_slug != ''){

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

  }

  if($collection_posts->have_posts()) :

    // media type taxonmies for each post artifact id
    $artifacts = array();
    $artifacts_html = array();
    $types_used = array();

    while($collection_posts->have_posts()) : $collection_posts->the_post();


        $type_classes = array();
        $classes = '';
        $artID = get_the_ID();

        $artifacts[$artID] = array();

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

        $artifacts[$artID]['mediatypes'] = $type_classes;
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

        $artifacts_html[$artID] .= '<div class="post-artifact '.$thumb_orientation.' '.$classes.'"><div class="innerpadding">';
        $artifacts[$artID]['thumbdisplay'] = $thumb_orientation;

        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.

          $artifacts_html[$artID] .= '<img src="'.get_the_post_thumbnail_url().'" class="attachment-normal size-normal wp-post-image" alt="" loading="lazy" />';
          $artifacts[$artID]['thumbsource'] = get_the_post_thumbnail_url();
          // ? get_the_post_thumbnail( $post->ID, 'thumbnail' ); //
          //the_post_thumbnail( 'normal' ); // 1180 px width..
        }

        $artifacts_html[$artID] .= '<div class="overlay">';
        $artifacts_html[$artID] .= '<h2 class="entry-title" itemprop="headline"><a href="'.get_the_permalink().'" class="entry-title-link">'.get_the_title().'</a></h2>';

        $artifacts[$artID]['title'] = get_the_title();
        $artifacts[$artID]['excerpt'] = get_the_excerpt();
        $artifacts[$artID]['content'] = get_the_content();
        $artifacts[$artID]['url'] = get_the_permalink();

        $mediatype = '';
        //echo '<div class="entry-excerpt">'.get_the_excerpt().'</div>';
        foreach ( $type_classes as $type ) :
          //echo '<p>'.$term->taxonomy . ': ';
          $mediatype .= $type.' ';

        endforeach;

        $artifacts_html[$artID] .= $mediatype;
        $artifacts_html[$artID] .= '</div>';

        $artifacts_html[$artID] .= '</div></div>';

      endwhile;

  endif;

  if(count($artifacts) > 0 ){
    return $artifacts;
  }else{
    return array('0', 'nothing found');
  }

  wp_link_pages();

  wp_reset_query();

}
