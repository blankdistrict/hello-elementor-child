<?php

// Shortcode: [current_date]
add_shortcode( 'current_date', 'sc_current_date' );
function sc_current_date( $atts ) {

	if ( ! $atts ) {
		$date_params = 'Y';
		return gmdate( $date_params );
	}
}

// Shortcode: [sc_test]
add_shortcode( 'sc_test', 'sc_test' );
function sc_test( $atts ) {

	u_dd( 'Test' );

}
