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

      $date = date('Y-m-d');
      $utm = $args['utm']['value'];
      $source_code = get_field('form_settings', $form_id)['source_code'];
      $dbname = get_field('database_name', 'options');
      $username = get_field(
        'database_user',
        'options'
      );
      $password = get_field('database_password', 'options');
      $hostname = get_field('database_host', 'options');

      $count = 0;
      if (!strpos(get_site_url(), '.develop') && get_post_status($form_id) == 'publish') {
        $remote_db = new \wpdb($username, $password, $dbname, $hostname);
        $results = $remote_db->get_results("INSERT INTO LEADS VALUES (null, '$email', '$firstname', '$lastname', '$date', $approved_terms, '$source_code', '$country_iso', '$phone', '$utm', CURRENT_TIMESTAMP);");
        $remote_db->close();
      }
      // Update counter
      $count = (int)get_post_meta($form_id, 'count', true) ?: 0;
      $count = $count + 1;
      update_post_meta($form_id, 'count', $count);
      return $count;
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
      return new \WP_Error('not_found', "No petition with source_code '$source_code' could be found.", array('status' => 404));
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
      return new \WP_Error('not_found', "No petition with source_code '$source_code' could be found.", array('status' => 404));
    $form = $petition->posts[0];
    $form_settings = get_field('form_settings', $form->ID);
    // $count = (int)$form_settings['counter'] + 1;
    $count = (int)get_post_meta($form->ID, 'count', true) ?: 0;
    update_post_meta($form->ID, 'count', $count);
    // update_post_meta($form->ID, 'form_settings_counter', $count);
    return array('counter' => $count + (int)$form_settings['counter']);
  }

  // public static function get_country(){
  //   // $fetch_country = jQuery(window.location.pathname.split('/')[1]);
  //   $fetch_country = explode('/', $_SERVER['REQUEST_URI'])[1];

  //   return $fetch_country;
  //   echo '<script>console.log('$fetch_country')</script>';

  // }

  public static function register_api_routes()
  {

    $fetch_country = explode('/', $_SERVER['REQUEST_URI'])[1];

     // Post Leads
    register_rest_route($fetch_country."/gplp/v2", '/leads', array(
      'methods' => 'POST',
      'permission_callback' => "__return_true",
      'callback' => __NAMESPACE__ . '\\FormController::set',
    ));
    register_rest_route($fetch_country."/gplp/v2", '/leads/count/(?P<source_code>.{1,})', array(
      'methods' => 'GET',
      'permission_callback' => "__return_true",
      'callback' => __NAMESPACE__ . '\\FormController::get_count',
    ));
    register_rest_route($fetch_country."/gplp/v2", '/leads/count/(?P<source_code>.{1,})', array(
      'methods' => 'POST',
      'permission_callback' => "__return_true",
      'callback' => __NAMESPACE__ . '\\FormController::set_count',
    ));

  }
}
add_action('rest_api_init', __NAMESPACE__ . '\\FormController::register_api_routes');
