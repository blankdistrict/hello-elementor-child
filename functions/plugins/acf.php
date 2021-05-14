<?php

// Gets the global plugin settings
global $global_acf_settings;


// Enable ACF Menu Link
if ( false === get_field( 'theme-enable_acf', 'options' ) ) {
	add_filter( 'acf/settings/show_admin', '__return_false' );
}

// Custom colors for ACF's Color Picker
add_action( 'acf/input/admin_footer', 'acf_input_admin_footer' );
function acf_input_admin_footer() {

	// Gets the global plugin settings
	global $global_acf_settings;

	$color_list = $global_acf_settings['colors'];

	if ( is_array( $color_list ) ) :

		$colors_encoded = wp_json_encode( $color_list );

		?>

		<script type="text/javascript">
			(function($) {

				// Customize color palette of Color Picker field
				acf.add_filter('color_picker_args', function( args, $field ){

					// Colors
					args.palettes = [<?php echo esc_js( $colors_encoded ); ?>]

					return args;
				});

			})(jQuery);	
		</script>

		<?php

	endif;

}

// Enables or disables the options page based on the global setting
$enable_options_page = $global_acf_settings['options-page']['enable'];

// Gets the settings for the options page
$options_page_settings = $global_acf_settings['options-page']['settings'];

// Enables and passes the settings to create the subpages. Must be an array()
$subpages = $global_acf_settings['options-page']['subpages'];

if ( function_exists( 'acf_add_options_page' ) && true === $enable_options_page && is_array( $options_page_settings ) ) {

	acf_add_options_page( $options_page_settings );

	// Checks the subpages setting is an array
	if ( is_array( $subpages ) ) {

		// Loops thru each of the subpages and creates each of them
		foreach ( $subpages as $subpage ) {

			// Checks if the subpage is an array of settings
			if ( is_array( $subpage ) ) {
				acf_add_options_sub_page( $subpage );
			}
		}
	}
}


/**
 * Retrieves a SINGLE module (clone field)
 *
 * @param string $field_name
 * @param string $module_filename
 * @param integer $post_id
 * @return mixed
 */
function acf_get_module(
	string $field_name,
	string $module_filename,
	int $post_id
) {

	// Get ACF Data which is passed to the include file
	$acf_data = get_field( $field_name, $post_id );

	// Module filepath
	$modules_dir     = get_template_directory() . '/partials/modules';
	$module_filepath = $modules_dir . '/' . $module_filename . '.php';

	// Get the module
	include $module_filepath;

}


/**
 * Retrieves MULTIPLE modules (clone fields)
 *
 * @param array $module_data
 * @return mixed
 */
function acf_get_modules( array $module_data ) {

	$modules_dir = get_template_directory() . '/partials/modules';

	$flexible_content = $module_data['flexible_content'];
	$field_prefix     = $module_data['field_prefix'];
	$modules          = $module_data['layouts'];

	if ( have_rows( $flexible_content ) ) {

		// To be used as section ID
		$section_counter = 0;

		while ( have_rows( $flexible_content ) ) {
			the_row();

			// Counter gets passed to includes
			$section_counter++;

			foreach ( $modules as $module ) {
				if ( get_row_layout() === $field_prefix . '-' . $module ) {
					$module_filename = '/' . $module . '.php';
					include $modules_dir . $module_filename;
				}
			}
		}
	}
}
