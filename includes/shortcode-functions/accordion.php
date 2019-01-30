<?php

/**
 * [accordion] shortcode function
 */
function responsive_shortcodes_accordion_shortcode( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'class' => '',
	), $atts, 'accordion' ) );

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output = sprintf( '<div class="rs-accordion%s">%s</div>',
		$class,
		do_shortcode( $content )
	);

	return apply_filters( 'responsive_shortcodes_accordion_shortcode', $output, $atts, $content );
}


/**
 * [accordion_item] shortcode function
 */
function responsive_shortcodes_accordion_item_shortcode( $atts, $content = '' ) {
	$output = '';

	extract( shortcode_atts( array(
		'class' => '',
		'title' => '',
	), $atts, 'accordion_item' ) );

	if ( ! $title && ! $content ) {
		return;
	}

	if ( $class ) {
		$class = ' ' . $class;
	}

	$output .= sprintf( '<div class="accordion-item%s">',
		$class
	);

		$output .= sprintf( '<h%1$s class="accordion-item-title"><a href="#accordion-item-%2$s"><i class="fa fa-plus icon-for-inactive"></i><i class="fa fa-minus icon-for-active"></i>%3$s</a></h%1$s>',
			RESPONSIVE_SHORTCODES_HEADING_LEVEL,
			sanitize_title( $title ),
			$title
		);

		$output .= sprintf( '<div id="accordion-item-%s" class="accordion-item-content">%s</div>',
			sanitize_title( $title ),
			wpautop( do_shortcode( $content ) )
		);

	$output .= '</div>';

	wp_enqueue_script( 'rs-accordion' );

	return apply_filters( 'responsive_shortcodes_accordion_item_shortcode', $output, $atts, $content );
}
