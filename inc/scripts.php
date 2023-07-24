<?php
// Theme css & js

function base_scripts_styles() {
	if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
		$in_footer = true;

		// Loads JavaScript
		wp_register_script('libs-js', get_template_directory_uri() . '/js/libs.js', array('jquery'), '1.0.0', $in_footer); // Custom libs
		wp_enqueue_script('libs-js'); // Enqueue it!

		wp_register_script('main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', $in_footer); // Custom scripts
		wp_enqueue_script('main-js'); // Enqueue it!

		// Loads CSS
		wp_register_style('main-css', get_template_directory_uri() . '/style.css', array());
		wp_enqueue_style('main-css'); // Enqueue it!
	}
}

function conditional_scripts() {
	if (is_page('pagenamehere')) {
		wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0');
		wp_enqueue_script('scriptname');
	}
}

add_action('wp_enqueue_scripts', 'base_scripts_styles');
add_action('wp_print_scripts', 'conditional_scripts');