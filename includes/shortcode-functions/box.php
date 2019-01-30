<?php

/**
 * [box] shortcode function
 */
function responsive_shortcodes_box_shortcode( $atts, $content = '' ) {
	$output = '';

	extract( shortcode_atts( array(
		'class' => '',
		'title' => '',
	), $atts, 'box' ) );

	if ( ! $content ) {
		return;
	}

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output .= sprintf( '<div class="rs-box%s">',
		$class
	);

		if ( $title ) {
			$output .= sprintf( '<h3 class="box-title">%s</h3>',
				$title
			);
		}

		$output .= sprintf( '<div class="box-content">%s</div>',
			wpautop( do_shortcode( $content ) )
		);

	$output .= '</div>';

	return apply_filters( 'responsive_shortcodes_box_shortcode', $output, $atts, $content );
}

