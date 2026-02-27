<?php
/**
 * Handles Custom Post Type registration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PSVM_Post_Type {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Register the Video custom post type.
	 */
	public function register_post_type() {

		$labels = array(
			'name'               => __( 'Videos', 'ps-video-manager' ),
			'singular_name'      => __( 'Video', 'ps-video-manager' ),
			'menu_name'          => __( 'Videos', 'ps-video-manager' ),
			'name_admin_bar'     => __( 'Video', 'ps-video-manager' ),
			'add_new'            => __( 'Add New', 'ps-video-manager' ),
			'add_new_item'       => __( 'Add New Video', 'ps-video-manager' ),
			'new_item'           => __( 'New Video', 'ps-video-manager' ),
			'edit_item'          => __( 'Edit Video', 'ps-video-manager' ),
			'view_item'          => __( 'View Video', 'ps-video-manager' ),
			'all_items'          => __( 'All Videos', 'ps-video-manager' ),
			'search_items'       => __( 'Search Videos', 'ps-video-manager' ),
			'not_found'          => __( 'No videos found.', 'ps-video-manager' ),
			'not_found_in_trash' => __( 'No videos found in Trash.', 'ps-video-manager' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'menu_icon'          => 'dashicons-video-alt3',
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'videos' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'psvm_video', $args );
	}
}