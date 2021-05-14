<?php

// Gets the global plugin settings
global $global_acf_settings, $global_gf_settings, $global_elementor_settings, $global_rcp_settings;

$enable_acf       = isset( $global_acf_settings['enable'] ) ? $global_acf_settings['enable'] : false;
$enable_gf        = isset( $global_gf_settings['enable'] ) ? $global_gf_settings['enable'] : false;
$enable_elementor = isset( $global_elementor_settings['enable'] ) ? $global_elementor_settings['enable'] : false;
$enable_rcp       = isset( $global_rcp_settings['enable'] ) ? $global_rcp_settings['enable'] : false;

// Check if ACF is installed and active
if ( true === $enable_acf && class_exists( 'acf' ) ) {
	// Loads ACF functions
	u_get_file( 'functions/plugins/acf.php', 'require_once' );

}

// Check if Gravity Forms is installed and active
if ( true === $enable_gf && class_exists( 'GFForms' ) ) {
	// Loads Gravity Forms functions
	u_get_file( 'functions/plugins/gravity-forms.php', 'require_once' );
}

// Check the Elementor is enabled
if ( true === $enable_elementor ) {
	// Loads Gravity Forms functions
	u_get_file( 'functions/plugins/elementor.php', 'require_once' );
}
