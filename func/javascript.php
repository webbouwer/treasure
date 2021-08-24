<?php

function enqueue_custom_script() {
    wp_enqueue_script( 'custom-script', get_template_directory_uri().'/assets/js/custom.js', array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_script' ); 

/*
//Localize the AJAX URL and Nonce
add_action('wp_enqueue_scripts', 'example_localize_ajax');
function example_localize_ajax(){
    wp_localize_script('jquery', 'ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('example_ajax_nonce'),
    ));
}

// Enqueue javascript script on the front end.
add_action( 'wp_enqueue_scripts', 'enqueue_ajax_script' );
// Enqueue the script on the back end (wp-admin)
add_action( 'admin_enqueue_scripts', 'enqueue_ajax_script' );

function enqueue_ajax_script() {
    wp_enqueue_script( 'ajax-script', get_template_directory_uri().'/assets/js/ajaxrequests.js', array( 'jquery' ), null, true );
    wp_localize_script( 'ajax-script', 'ajax_data', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ) );
}

*/


/* Example AJAX Function
add_action('wp_ajax_example_function', 'example_function');
add_action('wp_ajax_nopriv_example_function', 'example_function');

function example_function(){
    if ( !wp_verify_nonce($_POST['nonce'], 'example_ajax_nonce') ){
        die('Permission Denied.');
    }

    $firstname = sanitize_text_field($_POST['data']['firstname']);
    $lastname = sanitize_text_field($_POST['data']['lastname']);

    //Do something with data here
    echo $firstname . ' ' . $lastname; //Echo for response
    wp_die(); // this is required to terminate immediately and return a proper response:- https://codex.wordpress.org/AJAX_in_Plugins
}
*/
