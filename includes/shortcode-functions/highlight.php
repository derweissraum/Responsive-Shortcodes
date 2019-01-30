<?php

/**
 * [highlight] shortcode function
 */
function responsive_shortcodes_highlight_shortcode( $atts, $content = '' ) {
	$additional_classes = '';
	$output             = '';

	extract( shortcode_atts( array(
		'class'      => '',
		'color'      => 'yellow',
		'text_color' => '',
	), $atts, 'highlight' ) );

	if ( ! $content ) {
		return;
	}

	if ( $class ) {
		$additional_classes .= ' ' . $class;
	}

	if ( $color ) {
		$additional_classes .= ' color-' . $color;
	}

	if ( $text_color ) {
		$additional_classes .= ' text-color-' . $text_color;
	}

	$output .= sprintf( '<span class="rs-highlight%s">', $additional_classes );
	$output .= do_shortcode( $content );
	$output .= '</span>';

	return apply_filters( 'responsive_shortcodes_highlight_shortcode', $output, $atts, $content );
}
