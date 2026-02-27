<?php
/**
 * Handles Custom Taxonomy registration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PSVM_Taxonomy {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}

	/**
	 * Register the Video Type taxonomy.
	 */
	public function register_taxonomy() {

		$labels = array(
			'name'              => __( 'Video Types', 'ps-video-manager' ),
			'singular_name'     => __( 'Video Type', 'ps-video-manager' ),
			'search_items'      => __( 'Search Video Types', 'ps-video-manager' ),
			'all_items'         => __( 'All Video Types', 'ps-video-manager' ),
			'edit_item'         => __( 'Edit Video Type', 'ps-video-manager' ),
			'update_item'       => __( 'Update Video Type', 'ps-video-manager' ),
			'add_new_item'      => __( 'Add New Video Type', 'ps-video-manager' ),
			'new_item_name'     => __( 'New Video Type Name', 'ps-video-manager' ),
			'menu_name'         => __( 'Video Type', 'ps-video-manager' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'video-type' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'psvm_video_type', array( 'psvm_video' ), $args );

		$this->add_default_terms();
	}

	/**
	 * Add default terms if they do not exist.
	 */
	private function add_default_terms() {

		$terms = array( 'Movie', 'Series' );

		foreach ( $terms as $term ) {
			if ( ! term_exists( $term, 'psvm_video_type' ) ) {
				wp_insert_term( $term, 'psvm_video_type' );
			}
		}
	}
}