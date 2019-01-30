<?php

/**
 * [toggle] shortcode function
 */
function responsive_shortcodes_toggle_shortcode( $atts, $content = '' ) {
	$output = '';

	extract( shortcode_atts( array(
		'class' => '',
		'title' => '',
	), $atts, 'toggle' ) );

	if ( ! $title || ! $content ) {
		return;
	}

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output .= sprintf( '<div class="rs-toggle%s">',
		$class
	);

		$output .= sprintf( '<h%1$s class="toggle-title"><a href="#toggle-%2$s"><i class="fa fa-plus icon-for-inactive"></i><i class="fa fa-minus icon-for-active"></i>%3$s</a></h%1$s>',
			RESPONSIVE_SHORTCODES_HEADING_LEVEL,
			sanitize_title( $title ),
			$title
		);

		$output .= sprintf( '<div id="toggle-%s" class="toggle-content">%s</div>',
			sanitize_title( $title ),
			wpautop( do_shortcode( $content ) )
		);

	$output .= '</div>';

	wp_enqueue_script( 'rs-toggle' );

	return apply_filters( 'responsive_shortcodes_toggle_shortcode', $output, $atts, $content );
}

