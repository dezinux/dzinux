<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! isset( $content_width ) ) $content_width = 1280;

function dezinux_init() {

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
		array( 'main-menu' => __( 'Main Menu', 'dezinux' ) )
	);

	load_theme_textdomain( 'dezinux', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'dezinux_init' );

function dezinux_comment_reply() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_action( 'comment_form_before', 'dezinux_comment_reply' );

function dezinux_scripts_styles() {
	wp_enqueue_style( 'dezinux-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'dezinux_scripts_styles' );

function dezinux_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
};
add_action( 'elementor/theme/register_locations', 'dezinux_register_elementor_locations' );



// Theme Updater
add_filter( 'pre_set_site_transient_update_themes', 'dezinux_theme_updater_check' );
add_filter( 'themes_api', 'dezinux_themes_api_override', 10, 3 );

function dezinux_get_manifest_url() {
	$default = 'https://releases.dezinux.com/themes/update.json';
	if ( defined( 'DEZINUX_UPDATE_URL' ) && DEZINUX_UPDATE_URL ) {
		return DEZINUX_UPDATE_URL;
	}
	return apply_filters( 'dezinux_update_manifest_url', $default );
}

function dezinux_fetch_update_manifest() {
	$url = dezinux_get_manifest_url();
	$response = wp_remote_get( $url, array( 'timeout' => 10 ) );
	if ( is_wp_error( $response ) ) { return null; }
	$code = wp_remote_retrieve_response_code( $response );
	if ( $code !== 200 ) { return null; }
	$body = wp_remote_retrieve_body( $response );
	$data = json_decode( $body, true );
	if ( ! is_array( $data ) ) { return null; }
	return $data;
}

function dezinux_theme_updater_check( $transient ) {
	if ( empty( $transient ) || ! is_object( $transient ) ) { return $transient; }
	$theme = wp_get_theme();
	$stylesheet = get_stylesheet();
	$current_version = $theme->get( 'Version' );
	$manifest = dezinux_fetch_update_manifest();
	if ( ! $manifest || empty( $manifest['version'] ) ) { return $transient; }
	$new_version = $manifest['version'];
	if ( version_compare( $new_version, $current_version, '>' ) ) {
		$transient->response[ $stylesheet ] = array(
			'theme'        => $stylesheet,
			'new_version'  => $new_version,
			'url'          => ! empty( $manifest['homepage'] ) ? $manifest['homepage'] : $theme->get( 'ThemeURI' ),
			'package'      => ! empty( $manifest['download_url'] ) ? $manifest['download_url'] : '',
			'requires'     => ! empty( $manifest['requires'] ) ? $manifest['requires'] : '',
			'requires_php' => ! empty( $manifest['requires_php'] ) ? $manifest['requires_php'] : '',
			'tested'       => ! empty( $manifest['tested'] ) ? $manifest['tested'] : '',
		);
	}
	return $transient;
}

function dezinux_themes_api_override( $result, $action, $args ) {
	if ( $action !== 'theme_information' ) { return $result; }
	$theme = wp_get_theme();
	$stylesheet = get_stylesheet();
	if ( empty( $args->slug ) || $args->slug !== $stylesheet ) { return $result; }
	$manifest = dezinux_fetch_update_manifest();
	if ( ! $manifest ) { return $result; }
	$sections = array();
	if ( ! empty( $manifest['changelog'] ) ) {
		$sections['changelog'] = $manifest['changelog'];
	}
	if ( ! empty( $manifest['description'] ) ) {
		$sections['description'] = $manifest['description'];
	}
	return (object) array(
		'name'          => $theme->get( 'Name' ),
		'slug'          => $stylesheet,
		'author'        => $theme->get( 'Author' ),
		'homepage'      => ! empty( $manifest['homepage'] ) ? $manifest['homepage'] : $theme->get( 'ThemeURI' ),
		'version'       => ! empty( $manifest['version'] ) ? $manifest['version'] : $theme->get( 'Version' ),
		'requires'      => ! empty( $manifest['requires'] ) ? $manifest['requires'] : $theme->get( 'RequiresWP' ),
		'requires_php'  => ! empty( $manifest['requires_php'] ) ? $manifest['requires_php'] : $theme->get( 'RequiresPHP' ),
		'tested'        => ! empty( $manifest['tested'] ) ? $manifest['tested'] : '',
		'last_updated'  => ! empty( $manifest['last_updated'] ) ? $manifest['last_updated'] : '',
		'download_link' => ! empty( $manifest['download_url'] ) ? $manifest['download_url'] : '',
		'sections'      => $sections,
	);
}
