<?php

/**
 * [video] shortcode function
 */
function responsive_shortcodes_video_shortcode( $atts, $content = '' ) {
	$output = '';

	extract( shortcode_atts( array(
		'class' => '',
		'title' => '',
	), $atts, 'boxvideo' ) );

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
			$output .= sprintf( '<h3 class="box-title-video"><i class="fa fa-play" aria-hidden="true"></i> %s</h3>',
				$title
			);
		}

		$output .= sprintf( '<div class="box-content-video">%s</div>',
			wpautop( do_shortcode( $content ) )
		);

	$output .= '</div>';

	return apply_filters( 'responsive_shortcodes_video_shortcode', $output, $atts, $content );
}

