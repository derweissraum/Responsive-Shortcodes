<?php

/**
 * [music] shortcode function
 */
function responsive_shortcodes_music_shortcode( $atts, $content = '' ) {
	$output = '';

	extract( shortcode_atts( array(
		'class' => '',
		'title' => '',
	), $atts, 'boxmusic' ) );

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
			$output .= sprintf( '<h3 class="box-title-music"><i class="fa fa-music" aria-hidden="true"></i> %s</h3>',
				$title
			);
		}

		$output .= sprintf( '<div class="box-content-music">%s</div>',
			wpautop( do_shortcode( $content ) )
		);

	$output .= '</div>';

	return apply_filters( 'responsive_shortcodes_music_shortcode', $output, $atts, $content );
}

