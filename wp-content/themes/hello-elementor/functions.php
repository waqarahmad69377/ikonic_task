<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_VERSION', '3.4.2');
define('EHP_THEME_SLUG', 'hello-elementor');

define('HELLO_THEME_PATH', get_template_directory());
define('HELLO_THEME_URL', get_template_directory_uri());
define('HELLO_THEME_ASSETS_PATH', HELLO_THEME_PATH . '/assets/');
define('HELLO_THEME_ASSETS_URL', HELLO_THEME_URL . '/assets/');
define('HELLO_THEME_SCRIPTS_PATH', HELLO_THEME_ASSETS_PATH . 'js/');
define('HELLO_THEME_SCRIPTS_URL', HELLO_THEME_ASSETS_URL . 'js/');
define('HELLO_THEME_STYLE_PATH', HELLO_THEME_ASSETS_PATH . 'css/');
define('HELLO_THEME_STYLE_URL', HELLO_THEME_ASSETS_URL . 'css/');
define('HELLO_THEME_IMAGES_PATH', HELLO_THEME_ASSETS_PATH . 'images/');
define('HELLO_THEME_IMAGES_URL', HELLO_THEME_ASSETS_URL . 'images/');

if (! isset($content_width)) {
	$content_width = 800; // Pixels.
}

if (! function_exists('hello_elementor_setup')) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup()
	{
		if (is_admin()) {
			hello_maybe_update_theme_version_in_db();
		}

		if (apply_filters('hello_elementor_register_menus', true)) {
			register_nav_menus(['menu-1' => esc_html__('Header', 'hello-elementor')]);
			register_nav_menus(['menu-2' => esc_html__('Footer', 'hello-elementor')]);
		}

		if (apply_filters('hello_elementor_post_type_support', true)) {
			add_post_type_support('page', 'excerpt');
		}

		if (apply_filters('hello_elementor_add_theme_support', true)) {
			add_theme_support('post-thumbnails');
			add_theme_support('automatic-feed-links');
			add_theme_support('title-tag');
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support('align-wide');
			add_theme_support('responsive-embeds');

			/*
			 * Editor Styles
			 */
			add_theme_support('editor-styles');
			add_editor_style('editor-styles.css');

			/*
			 * WooCommerce.
			 */
			if (apply_filters('hello_elementor_add_woocommerce_support', true)) {
				// WooCommerce in general.
				add_theme_support('woocommerce');
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support('wc-product-gallery-zoom');
				// lightbox.
				add_theme_support('wc-product-gallery-lightbox');
				// swipe.
				add_theme_support('wc-product-gallery-slider');
			}
		}
	}
}
add_action('after_setup_theme', 'hello_elementor_setup');

function hello_maybe_update_theme_version_in_db()
{
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option($theme_version_option_name);

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if (! $hello_theme_db_version || version_compare($hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<')) {
		update_option($theme_version_option_name, HELLO_ELEMENTOR_VERSION);
	}
}

if (! function_exists('hello_elementor_display_header_footer')) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer()
	{
		$hello_elementor_header_footer = true;

		return apply_filters('hello_elementor_header_footer', $hello_elementor_header_footer);
	}
}

if (! function_exists('hello_elementor_scripts_styles')) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles()
	{
		$min_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		if (apply_filters('hello_elementor_enqueue_style', true)) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if (apply_filters('hello_elementor_enqueue_theme_style', true)) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if (hello_elementor_display_header_footer()) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				get_template_directory_uri() . '/header-footer' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action('wp_enqueue_scripts', 'hello_elementor_scripts_styles');

if (! function_exists('hello_elementor_register_elementor_locations')) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations($elementor_theme_manager)
	{
		if (apply_filters('hello_elementor_register_elementor_locations', true)) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action('elementor/theme/register_locations', 'hello_elementor_register_elementor_locations');

if (! function_exists('hello_elementor_content_width')) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width()
	{
		$GLOBALS['content_width'] = apply_filters('hello_elementor_content_width', 800);
	}
}
add_action('after_setup_theme', 'hello_elementor_content_width', 0);

if (! function_exists('hello_elementor_add_description_meta_tag')) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag()
	{
		if (! apply_filters('hello_elementor_description_meta_tag', true)) {
			return;
		}

		if (! is_singular()) {
			return;
		}

		$post = get_queried_object();
		if (empty($post->post_excerpt)) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($post->post_excerpt)) . '">' . "\n";
	}
}
add_action('wp_head', 'hello_elementor_add_description_meta_tag');

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if (! function_exists('hello_elementor_customizer')) {
	// Customizer controls
	function hello_elementor_customizer()
	{
		if (! is_customize_preview()) {
			return;
		}

		if (! hello_elementor_display_header_footer()) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action('init', 'hello_elementor_customizer');

if (! function_exists('hello_elementor_check_hide_title')) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title($val)
	{
		if (defined('ELEMENTOR_VERSION')) {
			$current_doc = Elementor\Plugin::instance()->documents->get(get_the_ID());
			if ($current_doc && 'yes' === $current_doc->get_settings('hide_title')) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter('hello_elementor_page_title', 'hello_elementor_check_hide_title');

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if (! function_exists('hello_elementor_body_open')) {
	function hello_elementor_body_open()
	{
		wp_body_open();
	}
}

require HELLO_THEME_PATH . '/theme.php';

HelloTheme\Theme::instance();

add_action('init', 'ip_redirect_blocker_check_ip');

function ip_redirect_blocker_check_ip()
{
	// Get the user's IP address (handle proxies if needed)
	$user_ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])
		? trim(current(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])))
		: $_SERVER['REMOTE_ADDR'];
	// $user_ip = '77.29.123.456'; // Replace with the actual IP address you want to check
	// Check if IP starts with 77.29
	if (strpos($user_ip, '77.29') === 0) {
		wp_redirect('https://example.com'); // Change this URL to your desired redirect destination
		exit;
	}
}

add_action('init', 'register_projects_post_type');
function register_projects_post_type()
{
	// Register Post Type
	register_post_type('project', [
		'labels' => [
			'name' => 'Projects',
			'singular_name' => 'Project',
		],
		'public' => true,
		'has_archive' => true,
		'rewrite' => true,
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-portfolio',
		'taxonomies' => ['project_type'], // Enables taxonomy column auto
	]);

	// Register Project Type Taxonomy
	register_taxonomy('project_type', ['project'], [
		'labels' => [
			'name' => 'Project Types',
			'singular_name' => 'Project Type',
			'search_items' => 'Search Project Types',
			'all_items' => 'All Project Types',
			'edit_item' => 'Edit Project Type',
			'update_item' => 'Update Project Type',
			'add_new_item' => 'Add New Project Type',
			'new_item_name' => 'New Project Type Name',
			'menu_name' => 'Project Types',
		],
		'hierarchical' => true,
		'public' => true,
		'rewrite' => true,
		'show_admin_column' => true, // This line adds it as a column automatically
		'show_in_rest' => true,
	]);
}

// 3. AJAX Endpoint
add_action('wp_ajax_get_architecture_projects', 'get_architecture_projects_ajax');
add_action('wp_ajax_nopriv_get_architecture_projects', 'get_architecture_projects_ajax');

function get_architecture_projects_ajax()
{
	$limit = is_user_logged_in() ? 6 : 3;

	$args = [
		'post_type' => 'project',
		'posts_per_page' => $limit,
		'tax_query' => [
			[
				'taxonomy' => 'project_type',
				'field' => 'slug',
				'terms' => 'architecture'
			]
		]
	];

	$query = new WP_Query($args);
	$projects = [];

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$projects[] = [
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'link' => get_permalink()
			];
		}
	}
	wp_reset_postdata();

	wp_send_json([
		'success' => true,
		'data' => $projects
	]);
}

add_action('pre_get_posts', function ($query) {
	if (!is_admin() && $query->is_main_query() && is_post_type_archive('project')) {
		$query->set('posts_per_page', 6);
	}
});

function hs_give_me_coffee()
{
	$response = wp_remote_get('https://coffee.alexflipnote.dev/random.json');

	if (is_wp_error($response)) {
		return false;
	}

	$body = wp_remote_retrieve_body($response);
	$data = json_decode($body);

	if (!empty($data->file)) {
		return esc_url($data->file); // Direct image link
	}

	return false;
}


function hs_display_kanye_quotes()
{
	$quotes = [];

	for ($i = 0; $i < 5; $i++) {
		$response = wp_remote_get('https://api.kanye.rest/');
		if (is_wp_error($response)) continue;

		$body = wp_remote_retrieve_body($response);
		$data = json_decode($body);

		if (!empty($data->quote)) {
			$quotes[] = sanitize_text_field($data->quote);
		}
	}

	if (empty($quotes)) return '<p>Could not fetch Kanye quotes at this time.</p>';

	$output = '<ol class="kanye-quotes">';
	foreach ($quotes as $quote) {
		$output .= '<li><blockquote>"' . esc_html($quote) . '"</blockquote></li>';
	}
	$output .= '</ol>';

	return $output;
}
add_shortcode('kanye_quotes', 'hs_display_kanye_quotes');

function hs_give_me_coffee_shortcode()
{
	$response = hs_give_me_coffee();

	if (!empty($response)) {
		// $title = isset($data->title) ? esc_html($data->title) : 'Coffee';
		// $description = isset($data->description) ? esc_html($data->description) : '';
		// $image = esc_url($data->image);

		return $response;
	}

	return '<p>☕ No coffee available.</p>';
}
// Register a shortcode
add_shortcode('random_coffee', 'hs_give_me_coffee_shortcode');
