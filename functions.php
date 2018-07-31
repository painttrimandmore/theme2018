<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package PaintTrimAndMoreTheme2018
 * @since FoundationPress 1.0.0
 */

$theme_header = wp_get_theme();

define( 'THEME_VER', $theme_header->get( 'Version' ) );
define( 'THEME_URL', get_stylesheet_directory_uri() );
define( 'THEME_DIR', get_stylesheet_directory() );

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Format comments */
require_once( 'library/class-foundationpress-comments.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/class-foundationpress-top-bar-walker.php' );
require_once( 'library/class-foundationpress-mobile-walker.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/responsive-images.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/class-foundationpress-protocol-relative-theme-assets.php' );

// Front Page Extra Meta
require_once( 'library/admin/extra-meta/front-page.php' );

// Customizer
require_once( 'library/customizer.php' );

function ptam_get_phone_number_link( $phone_number, $extension = false, $link_text = '', $phone_icon = false ) {
    
    $trimmed_phone_number = preg_replace( '/\D/', '', trim( $phone_number ) );
    
    if ( strlen( $trimmed_phone_number ) == 10 ) { // No Country Code
        $trimmed_phone_number = '1' . $trimmed_phone_number;
    }
    else if ( strlen( $trimmed_phone_number ) == 7 ) { // No Country or Area Code
        $trimmed_phone_number = '1616' . $trimmed_phone_number; // We'll assume 616
    }
    
    $tel_link = 'tel:' . $trimmed_phone_number;
    
    if ( $link_text == '' ) {
        
        $link_text = $phone_number;
        
        if ( ( $extension !== false ) && ( $extension !== '' ) ) {
            $link_text = $link_text . __( ' x ', 'paint-trim-and-more-theme' ) . $extension;
        }
        
    }
    
    if ( ( $extension !== false ) && ( $extension !== '' ) ) {
        $tel_link = $tel_link . ',' . $extension;
    }
    
    if ( $phone_icon ) $phone_icon = '<i class="fas fa-phone"></i> ';
    
    return "<a href='$tel_link' class='phone-number-link'>$phone_icon$link_text</a>";
    
}

function ptam_get_email_link( $email, $extension = false, $link_text = '', $email_icon = false ) {

	$trimmed_email = preg_replace( '/\D/', '', trim( $email ) );

	$email_link = 'mailto:' . $trimmed_email;

	if ( $link_text == '' ) {

		$link_text = $email;

		if ( ( $extension !== false ) && ( $extension !== '' ) ) {
			$link_text = $link_text . __( ' x ', 'paint-trim-and-more-theme' ) . $extension;
		}

	}

	if ( ( $extension !== false ) && ( $extension !== '' ) ) {
		$email_link = $email_link . ',' . $extension;
	}

	if ( $email_icon ) $email_icon = '<i class="fas fa-envelope"></i> ';

	return "<a href='{$email_link}' class='phone-number-link'>{$email_icon}{$link_text}</a>";

}


/**
 * Conditionally Add Account or Login Links to the Menu
 * 
 * @param       string $items The HTML list content for the menu items
 * @param       object $args  An object containing wp_nav_menu() arguments
 *                                                               
 * @since       {{VERSION}}
 * @return      string The HTML list content for the menu items
 */
add_filter( 'wp_nav_menu_items', 'ptam_conditional_menu_items', 10, 2 );
function ptam_conditional_menu_items( $items, $args ) {

	$items .= '<li>' . ptam_get_phone_number_link( get_theme_mod( 'ptam_phone_number', '(517) 740-1999' ), false, false, true ) . '</li>';
	$items .= '<li>' . ptam_get_email_link( get_theme_mod( 'ptam_email', 'info@painttrimmore.com' ), false, false, true ) . '</li>';

    return $items;
    
}

//add_filter( 'do_shortcode_tag', 'ptam_force_equalize_gallery', 10, 4 );
/**
 * Force [gallery] to use Equalizer
 * 
 * @param		string $output HTML
 * @param		string $tag    Shortcode Tag
 * @param		array  $attr   Set Shortcode Atts (Does not include defaults or otherwise calculated ones)
 * @param		object $m      ¯\_(ツ)_/¯ Ask WP Core
 *                                         
 * @since		{{VERSION}}
 * @return		string Shortcode HTML
 */
function ptam_force_equalize_gallery( $output, $tag, $attr, $m ) {
	
	if ( $tag !== 'gallery' ) return $output;
	
	$output = preg_replace( "#(<div)(.*?)(class='gallery )(.*?)(>)#is", '$1$2$3$4 data-equalizer data-equalize-on="medium"$5', $output );
	
	$output = preg_replace( '#(<figure)(.*?)(>)#is', "$1$2 data-equalizer-watch$3", $output );
	
	return $output;
	
}

add_filter( 'post_gallery', 'ptam_foundation_gallery', 10, 2 );
function ptam_foundation_gallery( $output, $attr ) {
	
	global $post;
	
	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );
	
	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$columns = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";
	
	ob_start();

	$gallery_style = '';

	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}
	
	echo apply_filters( 'gallery_style', $gallery_style );
	
	$size_class = sanitize_html_class( $atts['size'] );
	
	?>

	<div id="<?php echo $selector; ?>" class="gallery galleryid-<?php echo $id; ?> gallery-columns-<?php echo $columns; ?> gallery-size-<?php echo $size_class; ?> row small-up-2 medium-up-<?php echo $columns; ?>">

	<?php foreach ( $attachments as $id => $attachment ) : 
	
		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}
		$image_meta  = wp_get_attachment_metadata( $id );
	
		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}
	
		$img     = wp_get_attachment_image_src( $id, $atts['size'] );
		$img_big = wp_get_attachment_image_src( $id, 'full' );

		$caption = ( ! $attachment->post_excerpt ) ? '' : ' data-caption="' . esc_attr( $attachment->post_excerpt ) . '" ';
	
		?>

		<div class="column column-block">
			<figure class="gallery-item">
			
				<div class="gallery-icon <?php echo $orientation; ?>">
					<?php echo $image_output; ?>
				</div>
				
				<?php if ( trim( $attachment->post_excerpt ) ) : ?>

				<figcaption class="wp-caption-text gallery-caption" id="<?php echo "$selector-$id"; ?>">
					<?php echo wptexturize( $attachment->post_excerpt ); ?>
				</figcaption>

				<?php endif; ?>
				
			</figure>
		</div>

	<?php endforeach; ?>

	</div>

	<?php 
	
	$output = ob_get_clean();

	return $output;
	
}