<?php
/**
 * Home extra meta.
 *
 * @since   1.0.0
 * @package PaintTrimAndMoreTheme2018
 * @subpackage  PaintTrimAndMoreTheme2018/library/admin/extra-meta
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_action( 'init', 'ptam_remove_home_supports' );
add_action( 'do_meta_boxes', 'ptam_remove_home_metaboxes' );
add_action( 'add_meta_boxes', 'ptam_add_home_metaboxes' );

/**
 * Determine if we're editing the Home Page
 * 
 * @since       1.0.0
 * @return      boolean Whether we're editing the Home Page or not
 */
function ptam_is_editing_home() {
    
    if ( is_admin() && 
        isset( $_REQUEST['post'] ) && 
        $_REQUEST['post'] == get_option( 'page_on_front' ) ) {
        return true;
    }
    
    return false;
    
}

/**
 * Remove Supports from the Home Page
 * 
 * @since       1.0.0
 * @return      void
 */
function ptam_remove_home_supports() {
	
	//remove_post_type_support( 'page', 'editor' );
    
}

/**
 * Needs to be called at do_meta_boxes since it is created at a different time than Supports Metaboxes
 * 
 * @since       1.0.0
 * @return      void
 */
function ptam_remove_home_metaboxes() {
    
    if ( ptam_is_editing_home() ) {
    
        // "Attributes" Meta Box
        remove_meta_box( 'pageparentdiv', 'page', 'side' );
        
    }
    
}

/**
 * Create Metaboxes for the Home Page
 * 
 * @since       1.0.0
 * @return      void
 */
function ptam_add_home_metaboxes() {
    
    if ( ptam_is_editing_home() ) {
        
    }
    
}