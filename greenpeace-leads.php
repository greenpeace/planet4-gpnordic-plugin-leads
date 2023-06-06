<?php

/**
 * Plugin Name: Greenpeace - Leads
 * Description: Petition with Gutenberg blocks
 * Plugin URI:
 * Version: 1.2.40
 * Php Version: 7.0
 *
 * Author: Simma Lugnt
 * Author URI: https://simmalugnt.se
 * Text Domain: greenpeace-leads
 *
 * License:     GPLv3
 * Copyright (C) 2017 Simma Lugnt
 *
 * @package GPLP
 */

/**
 * Followed WordPress plugins best practices from https://developer.wordpress.org/plugins/the-basics/best-practices/
 * Followed WordPress-Core coding standards https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/
 * Followed WordPress-VIP coding standards https://vip.wordpress.com/documentation/code-review-what-we-look-for/
 * Added namespacing and PSR-4 auto-loading.
 */

// Exit if accessed directly.
defined('ABSPATH') or die('Direct access is forbidden!');

if (!defined('GPLP_PLUGIN_ROOT_FILE')) {
	define('GPLP_PLUGIN_ROOT_FILE', __FILE__);
}
if (!defined('GPLP_PLUGIN_ROOT')) {
	define('GPLP_PLUGIN_ROOT', plugin_dir_url(__FILE__));
}
if (!defined('GPLP_PLUGIN_ROOT_URI')) {
	define('GPLP_PLUGIN_ROOT_URI', plugin_dir_path(__FILE__));
}


$roots_includes = array(
	'vendor/autoload.php',
	'lib/blocks/leads-form.php',
	'lib/acf.php',
	'lib/options.php',
	'lib/extras.php',
	'lib/controllers/leads-form-controller.php',
	'lib/controllers/petition-controller.php',
	'lib/post-types/leads-form.php',
);

foreach ($roots_includes as $file) {
	require_once $file;
}
unset($file, $filepath);

function gplp_enqueue_scripts()
{
	wp_enqueue_script('jquery');
	wp_localize_script('jquery', 'gplp', array('plugin_uri' => plugin_dir_url(__FILE__)));
}
function gplp_enqueue_admin_scripts($hook)
{
	$version = get_plugin_data(__FILE__)['Version'];
	wp_enqueue_script('jquery');
	wp_localize_script('jquery', 'gplp', array('plugin_uri' => plugin_dir_url(__FILE__)));
	// Petition location scripts (only for Petitions tab)
	if ($hook === "edit.php" && isset($_GET['post_type']) && $_GET['post_type'] === 'leads-form') {
		wp_enqueue_script('petition-location', plugin_dir_url(__FILE__) . '/assets/js/petition-locations.js', ['jquery'], $version, true);
		wp_localize_script('petition-location', 'gplp_leads_ajax', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
		));
	}
}
add_action('wp_enqueue_scripts', 'gplp_enqueue_scripts');
add_action('admin_enqueue_scripts', 'gplp_enqueue_admin_scripts');



//Adding label for FB shares
function fb_label_render_field($field)
{
	echo '<div style="position: relative; margin: 25px 0 0 0; padding: 15px 0 0; border-top: #eee solid 1px;"><div class="acf-label"><label>Sharing settings: Facebook</label><p>You can find the Title, Description and Image Override used for sharing on Facebook in the "Open Graph/Social Fields" page settings on the page where you will be using this form.</p></div></div>';
}

// Apply to field named "share_description".
add_action('acf/render_field/name=share_description', 'fb_label_render_field');
