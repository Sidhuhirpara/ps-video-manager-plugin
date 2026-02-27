<?php
/**
 * Handles frontend shortcode display.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PSVM_Shortcode {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_shortcode( 'ps_video_list', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Render shortcode output.
	 */
	public function render_shortcode() {

		ob_start();

		$selected_type = isset( $_GET['video_type'] ) ? sanitize_text_field( $_GET['video_type'] ) : '';

		$terms = get_terms( array(
			'taxonomy'   => 'psvm_video_type',
			'hide_empty' => false,
		) );

		?>

		<form method="get" class="psvm-filter-form">
			<select name="video_type" onchange="this.form.submit()">
				<option value=""><?php esc_html_e( 'All Video Types', 'ps-video-manager' ); ?></option>

				<?php
				foreach ( $terms as $term ) :
					?>
					<option value="<?php echo esc_attr( $term->slug ); ?>"
						<?php selected( $selected_type, $term->slug ); ?>>
						<?php echo esc_html( $term->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</form>

		<?php

		$args = array(
			'post_type'      => 'psvm_video',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);

		if ( ! empty( $selected_type ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'psvm_video_type',
					'field'    => 'slug',
					'terms'    => $selected_type,
				),
			);
		}

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :

			echo '<div class="psvm-video-wrapper">';

			while ( $query->have_posts() ) :
				$query->the_post();

				$video_url = get_post_meta( get_the_ID(), '_psvm_video_url', true );
				$embed_url = $this->convert_to_embed_url( $video_url );

				?>

				<div class="psvm-video-item">
					<h3><?php the_title(); ?></h3>

					<?php if ( $embed_url ) : ?>
						<div class="psvm-video-embed">
							<iframe 
								width="560" 
								height="315" 
								src="<?php echo esc_url( $embed_url ); ?>" 
								frameborder="0" 
								allowfullscreen>
							</iframe>
						</div>
					<?php endif; ?>

				</div>

				<?php

			endwhile;

			echo '</div>';

			wp_reset_postdata();

		else :

			echo '<p>' . esc_html__( 'No videos found.', 'ps-video-manager' ) . '</p>';

		endif;

		return ob_get_clean();
	}

	/**
	 * Convert YouTube URL to embed format.
	 */
	private function convert_to_embed_url( $url ) {

		if ( empty( $url ) ) {
			return false;
		}

		$video_id = '';

		if ( strpos( $url, 'watch?v=' ) !== false ) {
			parse_str( parse_url( $url, PHP_URL_QUERY ), $query_vars );
			$video_id = $query_vars['v'] ?? '';
		} elseif ( strpos( $url, 'youtu.be/' ) !== false ) {
			$video_id = basename( parse_url( $url, PHP_URL_PATH ) );
		}

		if ( $video_id ) {
			return 'https://www.youtube.com/embed/' . $video_id;
		}

		return false;
	}
}