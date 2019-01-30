<?php

/**
 * [tabs] shortcode function
 */
function responsive_shortcodes_tabs_shortcode( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'class' => '',
	), $atts, 'tabs' ) );

	if ( ! $content ) {
		return;
	}

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output = sprintf( '<div class="rs-tabs%s">%s</div>',
		$class,
		do_shortcode( $content )
	);

	return apply_filters( 'responsive_shortcodes_tabs_shortcode', $output, $atts, $content );
}


/**
 * [tab] shortcode function
 */
function responsive_shortcodes_tab_shortcode( $atts, $content = '' ) {
	$output = '';

	extract( shortcode_atts( array(
		'class' => '',
		'title' => '',
	), $atts, 'tab' ) );

	if ( ! $title || ! $content ) {
		return;
	}

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output .= sprintf( '<div class="tab%s">',
		$class
	);

		$output .= sprintf( '<h%1$s class="tab-title" data-tab-id="%2$s">%3$s</h%1$s>',
			RESPONSIVE_SHORTCODES_HEADING_LEVEL,
			sanitize_title( $title ),
			$title
		);

		$output .= sprintf( '<div id="tab-%s" class="tab-content">%s</div>',
			sanitize_title( $title ),
			wpautop( do_shortcode( $content ) )
		);

	$output .= '</div>';

	wp_enqueue_script( 'rs-tabs' );

	return apply_filters( 'responsive_shortcodes_tab_shortcode', $output, $atts, $content );
}
