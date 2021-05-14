<?php

// Prevent direct access through URL
if ( ! defined( 'ABSPATH' ) ) :
	exit;

else :

	/**
	 * Gets the functions directory path
	 * @var string $functions_directory
	 */
	$functions_directory = get_theme_file_path() . '/functions/';

	/**
	 * Array of functions by filename that will bo loaded
	 * @var array $function_files
	 * - No .php extension is needed
	 * - Order is important
	 * - Comment out if not needed
	 */
	$function_files = array(
		'settings',   // Theme settings (always load first!)
		'utilities',  // Theme utilities (always load second!)
		'start',      // Theme setup and clean up
		'enhance',    // Custom functions that extend default WP functionality
		'enqueue',    // Register scripts and stylesheets
		'admin-area', // Customize the WordPress admin area
		'shortcodes', // Register custom shortcodes
		'plugins',    // Functions for the different plugins being used
	);

	// Loop thru each filename in array
	foreach ( $function_files as $function_file ) {

		// Function path
		$function = $functions_directory . $function_file . '.php';

		// Check if file exists
		if ( file_exists( $function ) ) {

			// Load the function file
			require $function;

		} elseif ( 'dev' === $global_theme_environment ) {

			echo 'Missing the file: <b>' . esc_html( $function ) . '</b>';
			echo '<br><br>';

		}
	}

endif;
