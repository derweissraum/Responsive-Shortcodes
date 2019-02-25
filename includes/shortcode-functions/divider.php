<?php

/**
 * [divider] shortcode function
 */
function responsive_shortcodes_divider_shortcode( $atts, $content = '' ) {
	$additional_classes = '';
	$output             = '';

	extract( shortcode_atts( array(
		'class'      => '',
		'style'      => 'default',
		'color'      => 'grey',
		'text_color' => '',
	), $atts, 'divider' ) );

	if ( $class ) {
		$additional_classes .= ' ' . $class;
	}

	if ( $style ) {
		$additional_classes .= ' rs-divider-style-' . $style;
	}

	if ( $color ) {
		$additional_classes .= ' rs-divider-color-' . $color;
	}

	if ( $text_color ) {
		$additional_classes .= ' text-color-' . $text_color;
	}

	$output .= sprintf( '<div class="rs-divider%s">', $additional_classes );
	$output .= '<a href="#top">Nach oben</a></div>';

	wp_enqueue_script( 'rs-scroll' );

	return apply_filters( 'responsive_shortcodes_divider_shortcode', $output, $atts, $content );
}
