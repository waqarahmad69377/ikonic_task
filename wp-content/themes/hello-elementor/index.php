<?php

/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 * @package HelloElementor
 */
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();

$is_elementor_theme_exist = function_exists('elementor_theme_do_location');

if (!is_post_type_archive('project') && is_singular()) {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('single')) {
		get_template_part('template-parts/single');
	}
} elseif (is_post_type_archive('project') && is_singular()) {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('single-project')) {
		get_template_part('template-parts/single-project');
	}
} elseif (
	!is_post_type_archive('project') &&	is_archive() || is_home()
) {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('archive') && ! is_post_type_archive('project')) {
		get_template_part('template-parts/archive');
	}
} elseif (is_post_type_archive('project') && is_archive() || is_home()) {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('archive-project')) {
		get_template_part('template-parts/archive-project');
	}
} elseif (is_search()) {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('archive')) {
		get_template_part('template-parts/search');
	}
} else {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('single')) {
		get_template_part('template-parts/404');
	}
}

get_footer();
