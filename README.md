# PS Video Manager

PS Video Manager is a custom WordPress plugin that allows administrators to create and manage videos using YouTube URLs. Videos can be categorized by type and displayed on the frontend with filtering, search, and pagination functionality.

---

## Features

- Custom Post Type: Video
- Custom Taxonomy: Video Type
- Pre-populated terms: Movie and Series
- Secure meta box for YouTube URL
- YouTube URL validation
- Frontend shortcode display
- Filter videos by Video Type
- Search videos by title
- Pagination support
- Responsive layout
- Clean, modular, object-oriented architecture
- Follows WordPress coding standards

---

## Installation

1. Download the plugin ZIP file.
2. Log in to your WordPress admin panel.
3. Navigate to Plugins > Add New.
4. Click Upload Plugin.
5. Upload the ZIP file and click Install Now.
6. Activate the plugin.

Alternatively, you may upload the plugin folder manually to:

wp-content/plugins/

Then activate it from the Plugins menu.

---

## Usage

### 1. Add Videos

- Go to Videos > Add New.
- Enter a title.
- Paste a valid YouTube URL in the "Video URL" meta box.
- Assign a Video Type (Movie or Series).
- Publish the video.

### 2. Display Videos on Frontend

Create a page and insert the following shortcode:

[ps_video_list]

This shortcode displays:

- Video title
- Embedded YouTube video
- Filter dropdown (Video Type)
- Search field
- Pagination

---

## Technical Overview

- Custom Post Type registered using register_post_type()
- Custom Taxonomy registered using register_taxonomy()
- Meta box implemented using add_meta_box()
- Data secured using nonce verification and capability checks
- URL sanitization using esc_url_raw()
- YouTube validation implemented via host validation
- Frontend built using WP_Query
- Pagination implemented using paginate_links()
- Assets enqueued properly using wp_enqueue_style()

---

## Requirements

- WordPress 6.x+
- PHP 7.4+

---

## Author

Sidhuhirpara