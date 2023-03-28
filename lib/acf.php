<?php
// Define path and URL to the ACF plugin.
if (!defined('GPLP_ACF_PATH'))
  define('GPLP_ACF_PATH', GPLP_PLUGIN_ROOT_URI . 'includes/acf/');
if (!defined('GPLP_ACF_URL'))
  define('GPLP_ACF_URL', GPLP_PLUGIN_ROOT . 'includes/acf/');

// Include the ACF plugin.
include_once(GPLP_ACF_PATH . 'acf.php');

$include = [
  'helper-functions',
  'petition-settings',
  'petition-options',
  'petition-form-block',
];
foreach ($include as $file) {
  include_once(GPLP_PLUGIN_ROOT_URI . "lib/custom-fields/$file.php");
}

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'gplp_acf_settings_url');
function gplp_acf_settings_url($url)
{
  return GPLP_ACF_URL;
}

// Hide the ACF admin menu item.
function gplp_acf_settings_show_admin($show_admin)
{
  return true;
}
add_filter('acf/settings/show_admin', 'gplp_acf_settings_show_admin');
