<?php

/**
 * Plugin Name: Greenpeace - Leads
 * Description: Petition with Gutenberg blocks
 * Plugin URI:
 * Version: 1.2.11
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
	'lib/blocks/leads-form.php',
	'lib/acf.php',
	'lib/options.php',
	'lib/extras.php',
	'lib/controllers/leads-form-controller.php',
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
add_action('wp_enqueue_scripts', 'gplp_enqueue_scripts');
add_action('admin_enqueue_scripts', 'gplp_enqueue_scripts');


