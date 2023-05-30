<?php

namespace GPLP\Controllers;

class PetitionController
{
  public static $transient_prefix = 'petition_locations_';

  static function parse_page($page_id)
  {
    return array(
      'title' => html_entity_decode(get_the_title($page_id)),
      'url' => get_edit_post_link($page_id),
      'post_status' => get_post_status($page_id),
    );
  }

  public static function get_petition_locations($request)
  {
    // Use wpdb query to get IDs of pages that have the petition shortcode
    $id = $request['id'];
    // Check if these is a transient for this petition
    $transient_name = self::$transient_prefix . $id;
    $transient = get_transient($transient_name);
    if ($transient) {
      return $transient;
    }
    // If not, query the database
    global $wpdb;
    $page_ids = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%%<!-- wp:acf/leads-form {%\"form\": %d,%} /-->%%' AND post_status IN ('publish','draft','auto-draft','pending','future','private');", $id));
    // Set transient for 1 hour
    $response = array_map("self::parse_page", $page_ids);
    set_transient($transient_name, $response, 60 * 60);
    return $response;
  }

  public static function clear_all_petition_locations_transients($post_id)
  {
    // If this is just a revision, don't do anything
    if (wp_is_post_revision($post_id)) {
      return;
    }
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_" . self::$transient_prefix . "%';");
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_" . self::$transient_prefix . "%';");
  }

  public static function register_api_routes()
  {
    register_rest_route("gplp/v2", '/petition_locations/(?P<id>\d+)', array(
      'methods' => 'GET',
      'permission_callback' => "is_user_logged_in",
      'callback' => __NAMESPACE__ . '\\PetitionController::get_petition_locations',
    ));
  }
}

add_action('rest_api_init', __NAMESPACE__ . '\\PetitionController::register_api_routes');
add_action('save_post', __NAMESPACE__ . '\\PetitionController::clear_all_petition_locations_transients');
