<?php
/**
 * Customizer Additions
 *
 * @since   {{VERSION}}
 * @package PaintTrimAndMoreTheme2018
 * @subpackage PaintTrimAndMoreTheme2018/library
 */
add_action( 'customize_register', function( $wp_customize ) {
    
    // General Theme Options
    $wp_customize->add_section( 'ptam_customizer_section' , array(
            'title' => __( 'Paint Trim and More Settings', 'paint-trim-and-more-theme' ),
            'priority' => 30,
        ) 
    );
	
	$wp_customize->add_setting( 'ptam_phone_number', array(
            'default' => '(517) 740-1999',
            'transport' => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gjh_logo_image', array(
		'type' => 'text',
        'label' => __( 'Phone Number', 'paint-trim-and-more-theme' ),
        'section' => 'ptam_customizer_section',
        'settings' => 'ptam_phone_number',
    ) ) );
    
} );