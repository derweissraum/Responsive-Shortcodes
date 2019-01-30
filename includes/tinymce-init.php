<?php

function responsive_shortcodes_tinymce_init() {

	if ( ! current_user_can( 'edit_pages' ) && ! current_user_can( 'edit_posts' ) ) {
		return;
	}

	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'responsive_shortcodes_add_mce_plugin' );
		add_filter( 'mce_buttons',          'responsive_shortcodes_register_mce_button' );
	}

}
add_action( 'admin_head', 'responsive_shortcodes_tinymce_init' );


function responsive_shortcodes_add_mce_plugin( $plugins ) {

	$plugins['responsive_shortcodes_button'] = RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL . 'js/tinymce-button.js';

	return $plugins;
}


function responsive_shortcodes_register_mce_button( $buttons ) {

	$buttons[] = 'responsive_shortcodes_button';

	return $buttons;
}


function responsive_shortcodes_enqueue_tinymce_css() {
	global $pagenow;

	if ( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) {
		wp_enqueue_style( 'responsive_shortcodes_tinymce', RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL . 'css/tinymce-button.css', array(), RESPONSIVE_SHORTCODES_VERSION );
	}
}
add_action( 'admin_enqueue_scripts', 'responsive_shortcodes_enqueue_tinymce_css' );
