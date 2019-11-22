<?php

/**
 * [button] shortcode function
 */
function responsive_shortcodes_button_shortcode( $atts, $content = '' ) {
	$additional_atts    = '';
	$additional_classes = '';

	extract( shortcode_atts( array(
		'class'  => '',
		'color'  => '',
		'rel'    => '',
		'target' => '',
		'title'  => '',
		'url'    => '',
		'download'    => '',
	), $atts, 'button' ) );

	if ( ! $url || ! $content ) {
		return;
	}

	if ( $class ) {
		$additional_classes .= ' ' . $class;
	}

	if ( $color ) {
		$additional_classes .= ' color-' . $color;
	}

	if ( $rel ) {
		$additional_atts .= sprintf( ' rel="%s"',
			esc_attr( $rel )
		);
	}

	if ( $target ) {
		$additional_atts .= sprintf( ' target="%s"',
			esc_attr( $target )
		);
	}

	if ( $download ) {
		$additional_atts .= sprintf( ' download="%s"',
			esc_attr( $download )
		);
	}

	if ( $title ) {
		$additional_atts .= sprintf( ' title="%s"',
			esc_attr( $title )
		);
	}

	if ( ! current_theme_supports( 'rs-easy-shortcodes-responsive' ) ) {
		$content = sprintf( '<span>%s</span>', $content );
	}

	$output = sprintf( '<a class="rs-button%s" href="%s"%s>%s</a>',
		$additional_classes,
		esc_attr( $url ),
		$additional_atts,
		do_shortcode( $content )
	);

	return apply_filters( 'responsive_shortcodes_button_shortcode', $output, $atts, $content );
}
