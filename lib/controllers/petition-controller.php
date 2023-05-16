<?php

namespace GPLP\Controllers;

class PetitionController {
  public static function get_petition_publish_locations($petition_id) {
    // return "I'll get the publish locations for $post_id";
    $transient_key = "petition_locations_$petition_id";
    $transient_value = get_transient($transient_key);
    return $transient_value ? json_encode($transient_value) : "";
  }

  public static function get_petition_ids_by_page($page_id) {
    // Get page by id
    $page = get_post($page_id);
    // Get block objects by page content 
    $blocks = array_map(function($block) {
      return PetitionController::get_block_data($block);
    }, parse_blocks($page->post_content));
    // Filter out null values
    $blocks = array_filter($blocks, function($block) {
      return $block !== null && isset($block['data']) && isset($block['data']['form']);
    });
    // Get petition form ids from blocks
    $petition_ids = array_map(function($block) {
      return $block['data']['form'];
    }, $blocks);
    return count($petition_ids) ? array_values($petition_ids) : null;
  }

  public static function get_block_data($block) {
    if (
        isset($block['attrs']) &&
        isset($block['attrs']['name']) &&
        strpos($block['attrs']['name'], 'acf') !== false && 
        $block['attrs']['name'] === "acf/leads-form"
    ) {
      $data = isset($block['attrs']['data']) ? $block['attrs']['data'] : null;

      $modified_block = [
          'data' => (array) $data,
      ];
      acf_reset_meta($block['attrs']['id']);
      acf_reset_meta($block['attrs']['name']);
      return $modified_block;
    }
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

