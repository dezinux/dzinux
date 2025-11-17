<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! isset( $content_width ) ) $content_width = 1280;

function dzinux_init() {

    add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'custom-logo', array(
		'width' => 260,
		'height' => 100,
		'flex-height' => true,
		'flex-width' => true,
	) );
	add_theme_support( 'custom-header' );
	add_theme_support( 'woocommerce' );
	add_post_type_support( 'page', 'excerpt' );
	
	register_nav_menus(
		array( 'main-menu' => __( 'Main Menu', 'dzinux' ) )
	);

	load_theme_textdomain( 'dzinux', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'dzinux_init' );

function dzinux_comment_reply() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_action( 'comment_form_before', 'dzinux_comment_reply' );

function dzinux_scripts_styles() {
	wp_enqueue_style( 'dzinux-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'dzinux_scripts_styles' );

function dzinux_login_styles() {
	wp_enqueue_style( 'dzinux-style', get_stylesheet_uri() );
}
add_action( 'login_enqueue_scripts', 'dzinux_login_styles' );

function dzinux_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
};
add_action( 'elementor/theme/register_locations', 'dzinux_register_elementor_locations' );

// Customize WordPress login page logo and link
function dzinux_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'dzinux_login_logo_url' );

function dzinux_login_logo_url_title() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'dzinux_login_logo_url_title' );

function dzinux_login_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		$logo_path = get_attached_file( $custom_logo_id );
		
		if ( $logo_url ) {
			// Get file extension to determine format
			$file_ext = strtolower( pathinfo( $logo_path, PATHINFO_EXTENSION ) );
			$is_svg = ( $file_ext === 'svg' );
			
			$logo_width = 320; // Default width
			$logo_height = 100; // Default height
			
			if ( $is_svg ) {
				// For SVG, try to get dimensions from the file
				if ( $logo_path && file_exists( $logo_path ) ) {
					$svg_content = file_get_contents( $logo_path );
					if ( $svg_content ) {
						// Try to extract width and height from SVG
						if ( preg_match( '/width=["\']?(\d+)/i', $svg_content, $width_match ) ) {
							$logo_width = intval( $width_match[1] );
						}
						if ( preg_match( '/height=["\']?(\d+)/i', $svg_content, $height_match ) ) {
							$logo_height = intval( $height_match[1] );
						}
						// If viewBox is present, use it
						if ( preg_match( '/viewBox=["\']?\s*[\d.]+\s+[\d.]+\s+([\d.]+)\s+([\d.]+)/i', $svg_content, $viewbox_match ) ) {
							$logo_width = floatval( $viewbox_match[1] );
							$logo_height = floatval( $viewbox_match[2] );
						}
					}
				}
				// For SVG, use max dimensions and let it scale
				$max_width = 320;
				$max_height = 100;
			} else {
				// For JPEG/PNG, get dimensions from attachment
				$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
				if ( $logo && $logo[1] > 0 && $logo[2] > 0 ) {
					$logo_width = $logo[1];
					$logo_height = $logo[2];
				}
				// Calculate aspect ratio and set max width/height
				$max_width = 320;
				$max_height = 100;
			}
			
			// Calculate dimensions maintaining aspect ratio
			if ( $logo_width > 0 && $logo_height > 0 ) {
				if ( $logo_width > $max_width ) {
					$ratio = $max_width / $logo_width;
					$logo_width = $max_width;
					$logo_height = $logo_height * $ratio;
				}
				if ( $logo_height > $max_height ) {
					$ratio = $max_height / $logo_height;
					$logo_height = $max_height;
					$logo_width = $logo_width * $ratio;
				}
			} else {
				// Fallback dimensions if we can't determine size
				$logo_width = $max_width;
				$logo_height = $max_height;
			}
			?>
			<style type="text/css">
				:root {
					--login-logo-url: url(<?php echo esc_url( $logo_url ); ?>);
					--login-logo-width: <?php echo absint( $logo_width ); ?>px;
					--login-logo-height: <?php echo absint( $logo_height ); ?>px;
				}
			</style>
			<?php
		}
	}
}
add_action( 'login_enqueue_scripts', 'dzinux_login_logo' );

// Replace "Thank you for creating with WordPress." with custom footer text
function dzinux_custom_admin_footer_text() {
	return sprintf(
		/* translators: %s: Link to Dezinux website */
		__( 'Theme developed by %s', 'dzinux' ),
		'<a href="https://dezinux.com" target="_blank" rel="noopener">Dezinux LLP</a>'
	);
}
add_filter( 'admin_footer_text', 'dzinux_custom_admin_footer_text' );

// Remove WordPress version from admin footer
function dzinux_remove_version_footer() {
	return '';
}
add_filter( 'update_footer', 'dzinux_remove_version_footer', 11 );

