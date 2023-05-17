<?php

namespace GPLP\Controllers;

class PetitionController {
  public static function get_petition_publish_locations($petition_id) {
    $transient_key = "petition_locations_$petition_id";
    $transient_value = get_transient($transient_key);
    return $transient_value;
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

  public static function get_pages_by_petition_id($petition_id) {
    global $wpdb;

    try {
      $results = $wpdb->get_results( "SELECT ID, post_title, post_content, post_status FROM $wpdb->posts WHERE post_content LIKE '%wp:acf/leads-form%'AND post_status IN ('publish','draft','auto-draft','pending','future','private')" );
      $pages = array();
      $message = "";
      //iterrating obver the results and assigning values for each page to variables
      $encoded_result = json_encode($results);
      \GPPL4\debug_log("results: $encoded_result");

      foreach($results as $page) {
        $page_id = $page->ID;
        $page_title = $page->post_title;
        $page_content = $page->post_content;
        $page_status = $page->post_status;
        //getting the permalink and the meta of the page and filetring the content
        $page_permalink = get_permalink($page_id);
        $page_meta = get_post_meta($page_id);
        $page_content = apply_filters('the_content', $page_content);
        //assigning the custom styles of the page statuses
        $page_status = $status_labels[$page_status] ?? '<span style="padding-left:0.2rem;color:darkorange;"><small> (Draft) </small></span>';
        //regular expression to search for a match in the first param within the string provided in the second param by returning a number if match is found
        preg_match('/data-form-id="(.*?)"/', $page_content, $form_id);
        //if there is a match with the data attibute and a form ID then output a link to the page
        if(isset($form_id[1]) && $form_id[1] == $petition_id) {
            $message .= '<a href="' . $page_permalink . '" target="_blank">' . $page_title . '</a>' . $page_status . '<br>';
        }
      }
      return $message;
    } catch (exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
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

  public static function get_pages_by_transient_values($ids) {
    $posts = new \WP_Query([
        'post_type' => 'page',
        'posts_per_page' => -1,
        'post_status' => 'any',
        'post__in' => $ids,
    ]);
    if ($posts->have_posts()) {
      return array_map(function($post) {
        return array('title' => $post->post_title, 'permalink' => get_the_permalink($post->ID));
      }, $posts->get_posts());
    }
    return [];
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

