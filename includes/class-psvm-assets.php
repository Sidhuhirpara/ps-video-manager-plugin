<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PSVM_Assets {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function enqueue_assets() {
		wp_enqueue_style(
			'psvm-style',
			PSVM_PLUGIN_URL . 'assets/css/psvm-style.css',
			array(),
			PSVM_VERSION
		);
	}
}