<?php
/* protago
 * customizer.php
 */

// customizer default sanitize function
function treasure_sanitize_default($obj){
    return $obj;     // todo .. empty sanitizer
}

// customizer
function treasure_customizer_init( $wp_customize ){

	// REMOVE some core theme settings first
	$wp_customize->remove_control('display_header_text');
	$wp_customize->remove_control('header_textcolor');
	$wp_customize->remove_control('background_color');
	$wp_customize->remove_panel('colors');

	$treasure_themename = get_option( 'stylesheet' );
 	$treasure_themename = preg_replace("/\W/", "_", strtolower( $treasure_themename ) );

  // add panels
  $wp_customize->add_panel('treasure_global', array(
    'title'    => __('Global', 'treasure'),
    'priority' => 10,
  ));

    // footer panel
      $wp_customize->add_panel('treasure_footer', array(
        'title'    => __('Footer', 'treasure'),
        'priority' => 20,
      ));

  // global panel
	$wp_customize->add_section('static_front_page', array(
		'title'    => __('Frontpage Type', 'treasure'),
		'panel'  => 'treasure_global',
		'priority' => 30,
	));

  // identity panel
  $wp_customize->add_section('title_tagline', array(
    'title'    => __('Identity', 'treasure'),
    'panel'  => 'treasure_global',
    'priority' => 10,
  ));

    $wp_customize->add_section('treasure_footer_content', array(
      'title'    => __('Footer content display', 'treasure'),
      'panel'  => 'treasure_footer',
      'priority' => 10,
    ));


  // identity options

 	// logo image
 	$wp_customize->add_setting( 'treasure_logo_image', array(
 		'sanitize_callback' => 'treasure_sanitize_default',
 	  'priority' => 30,
 	));
 	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'treasure_logo_image', array(
 		'label'    => __( 'Logo image', 'protago' ),
 		'section'  => 'title_tagline',
 		'settings' => 'treasure_logo_image',
 		'description' => __( 'Upload or select a logo image', 'treasure' ),
 	) ) );


  // footer panel
    $wp_customize->add_setting( 'treasure_footer_content_display' , array(
             'default' => 'display',
             'priority' => 40,
             'sanitize_callback' => 'treasure_sanitize_default',
    ));
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'treasure_footer_content_display' , array(
            'label'       => __( 'Footer display', 'treasure' ),
            'section'     => 'treasure_footer_content',
            'settings'    => 'treasure_footer_content_display' ,
            'description' => __( 'Select Footer display', 'treasure' ),
            'type'    		=> 'select',
            'choices' 		=> array(
                'display'  => __( 'Display footer', 'treasure' ),
                'hide'   => __( 'Hide - no display', 'treasure' ),
            )
    )));
     $wp_customize->add_setting( 'treasure_footer_copyrighttext' , array(
      'default' => 'Copyright 2021',
      'sanitize_callback' => 'treasure_sanitize_default',
    ));

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'treasure_footer_copyrighttext', array(
     	'label'          => __( 'Copyright text', 'treasure' ),
     	'section'        => 'treasure_footer_content',
     	'settings'       => 'treasure_footer_copyrighttext',
     	'type'           => 'textarea',
    	'description'    => __( 'Footer information text.', 'treasure' ),
    )));

}
add_action( 'customize_register', 'treasure_customizer_init' );
