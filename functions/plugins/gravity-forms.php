<?php


// Move Gravity Forms scripts to the footer
add_filter( 'gform_init_scripts_footer', '__return_true' );
add_filter( 'gform_cdata_open', 'gf_wrap_gform_cdata_open' );
add_filter( 'gform_cdata_close', 'gf_wrap_gform_cdata_close' );

// Append classes to submit button
add_filter( 'gform_submit_button', 'gf_add_custom_css_classes', 10, 2 );

/**
 * Move Gravity Forms scripts to the footer
 *
 * See: http://www.gravityhelp.com/documentation/gravity-forms/extending-gravity-forms/hooks/filters/gform_init_scripts_footer/
 * And:  https://bjornjohansen.no/load-gravity-forms-js-in-footer
 *
 * @param string $content
 * @return mixed
 */
function gf_wrap_gform_cdata_open( $content = '' ) {
	$content = 'document.addEventListener( "DOMContentLoaded", function() { ';
	return $content;
}
function gf_wrap_gform_cdata_close( $content = '' ) {
	$content = ' }, false );';
	return $content;
}

/**
 * Append custom CSS classes to the button
 *
 * See: https://docs.gravityforms.com/gform_submit_button/
 *
 * @param mixed $button
 * @param mixed $form
 * @return mixed
 */
function gf_add_custom_css_classes( $button, $form ) {

	$dom = new DOMDocument();
	$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
	$input    = $dom->getElementsByTagName( 'input' )->item( 0 );
	$classes  = $input->getAttribute( 'class' );
	$classes .= ' btn btn-secondary';
	$input->setAttribute( 'class', $classes );
	return $dom->saveHtml( $input );

}
