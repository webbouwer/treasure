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
          echo '<div class="entry-cover">';
						the_post_thumbnail( 'full' );
          echo '</div>';
				}

        echo '<header class="entry-header">';
        echo '<h1><a href="'.get_the_permalink().'">'.get_the_title().'</a></h1>';
        echo '</header>';
        echo '<div class="entry-content">';
        echo apply_filters('the_content', get_the_content());
        echo '</div>';

        echo '<div class="postnavigation"><div class="alignleft">';
        previous_post_link( '%link', 'Vorige bericht:<br/> %title', true );
        echo '</div><div class="alignright">';
        next_post_link( '%link', 'Volgende bericht:<br/> %title', true );
        echo '</div></div>';

        if( is_single() && ( comments_open() || get_comments_number() ) ){
            comments_template( '/html/comments.php' );
        }

    }else{


      if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
        echo '<div class="entry-thumb">';
          the_post_thumbnail( 'large' );
        echo '</div>';
      }

      echo '<header class="entry-header">';
      echo '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
      echo '</header>';
      echo '<div class="entry-excerpt">';
      echo apply_filters('the_excerpt', get_the_excerpt()); // the_excerpt_length( 32 );
      echo '</div>';
    }

    echo '</div></div>';


  endwhile;

endif;

wp_link_pages();

wp_reset_query();

echo '</div>'; // end loopcontainer
