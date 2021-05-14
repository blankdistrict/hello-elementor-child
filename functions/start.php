<?php

// Fire all our initial functions at the start
add_action( 'after_setup_theme', 'start_theme_setup' );

function start_theme_setup() {

	global $global_enable_post_format_support, $global_enable_gutenberg;

	// =========================
	// FUNCTIONS & THEME SUPPORT
	// =========================

	// Adds WP Thumbnail Support
	add_theme_support( 'post-thumbnails' );

	// Enables Custom Logo
	add_theme_support( 'custom-logo' );

	// Adds RSS Support
	add_theme_support( 'automatic-feed-links' );

	// Adds Support for WP Controlled Title Tag
	add_theme_support( 'title-tag' );

	// Enables Selective Refresh for Widgets within the Customizer
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Adds support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Adds HTML5 Support
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			// Removes the "type" attribute in script and style tags since HTML5 doesn't require it
			'script',
			'style',
		)
	);

	if ( true === $global_enable_post_format_support ) {

		// Adds post format support
		add_theme_support(
			'post-formats',
			array(
				'aside', // title less blurb
				'gallery', // gallery of images
				'link', // quick link to other site
				'image', // an image
				'quote', // a quick quote
				'status', // a Facebook like status update
				'video', // video
				'audio', // audio
				'chat', // chat transcript
			)
		);
	}

	if ( true === $global_enable_gutenberg ) {
		// Add Editor Styles for Gutenberg
		add_theme_support( 'editor-styles' );
		// Enqueue the styles the editor
		add_editor_style( 'style-editor.css' );
		// Enable align full and align wide to block editor
		add_theme_support( 'align-wide' );
	} else {
		// Deactivates Gutenberg without need for a plugin!
		add_filter( 'use_block_editor_for_post', '__return_false' );
		add_filter( 'use_block_editor_for_post_type', '__return_false' );
		// Removes all the Gutenberg scripts
		add_action( 'wp_enqueue_scripts', 'start_remove_wp_block_library_css', 100 );
	}

	// Adds excerpt to pages
	add_post_type_support( 'page', 'excerpt' );

	// Sets the maximum allowed width for any content in the theme, like oEmbeds and images added to posts.
	$GLOBALS['content_width'] = apply_filters( 'start_theme_support', 1500 );

	// =======================
	// WP HEAD CLEANUP & FIXES
	// =======================

	// Removes category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// Removes post and comment feeds
	remove_action( 'wp_head', 'feed_links', 2 );

	// Removes EditURI link
	remove_action( 'wp_head', 'rsd_link' );

	// Removes Windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Removes index link
	remove_action( 'wp_head', 'index_rel_link' );

	// Removes WP version
	remove_action( 'wp_head', 'wp_generator' );

	// Disables JSON REST API
	// remove_action( 'wp_head', 'rest_output_link_wp_head' );
	// remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	// remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
	// remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );

	// Removes previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

	// Removes start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

	// Removes links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

	// All actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// Disables TinyMCE emojis option
	add_filter( 'tiny_mce_plugins', 'start_disable_emoji_tinymce' );

	// Cleans up comment styles in the head
	add_action( 'wp_head', 'start_remove_recent_comments_style', 1 );

	// Removes pesky injected css for recent comments widget
	add_filter( 'wp_head', 'start_remove_wp_widget_recent_comments_style', 1 );

	// Cleans up gallery output
	add_filter( 'gallery_style', 'start_remove_gallery_style' );

	// Cleans up excerpt
	add_filter( 'excerpt_more', 'start_replace_excerpt_more' );

	// Replaces the .sticky class for sticky posts with the .wp-sticky class instead
	add_filter( 'post_class', 'start_replace_sticky_class' );

	// Removes JetPack injected ads from WC 3.6
	add_filter( 'jetpack_show_promotions', '__return_false' );

	// Removes WC injected ads from WC 3.6:
	add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );

}

/**
 * Remove Gutenberg Block Library CSS from loading on the frontend
 *
 * @return mixed
 */
function start_remove_wp_block_library_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
}

/**
 * Removes styles from recent comments widget in the head
 *
 * @return void
 */
function start_remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}

/**
 * Removes recent comments widget style from the head
 *
 * @return void
 */
function start_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

/**
 * Disables the TinyMCE emojis option
 *
 * @param array $plugins
 * @return array
 */
function start_disable_emoji_tinymce( array $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Removes injected CSS from gallery element
 *
 * @param mixed $css
 * @return mixed
 */
function start_remove_gallery_style( $css ) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

/**
 * Changes the annoying ellipsis at the end of the post summary to a 'Read More' link
 *
 * @param mixed $more
 * @return mixed
 */
function start_replace_excerpt_more( $more ) {
	global $post;
	// edit here if you like
	return null;
}

/**
 * Replaces the .sticky class for sticky posts with the .wp-sticky class instead
 *
 * @param array $classes
 * @return array
 */
function start_replace_sticky_class( array $classes ) {
	if ( in_array( 'sticky', $classes, true ) ) {
		$classes   = array_diff( $classes, array( 'sticky' ) );
		$classes[] = 'wp-sticky';
	}

	return $classes;
}
