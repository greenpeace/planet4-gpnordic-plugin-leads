<?php

namespace GPLP\Controllers;

class PetitionController {
  public static function get_petition_publish_locations($post_id) {
    return "I'll get the publish locations for $post_id";
  }

  public static function register_api_routes()
  {
     // Post Leads
    register_rest_route("gplp/v2", '/petition_locations', array(
      'methods' => 'GET',
      'permission_callback' => "__return_true",
      'callback' => __NAMESPACE__ . '\\PetitionController::get_petition_publish_locations',
    ));

  }
}
add_action('rest_api_init', __NAMESPACE__ . '\\PetitionController::register_api_routes');

