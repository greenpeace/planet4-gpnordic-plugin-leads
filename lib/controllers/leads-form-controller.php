<?php

namespace GPLP\Controllers;

class FormController
{
  // Save submitted data to remote db
  public static function set($args)
  {
    try {
      // $dateTime = new \DateTime();
      $form_id = $args['form_id']['value'];
      $firstname = $args['fname']['value'];
      $lastname = $args['lname']['value'];
      $email = $args['email']['value'];
      $phone = $args['phone']['value'];

      $approved_terms = (int)($args['consent']['value'] == 'true');
      $country_iso = get_field('country_code_iso', 'options');

      // SANITIZATION LOGIC - - - - - - - - - - - -

      $dkVars = array('45', '7', '8');
      $fiVars = array('358', '8', '10');
      $noVars = array('47', '7', '8');
      $seVars = array('46', '7', '9');
      $blist = "/000000|111111|222222|333333|444444|555555|666666|777777|888888|999999|12345|54321|1010101|111222333/";

      switch ($country_iso) {
        case "dk":
        case "DK":
          $v = $dkVars;
          break;
        case "fi":
        case "FI":
          $v = $fiVars;
          break;
        case "no":
        case "NO":
          $v = $noVars;
          break;
        case "se":
        case "SE":
          $v = $seVars;
          break;
      }

      $phone = preg_replace("/\D/", "", $phone); // strip non-numeric
      substr($phone, 0, strlen("00")) === "00" ? $phone = substr($phone, 2) : $phone; // strip 00 (catching 0045, etc)
      substr($phone, 0, strlen("0")) === "0" ? $phone = substr($phone, 1) : $phone; // strip 0 (catching 040, 070, etc)
      (strlen($phone) > $v[2]) && (substr($phone, 0, strlen($v[0])) === $v[0]) ? $phone = substr($phone, strlen($v[0])) : $phone; // strip expected country code if still too long
      strlen($phone) > $v[2] ? $phone = "" : $phone; // set to 0 if still too long (non-nordic or country mismatch)
      preg_match($blist, $phone) ? $phone = "" : $phone; // set to 0 if it resembles black list regex
      strlen($phone) > $v[1] ? $phone = "+" . $v[0] . $phone : $phone = ""; // clear value if too small, otherwise add + country code

      // END LOGIC - - - - - - - - - - - - - - - -

      $date = date('Y-m-d');
      $utm = $args['utm']['value'];
      // Capture referrer from the form data
      $referrer = $args['docref']['value'];
      $form_settings = get_field('form_settings', $form_id);
      $source_code = $form_settings['source_code'];
      $dbname = get_field('database_name', 'options');
      $username = get_field('database_user', 'options');
      $password = get_field('database_password', 'options');
      $hostname = get_field('database_host', 'options');

      $count = 0;
      if (!strpos(get_site_url(), '.develop') && get_post_status($form_id) == 'publish') {
        $remote_db = new \wpdb($username, $password, $dbname, $hostname);
        $results = $remote_db->get_results("INSERT INTO LEADS VALUES (null, '$email', '$firstname', '$lastname', '$date', '$approved_terms', '$source_code', '$country_iso', '$phone', '$utm', CURRENT_TIMESTAMP, '$referrer');");
        $remote_db->close();
      }
      // Update counter
      $count = (int)get_post_meta($form_id, 'count', true) ?: 0;
      $count = $count + 1;
      update_post_meta($form_id, 'count', $count);
      $counter_start_value = (int)$form_settings['counter'];
      return $count + $counter_start_value;
    } catch (Exception $e) {
      return $e;
    }
  }

  public static function get_count($args)
  {
    $source_code = $args['source_code'];
    $petition = new \WP_Query(array(
      'post_type' => 'leads-form',
      'post_status' => 'any',
      'meta_query' => array(
        array(
          'key' => 'form_settings_source_code',
          'value' => $source_code,
          'compare' => '=',
        )
      )
    ));
    if (!$petition->have_posts())
      // return new \WP_Error('not_found', "No petition with source_code '$source_code' could be found, returning 0.", array('status' => 404));
      //return new array with counter = 0
      return array('counter' => 0);
    $form = $petition->posts[0];
    $form_settings = get_field('form_settings', $form->ID);
    $count = (int)get_post_meta($form->ID, 'count', true) ?: 0;
    return array('counter' => $count + (int)$form_settings['counter']);
  }

  public static function set_count($args)
  {
    $source_code = $args['source_code'];
    $petition = new \WP_Query(array(
      'post_type' => 'leads-form',
      'post_status' => 'any',
      'meta_query' => array(
        array(
          'key' => 'form_settings_source_code',
          'value' => $source_code,
          'compare' => '=',
        )
      )
    ));
    if (!$petition->have_posts())
      // return new \WP_Error('not_found', "No petition with source_code '$source_code' could be found.", array('status' => 404));
      return array('counter' => 0);
    $form = $petition->posts[0];
    $form_settings = get_field('form_settings', $form->ID);
    // $count = (int)$form_settings['counter'] + 1;
    $count = (int)get_post_meta($form->ID, 'count', true) ?: 0;
    update_post_meta($form->ID, 'count', $count);
    // update_post_meta($form->ID, 'form_settings_counter', $count);
    return array('counter' => $count + (int)$form_settings['counter']);
  }

  public static function register_api_routes()
  {

    // Post Leads
    register_rest_route("gplp/v2", '/leads', array(
      'methods' => 'POST',
      'permission_callback' => "__return_true",
      'callback' => __NAMESPACE__ . '\\FormController::set',
    ));
    register_rest_route("gplp/v2", '/leads/count/(?P<source_code>.{1,})', array(
      'methods' => 'GET',
      'permission_callback' => "__return_true",
      'callback' => __NAMESPACE__ . '\\FormController::get_count',
    ));
    register_rest_route("gplp/v2", '/leads/count/(?P<source_code>.{1,})', array(
      'methods' => 'POST',
      'permission_callback' => "__return_true",
      'callback' => __NAMESPACE__ . '\\FormController::set_count',
    ));
  }
}
add_action('rest_api_init', __NAMESPACE__ . '\\FormController::register_api_routes');
