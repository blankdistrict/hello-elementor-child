<?php

/*
	Enqueue Theme's Scripts & Styles
*/

// Loads content in the head
add_action( 'wp_head', 'enqueue_head_scripts', 1 );

// Loads content in the footer
add_action( 'wp_footer', 'enqueue_footer_scripts', 999 );

// Loads scripts with async
add_filter( 'clean_url', 'enqueue_async_scripts', 11, 1 );

// Loads the frontend scripts and styles
add_action( 'wp_enqueue_scripts', 'enqueue_site_scripts', 999 );


function enqueue_head_scripts() {
	?>

		<!-- Favicons -->
		<!-- Credit: https://realfavicongenerator.net/ -->


		<!-- Code snippet to speed up fonts rendering --> 
		<!-- <link rel='dns-prefetch' href='https://use.typekit.net' /> -->

	<?php
};

function enqueue_footer_scripts() {
	?>

	<?php
};

/**
 * Prepares all the frontend scripts and styles
 *
 * @return mixed
 */
function enqueue_site_scripts() {

	// Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	global $wp_styles;

	// ==========
	// === JS ===
	// ==========

	// Custom jQuery
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), '3.5.1', true );

	// Custom JS
	wp_enqueue_script( 'custom', get_theme_file_uri() . '/assets/js/custom.js', array( 'jquery' ), filemtime( get_theme_file_path() . '/assets/js/custom.js' ), true );

	// ===========
	// === CSS ===
	// ===========

	if ( u_is_plugin_active( 'elementor/elementor' ) ) {

		// Remove Extra CSS from Parent Theme
		// wp_dequeue_style( 'hello-elementor' );
		wp_dequeue_style( 'hello-elementor-theme-style' );

		// Custom Theme
		wp_enqueue_style( 'custom-styles', get_theme_file_uri() . '/assets/css/custom.css', array(), filemtime( get_theme_file_path() . '/assets/css/custom.css' ), 'all' );

	}
}

/**
 * Async Load Scripts (only external scripts)
 *
 * How-to: Add #asyncload at the end of the url
 *
 * Credits: https://ikreativ.com/async-with-wordpress-enqueue/
 *
 * @param string $url
 * @return string
 */
function enqueue_async_scripts( $url ) {

	if ( strpos( $url, '#asyncload' ) === false ) {
		return $url;
	} elseif ( is_admin() ) {
		return str_replace( '#asyncload', '', $url );
	} else {
		return str_replace( '#asyncload', '', $url ) . "' async='async";
	}

}
