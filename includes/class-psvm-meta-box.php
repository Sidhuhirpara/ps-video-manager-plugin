<?php
/**
 * Handles Video URL Meta Box.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PSVM_Meta_Box {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );
	}

	/**
	 * Register meta box.
	 */
	public function add_meta_box() {
		add_meta_box(
			'psvm_video_url',
			__( 'Video URL', 'ps-video-manager' ),
			array( $this, 'render_meta_box' ),
			'psvm_video',
			'normal',
			'default'
		);
	}

	/**
	 * Render meta box content.
	 */
	public function render_meta_box( $post ) {

		wp_nonce_field( 'psvm_save_video_url', 'psvm_video_url_nonce' );

		$value = get_post_meta( $post->ID, '_psvm_video_url', true );

		?>
		<p>
			<label for="psvm_video_url_field">
				<?php esc_html_e( 'Enter YouTube URL:', 'ps-video-manager' ); ?>
			</label>
		</p>
		<input
			type="url"
			id="psvm_video_url_field"
			name="psvm_video_url_field"
			value="<?php echo esc_attr( $value ); ?>"
			style="width:100%;"
		/>
		<?php
	}

	/**
	 * Save meta box data.
	 */
	public function save_meta_box( $post_id ) {

	if ( ! isset( $_POST['psvm_video_url_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['psvm_video_url_nonce'], 'psvm_save_video_url' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['psvm_video_url_field'] ) ) {

		$url = esc_url_raw( $_POST['psvm_video_url_field'] );

		// Validate YouTube URL
		if ( $this->is_valid_youtube_url( $url ) ) {
			update_post_meta( $post_id, '_psvm_video_url', $url );
		}
	}
}

private function is_valid_youtube_url( $url ) {

	if ( empty( $url ) ) {
		return false;
	}

	$host = parse_url( $url, PHP_URL_HOST );

	$allowed_hosts = array(
		'www.youtube.com',
		'youtube.com',
        'm.youtube.com',
		'youtu.be',
	);

	return in_array( $host, $allowed_hosts, true );
}
}