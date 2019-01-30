<?php

/**
 * [call_to_action] shortcode function
 */
function responsive_shortcodes_call_to_action_shortcode( $atts, $content = '' ) {
	$additional_classes         = '';
	$button                     = '';
	$content_additional_classes = '';

	extract( shortcode_atts( array(
		'button_color'         => '',
		'button_icon'          => '',
		'button_icon_position' => 'right',
		'button_text'          => '',
		'button_url'           => '',
		'class'                => '',
		'color'                => '',
		'layout'               => 'horizontal',
	), $atts, 'call_to_action' ) );

	if ( ! $content ) {
		return;
	}

	$additional_classes .= ' layout-' . $layout;

	if ( ! $button_color && $color ) {
		$button_color = $color;
	}

	if ( $button_text && $button_url ) {

		if ( $button_icon && 'left' == $button_icon_position ) {
			$button_text = sprintf( '[icon id="%s"] %s',
				$button_icon,
				$button_text
			);
		} elseif ( $button_icon ) {
			$button_text = sprintf( '%s [icon id="%s"]',
				$button_text,
				$button_icon
			);
		}

		$button = do_shortcode( sprintf( '<div class="call-to-action-button%s">[button url="%s"%s]%s[/button]</div>',
			'horizontal' == $layout ? ' column column-width-one-third' : '',
			esc_attr( $button_url ),
			$button_color ? ' color="' . $button_color . '"' : '',
			$button_text
		) );
	}

	if ( $button && 'horizontal' == $layout ) {
		$additional_classes .= ' rs-columns';
	}

	if ( $class ) {
		$additional_classes .= ' ' . $class;
	}

	if ( $color ) {
		$additional_classes .= ' color-' . $color;
	}

	if ( $button && 'horizontal' == $layout ) {
		$content_additional_classes = ' column column-width-two-thirds';
	}

	$output = sprintf( '<div class="rs-call-to-action%s"><div class="call-to-action-content%s">%s</div>%s</div>',
		$additional_classes,
		$content_additional_classes,
		wpautop( do_shortcode( $content ) ),
		$button
	);

	return apply_filters( 'responsive_shortcodes_call_to_action_shortcode', $output, $atts, $content );
}
