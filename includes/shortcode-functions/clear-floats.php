<?php

/**
 * [clear_floats] shortcode function
 */
function responsive_shortcodes_clear_floats_shortcode( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'class' => '',
	), $atts, 'clear_floats' ) );

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output = sprintf( '<div class="rs-clear-floats%s"></div>',
		$class
	);

	return apply_filters( 'responsive_shortcodes_clear_floats', $output, $atts, $content );
}
