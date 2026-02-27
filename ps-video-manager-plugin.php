<?php
/**
 * Plugin Name: PS Video Manager
 * Plugin URI:  https://github.com/Sidhuhirpara/ps-video-manager-plugin
 * Description: Custom plugin to manage Videos with YouTube URL and filtering by Video Type.
 * Version:     1.0.0
 * Author:      Sidhuhirpara
 * Text Domain: ps-video-manager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define plugin constants.
 */
define( 'PSVM_VERSION', '1.0.0' );
define( 'PSVM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PSVM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );