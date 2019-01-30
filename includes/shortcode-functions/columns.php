<?php

/**
 * [columns] shortcode function
 */
function responsive_shortcodes_columns_shortcode( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'class' => '',
	), $atts, 'columns' ) );

	if ( ! $content ) {
		return;
	}

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output = sprintf( '<div class="rs-columns%s">%s</div>',
		$class,
		do_shortcode( $content )
	);

	return apply_filters( 'responsive_shortcodes_columns_shortcode', $output, $atts, $content );
}


/**
 * [column] shortcode function
 */
function responsive_shortcodes_column_shortcode( $atts, $content = '' ) {
	$output = '';

	extract( shortcode_atts( array(
		'class' => '',
		'width' => 'one-fourth',
	), $atts, 'column' ) );

	if ( ! $content ) {
		return;
	}

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output .= sprintf( '<div class="column column-width-%s%s">',
		$width,
		$class
	);

		$output .= wpautop( do_shortcode( $content ) );

	$output .= '</div>';

	return apply_filters( 'responsive_shortcodes_column_shortcode', $output, $atts, $content );
}
