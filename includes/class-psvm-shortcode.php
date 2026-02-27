<?php
/**
 * Handles frontend shortcode display.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PSVM_Shortcode {

	public function __construct() {
		add_shortcode( 'ps_video_list', array( $this, 'render_shortcode' ) );
	}

	public function render_shortcode() {

		ob_start();

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		$selected_type = isset( $_GET['video_type'] ) ? sanitize_text_field( $_GET['video_type'] ) : '';
		$search_query  = isset( $_GET['video_search'] ) ? sanitize_text_field( $_GET['video_search'] ) : '';

		$terms = get_terms( array(
			'taxonomy'   => 'psvm_video_type',
			'hide_empty' => false,
		) );

		?>

		<form method="get" class="psvm-filter-form">
			<input type="text" name="video_search" placeholder="Search videos..."
				value="<?php echo esc_attr( $search_query ); ?>" />

			<select name="video_type">
				<option value="">All Video Types</option>

				<?php foreach ( $terms as $term ) : ?>
					<option value="<?php echo esc_attr( $term->slug ); ?>"
						<?php selected( $selected_type, $term->slug ); ?>>
						<?php echo esc_html( $term->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>

			<button type="submit">Filter</button>
		</form>

		<?php

		$args = array(
			'post_type'      => 'psvm_video',
			'post_status'    => 'publish',
			'posts_per_page' => 8,
			'paged'          => $paged,
			's'              => $search_query,
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

			echo '<div class="psvm-container">';
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
								src="<?php echo esc_url( $embed_url ); ?>" 
								frameborder="0" 
								allowfullscreen>
							</iframe>
						</div>
					<?php endif; ?>
				</div>

				<?php
			endwhile;

			echo '</div>'; // closes .psvm-video-wrapper
            echo '</div>'; // closes .psvm-container

			echo '<div class="psvm-pagination">';
			echo paginate_links( array(
				'total' => $query->max_num_pages,
			) );
			echo '</div>';

			wp_reset_postdata();

		else :

			echo '<p>No videos found.</p>';

		endif;

		return ob_get_clean();
	}

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