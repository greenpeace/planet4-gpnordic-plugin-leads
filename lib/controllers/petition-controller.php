<?php

namespace GPLP\Controllers;

class PetitionController
{
  static function parse_page($page_id)
  {
    return array(
      'title' => get_the_title($page_id),
      'url' => get_edit_post_link($page_id),
    );
  }

  public static function get_petition_locations($request)
  {
    // Use wpdb query to get IDs of pages that have the petition shortcode
    $id = $request['id'];
    global $wpdb;
    $page_ids = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%%<!-- wp:acf/leads-form {%\"form\": %d,%} /-->%%' AND post_status IN ('publish','draft','auto-draft','pending','future','private');", $id));
    return array_map("self::parse_page", $page_ids);
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
