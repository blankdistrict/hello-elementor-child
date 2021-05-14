<?php

/**
 * Var dumper w/ pre option
 *
 * @param mixed $var
 * @param boolean $preformatted
 * @return mixed
 */
function u_dd(
	$var = null,
	bool $preformatted = true
) {
	if ( ! empty( $var ) && true === $preformatted ) {

		echo '<pre>';
		var_dump( $var ); // phpcs:ignore
		echo '</pre>';

	} elseif ( ! empty( $var ) && false === $preformatted ) {

		var_dump( $var ); // phpcs:ignore

	}
}

/**
 * Converts dashes in string to Camel Case
 *
 * @param string $string
 * @param boolean $capitalize_first_character
 * - Whether to capitalize the first character in the string or not
 * @return string
 */
function u_dashes_to_camel_case(
	string $string,
	bool $capitalize_first_character = false
) {

	$str = str_replace( ' ', '', ucwords( str_replace( '-', ' ', $string ) ) );

	if ( ! $capitalize_first_character ) {
		$str[0] = strtolower( $str[0] );
	}

	return $str;
}

/**
 * Gets full path of file. Defaults to current file.
 *
 * @param string $filename
 * @return string
 */
function u_get_file_uri( string $filename ) {

	if ( ! empty( $filename ) && is_string( $filename ) ) {

		$file_uri = dirname( $filename ) . '/' . basename( $filename );

		return esc_html( $file_uri );

	}
}

/**
 * Returns the path to the assets folder
 *
 * @param string $filename
 * @return string
 */
function u_get_assets_uri( string $filename = '' ) {

	$assets_path = get_theme_file_uri() . '/assets/' . $filename;

	return $assets_path;

}

/**
 * Loads a file based on filename and passes extra data to it
 *
 * @param string $filename
 * Filename including extension. Avoid slash before path name.
 * @param string $fetching
 * How the file will be fetched.
 * @param mixed $extra_data
 * Additional data to pass to the file
 * @return mixed
 * File that is to be loaded
 */
function u_get_file(
	string $filename = '',
	string $fetching = 'include_once',
	$extra_data = null
) {

	$filename = is_string( $filename ) ? get_theme_file_path() . '/' . $filename : null;

	// To pass data from where it's been called
	$extra_data = $extra_data;

	if ( file_exists( $filename ) && ! is_null( $filename ) ) {

		if ( 'include' === $fetching ) :
			include $filename;

		elseif ( 'include_once' === $fetching ) :
			include_once $filename;

		elseif ( 'require' === $fetching ) :
			require $filename;

		elseif ( 'require_once' === $fetching ) :
			require_once $filename;

		endif;

	}

}

// Checks to see if plugin is active
function u_is_plugin_active( $plugin_path ) {
	$return_var = in_array( $plugin_path . '.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	return $return_var;
}
