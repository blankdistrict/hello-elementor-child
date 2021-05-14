<?php

// Disable default dashboard widgets
add_action( 'admin_menu', 'admin_disable_default_dashboard_widgets' );

// Custom Backend Footer
add_filter( 'admin_footer_text', 'admin_custom_admin_footer' );

// Reorder Admin Menu Links
// add_filter( 'custom_menu_order', 'admin_custom_menu_order', 10, 1 );
// add_filter( 'menu_order', 'admin_custom_menu_order', 10, 1 );

// Register a new dashboard widget
// add_action( 'wp_dashboard_setup', 'admin_add_dashboard_widgets' );


/**
 * Disable default dashboard widgets
 *
 * @return void
 */
function admin_disable_default_dashboard_widgets() {
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
	Remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );     // Quick Press Widget
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
}

/**
 * Custom Backend Footer
 *
 * @return string
 */
function admin_custom_admin_footer() {
	return '<span id="footer-thankyou">Site developed by <a href="https://help.olivestreetdesign.com" target="_blank">Olive Street Design</a></span>';
}

/**
 * Reorder Admin Menu links
 *
 * @param mixed $menu_ord
 * @return array
 */
function admin_custom_menu_order( $menu_ord ) {

	if ( ! $menu_ord ) {
		return true;
	}

	return array(
		'index.php',                          // Dashboard
		'edit.php?post_type=acf-field-group', // ACF Custom Fields
		'theme-general-settings',             // Theme Settings
		'woocommerce',                        // WooCommerce
		'edit.php?post_type=product',         // WC Products
		'upload.php',                         // Media
		'separator1',                         // First separator
		'edit.php?post_type=page',            // Pages
		'edit.php',                           // Posts
		'link-manager.php',                   // Links
		'edit-comments.php',                  // Comments
		'separator2',                         // Second separator
		'themes.php',                         // Appearance
		'plugins.php',                        // Plugins
		'tools.php',                          // Tools
		'users.php',                          // Users
		'options-general.php',                // Settings
		'separator-last',                     // Last separator
	);
}

/**
 * Adds a metabox to the dashboard widgets area
 *
 * @return mixed
 */
function admin_add_dashboard_widgets() {
	add_meta_box( 'id', 'News & Support', 'admin_dashboard_widget_callback', 'dashboard', 'side', 'high' );
}

/**
 * Outputs the contents of the dashboard widget from an external source
 *
 * Notes:
 * - BETA VERSION! Use at your own risk
 * - Needs to be checked for security holes
 * @param mixed $post
 * @param array $callback_args
 * @return void
 */
function admin_dashboard_widget_callback( $post, $callback_args ) {
	echo '
	<div id="custom-widget"></div>
	<script>
		jQuery( function($) {
			$( document ).ready( function() {
				$( "#custom-widget" ).load( "https://url.com/filename.php", function( responseTxt, statusTxt, xhr ) {
					if( "success" === statusTxt )
						$(this).html();
				});
			});
		});
	</script>
	';
}
