<?php
/**
 * Plugin Name: Responsive Shortcodes
 * Plugin URI:  https://docs.der-weissraum.de/docs/responsive-shortcodes/
 * Description: Bietet eine Reihe von benutzerfreundlichen Shortodes zum Erstellen von Spalten, Schaltflächen, Registerkarten und mehr.
 * Author:      der weissraum - Studio für Gestaltung
 * Author URI:  https://www.der-weissraum.de
 * Version:     1.0.4
 * Text Domain: responsive-shortcodes
 * Domain Path: /languages
 *
 *
 * Copyright (C) 2018 der-weissraum
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

// Plugin Updater
add_filter('plugins_api', 'responsive_shortcodes_plugin_info', 20, 3);
/*
 * $res empty at this step 
 * $action 'plugin_information'
 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
 */	
function responsive_shortcodes_plugin_info( $res, $action, $args ){
 
	// do nothing if this is not about getting plugin information
	if( $action !== 'plugin_information' )
		return false;
 
	// do nothing if it is not our plugin	
	if( 'responsive-shortcodes' !== $args->slug )
		return false;
 
	// trying to get from cache first, to disable cache comment 25,35,36,37,39
	if( false == $remote = get_transient( 'dw_upgrade_responsive-shortcode-updater' ) ) {
 
		// info.json is the file with the actual plugin information on your server
		$remote = wp_remote_get( 'https://docs.der-weissraum.de/updates/responsive-shortcodes/info.json', array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);
 
		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'dw_upgrade_responsive-shortcode-updater', $remote, 43200 ); // 12 hours cache
		}
 
	}
 
	if( $remote ) {
 
		$remote = json_decode( $remote['body'] );
		$res = new stdClass();
		$res->name = $remote->name;
		$res->slug = 'responsive-shortcodes';
		$res->version = $remote->version;
		$res->tested = $remote->tested;
		$res->requires = $remote->requires;
		$res->author = '<a href="https://www.der-weissraum.de">der weissraum - Studio für Gestaltungs</a>';
		$res->author_profile = 'https://profiles.wordpress.org/rudrastyh';
		$res->download_link = $remote->download_url;
		$res->trunk = $remote->download_url;
		$res->last_updated = $remote->last_updated;
		$res->sections = array(
			'description' => $remote->sections->description,
			'installation' => $remote->sections->installation,
			'changelog' => $remote->sections->changelog
			// you can add your custom sections (tabs) here 
		);
		if( !empty( $remote->sections->screenshots ) ) {
			$res->sections['screenshots'] = $remote->sections->screenshots;
		}
 
		$res->banners = array(
		 'low' => 'https://docs.der-weissraum.de/updates/responsive-shortcodes/banner-772x250.png',
         'high' => 'https://docs.der-weissraum.de/updates/responsive-shortcodes/banner-1544x500.png'
		);
           	return $res;
 
	}
 
	return false;
 
}
add_filter('site_transient_update_plugins', 'responsive_shortcodes_push_update' );
 
function responsive_shortcodes_push_update( $transient ){
 
	if ( empty($transient->checked ) ) {
            return $transient;
        }
 
	// trying to get from cache first, to disable cache comment 86,96,97,98,100
	if( false == $remote = get_transient( 'dw_upgrade_responsive-shortcode-updater' ) ) {
 
		// info.json is the file with the actual plugin information on your server
		$remote = wp_remote_get( 'https://docs.der-weissraum.de/updates/responsive-shortcodes/info.json', array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);
 
		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'dw_upgrade_responsive-shortcode-updater', $remote, 43200 ); // 12 hours cache
		}
 
	}
 
	if( $remote ) {
 
		$remote = json_decode( $remote['body'] );
		if( $remote && version_compare( '1.0.4', $remote->version, '<' )
			&& version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
				$res = new stdClass();
				$res->slug = 'responsive-shortcodes';
				$res->plugin = 'responsive-shortcodes/responsive-shortcodes.php';
				$res->new_version = $remote->version;
				$res->tested = $remote->tested;
				$res->package = $remote->download_url;
				$res->url = $remote->homepage;
				$res->compatibility = new stdClass();
           		$transient->response[$res->plugin] = $res;
           		//$transient->checked[$res->plugin] = $remote->version;
           	}
 
	}
        return $transient;
}

add_action( 'upgrader_process_complete', 'responsive_shortcodes_after_update', 10, 2 );
 
function responsive_shortcodes_after_update( $upgrader_object, $options ) {
	if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
		delete_transient( 'dw_upgrade_responsive-shortcode-updater' );
	}
}

// Shows the View details Link
add_filter('plugin_row_meta', function($plugin_meta, $pluginFile) {
    //Only modify our own plugin.
    if (plugin_basename(__FILE__) === $pluginFile) {

        //This should refer to the variable holding your PUC-instance
        global $myUpdateChecker;

        //Check if the details link is already among the links (because there is an update)
        foreach ($plugin_meta as $existing_link) {
            if (strpos($existing_link, 'tab=plugin-information') !== false) {
                return $plugin_meta;
            }
        }

        //Get plugin info (need the name to mirror WP's own method)
        $plugin_info = get_plugin_data(__FILE__);

        //Show the link using the same method WP does (which is totally overkill)
        $plugin_meta[] = sprintf( '<a href="%s" class="thickbox open-plugin-details-modal" aria-label="%s" data-title="%s">%s</a>',
                esc_url( network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=responsive-shortcodes&TB_iframe=true&width=600&height=550' ) ),
                esc_attr( sprintf( __( 'More information about %s' ), $plugin_info['Name'] ) ),
                esc_attr( $plugin_info['Name'] ),
                __( 'View details' )
        );
    }
    return $plugin_meta;
}, 10, 2);


/**
 * Define plugin constants
 */

// Define the heading level for the shortcodes that use headings.
define( 'RESPONSIVE_SHORTCODES_HEADING_LEVEL', 3 );

// Plugin directory path and URL.
define( 'RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH', dirname( __FILE__ ) );
define( 'RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL',  plugin_dir_url( __FILE__ ) );

// Plugin version. WordPress, please provide a way to get this automatically on the frontend!!!
define( 'RESPONSIVE_SHORTCODES_VERSION', '1.0.4' );


/**
 * Load includes
 */
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/tinymce-init.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/music.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/video.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/accordion.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/alert.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/box.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/button.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/call-to-action.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/clear-floats.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/divider.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/columns.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/highlight.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/icon.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/tabs.php' );
require( RESPONSIVE_SHORTCODES_PLUGIN_DIR_PATH . '/includes/shortcode-functions/toggle.php' );


/**
 * Registers the plugin actions, filters, and shortcodes.
 */
function responsive_shortcodes_init() {

	// Enqueue scripts and styles.
	add_action( 'wp_enqueue_scripts', 'responsive_shortcodes_enqueue_scripts', 1 );

	// Process shortcodes in the_content early, to avoid having wpautop() mess up the formatting.
	add_filter( 'the_content', 'responsive_shortcodes_process_shortcodes', 7 );

	// Process shortcodes in text widgets
	add_filter( 'widget_text', 'do_shortcode' );

	// Register shortcodes.
	foreach( responsive_shortcodes_get_shortcodes() as $shortcode_name => $shortcode_function ) {
		add_shortcode( $shortcode_name, $shortcode_function );
	}

	// Disable the CSS class prefix if used in a theme that declares support for the plugin.
	if ( current_theme_supports( 'rs-responsive-shortcodes' ) ) {
		define( 'RESPONSIVE_SHORTCODES_CLASS_PREFIX', null );
	}

	// Container zu eingebetteten Videos hinzufügen
	function rs_embed_html( $html ) {
	return '<div class="video-block">' . $html . '</div>';
	}
	add_filter( 'embed_oembed_html', 'rs_embed_html', 10, 3 );
	add_filter( 'video_embed_html', 'rs_embed_html' ); // für Jetpack

	// Add Media Player Styles
	add_action( 'wp_footer', 'esr_theme_footer_scripts' );

	function esr_theme_footer_scripts() {
		if ( wp_style_is( 'wp-mediaelement', 'enqueued' ) ) {
			wp_enqueue_style( 'my-theme-player', RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL . 'css/rs-wp-media-player.min.css', array(
				'wp-mediaelement',
			), '1.0' );
		}
	}

/**
* Add an HTML class to MediaElement.js container elements to aid styling.
*
* Extends the core _wpmejsSettings object to add a new feature via the
* MediaElement.js plugin API.
*/
	add_action( 'wp_print_footer_scripts', 'esr_mejs_add_container_class' );

	function esr_mejs_add_container_class() {
		if ( ! wp_script_is( 'mediaelement', 'done' ) ) {
			return;
		}
		?>
		<script>
		(function() {
			var settings = window._wpmejsSettings || {};
			settings.features = settings.features || mejs.MepDefaults.features;
			settings.features.push( 'exampleclass' );
			MediaElementPlayer.prototype.buildexampleclass = function( player ) {
				player.container.addClass( 'esr-mejs-container' );
			};
		})();
		</script>
		<?php
	}

}
add_action( 'init', 'responsive_shortcodes_init' );


/**
 * Enqueues the plugin's scripts and styles
 */
function responsive_shortcodes_enqueue_scripts() {

	wp_register_script( 'rs-accordion', RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL . 'js/accordion.js', array( 'jquery' ), true );
	wp_register_script( 'rs-tabs',      RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL . 'js/tabs.js',      array( 'jquery' ), true );
	wp_register_script( 'rs-toggle',    RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL . 'js/toggle.js',    array( 'jquery' ), true );

	// Enqueue bundled CSS only if the current theme does not declare support for the plugin.
	if ( ! current_theme_supports( 'rs-responsive-shortcodes' ) ) {
		wp_enqueue_style( 'responsive-shortcodes', RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL . 'css/responsive-shortcodes.min.css', array(), RESPONSIVE_SHORTCODES_VERSION );
	}

	// Enqueue bundled Font Awesome if the current theme does not declare support for the font.
	if ( ! current_theme_supports( 'font-awesome-icons' ) ) {
		wp_enqueue_style( 'font-awesome-rs', RESPONSIVE_SHORTCODES_PLUGIN_DIR_URL . 'css/font-awesome.css', array(), '4.7.0' );
	}

}

/**
 * Dequeue the Parent Theme styles.
 *
 * Hooked to the wp_enqueue_scripts action, with a late priority (100),
 * so that it runs after the parent style was enqueued.
 */
 
function give_dequeue_plugin_css() {
    wp_dequeue_style('font-awesome');
    wp_deregister_style('font-awesome');
}
add_action('wp_enqueue_scripts','give_dequeue_plugin_css', 200);


/**
 * Filter for the_content which processes the plugin's shortcodes
 *
 * Uses the technique advocated by WordPress core developer Alex Mills here:
 * http://www.viper007bond.com/2009/11/22/wordpress-code-earlier-shortcodes/
 * This is needed because the wpautop() function adds unwanted <p> and <br> tags around the shortcode output.
 * This filter runs before wpautop(), and so does not have that problem.
 *
 * @param  string $content The post content.
 * @return string          The filtered post content.
 */
function responsive_shortcodes_process_shortcodes( $content ) {
	global $shortcode_tags;

	// Backup all existing shortcode tags.
	$original_shortcode_tags = $shortcode_tags;

	// Remove all existing shortcodes.
	remove_all_shortcodes();

	// Add back the plugin shortcodes. They'll be the only ones active.
	foreach( responsive_shortcodes_get_shortcodes() as $shortcode_name => $shortcode_function ) {
		add_shortcode( $shortcode_name, $shortcode_function );
	}

	// Process the plugin shortcodes.
	$content = do_shortcode( $content );

	// Restore the original shortcodes.
	$shortcode_tags = $original_shortcode_tags;

	return $content;
}


/**
 * Returns a list of all of the shortcodes available in the plugin, with their associated function names
 *
 * @return array All available plugin shortcodes.
 */
function responsive_shortcodes_get_shortcodes() {

	$shortcodes = array(
		'boxmusic'       => 'responsive_shortcodes_music_shortcode',
		'boxvideo'       => 'responsive_shortcodes_video_shortcode',
		'accordion'      => 'responsive_shortcodes_accordion_shortcode',
		'accordion_item' => 'responsive_shortcodes_accordion_item_shortcode',
		'alert'          => 'responsive_shortcodes_alert_shortcode',
		'box'            => 'responsive_shortcodes_box_shortcode',
		'button'         => 'responsive_shortcodes_button_shortcode',
		'call_to_action' => 'responsive_shortcodes_call_to_action_shortcode',
		'clear_floats'   => 'responsive_shortcodes_clear_floats_shortcode',
		'columns'        => 'responsive_shortcodes_columns_shortcode',
		'column'         => 'responsive_shortcodes_column_shortcode',
		'divider'	     => 'responsive_shortcodes_divider_shortcode',
		'highlight'      => 'responsive_shortcodes_highlight_shortcode',
		'icon'           => 'responsive_shortcodes_icon_shortcode',
		'tabs'           => 'responsive_shortcodes_tabs_shortcode',
		'tab'            => 'responsive_shortcodes_tab_shortcode',
		'toggle'         => 'responsive_shortcodes_toggle_shortcode',
	);

	return apply_filters( 'responsive_shortcodes_get_shortcodes', $shortcodes );
}
