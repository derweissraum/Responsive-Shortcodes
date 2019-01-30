<?php

/**
 * [alert] shortcode function
 */
function responsive_shortcodes_alert_shortcode( $atts, $content = '' ) {
	$additional_classes = '';
	$output             = '';

	extract( shortcode_atts( array(
		'class' => '',
		'color' => 'yellow',
		'icon'  => '',
	), $atts, 'alert' ) );

	if ( ! $content ) {
		return;
	}

	if ( $class ) {
		$additional_classes .= ' ' . $class;
	}

	if ( $color ) {
		$additional_classes .= ' color-' . $color;
	}

	if ( $icon ) {
		$additional_classes .= ' has-icon';
	}

	$output .= sprintf( '<div class="rs-alert%s">', $additional_classes );

		if ( $icon ) {
			$output .= sprintf( '<i class="fa fa-%s"></i>', $icon );
		}

		$output .= '<div class="alert-content">' . wpautop( do_shortcode( $content ) ) . '</div>';

	$output .= '</div>';

	return apply_filters( 'responsive_shortcodes_alert_shortcode', $output, $atts, $content );
}
