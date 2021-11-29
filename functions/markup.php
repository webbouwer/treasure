<?php

// body class slug
function add_slug_body_class( $classes ) {
  global $post;
  if(is_single()){
    if(isset( $post )){
      $classes[] = $post->post_name;
    }
    if ( 'post' == get_post_type() ) {
      $classes[] = 'article';
    }
    if( 'artifact' == get_post_type() ){
      $classes[] = 'artifact';
    }
  }	
  return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );


// Time 'ago' format
function wp_time_ago( $t ) {
  // https://codex.wordpress.org/Function_Reference/human_time_diff
  //get_the_time( 'U' )
  printf( _x( '%s '.__('geleden', 'treasure' ), '%s = human-readable time difference', 'treasure' ), human_time_diff( $t, current_time( 'timestamp' ) ) );
}
function time_post_public( $t , $display = 'ago') {
  if( $display == 'ago' ){
    echo wp_time_ago( $t );
    return;
  }
}

