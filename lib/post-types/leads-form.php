<?php

namespace GPLP;

// Create post type
function create_leads_post_type()
{
  register_post_type(
    'leads-form',
    array(
      'labels' => array(
        'name' => __('Petitions'),
        'singular_name' => __('Petition')
      ),
      'public' => true,
      'has_archive' => false,
      'publicly_queryable' => false,
      'supports' => array('title', 'thumbnail'),
      'menu_icon' => 'dashicons-welcome-write-blog',
    )
  );
}
add_action('init', __NAMESPACE__ . '\\create_leads_post_type');


function add_acf_columns_to_leads($columns)
{
  return array_merge($columns, array(
    'sourcecode' => __('Campaign code'),
    'live'   => __('Live'),
    'author'   => __('Created by'),
    'included'   => __('Published on page(s)'),
  ));
}
add_filter('manage_leads-form_posts_columns', __NAMESPACE__ . '\\add_acf_columns_to_leads');

function leads_custom_column($column, $post_id)
{
  switch ($column) {
    case 'sourcecode':
      echo get_post_meta($post_id, 'form_settings_source_code', true);
      break;
    case 'live':
      echo get_post_status($post_id) == 'publish' ? '<span style="color:green;">Yes</span>' : '<span style="color:darkorange;">No</span>';
      break;
    case 'included':
      $status_labels = [
        'draft', 'auto-draft' => '<span style="padding-left:0.2rem;color:darkorange;"><small> (Draft) </small></span>',
        'publish' => '<span style="padding-left:0.2rem;color:green;"><small> (Published) </small></span>',
        'pending' => '<span style="padding-left:0.2rem;color:darkorange;"><small> (Pending) </small></span>',
        'future' => '<span style="padding-left:0.2rem;color:green;"><small> (Scheduled) </small></span>',
        'private' => '<span style="padding-left:0.2rem;color:darkorange;"><small> (Private) </small></span>'
      ];

      global $wpdb;

      try {
        $results = $wpdb->get_results( "SELECT ID, post_title, post_content, post_status FROM $wpdb->posts WHERE post_content LIKE '%wp:acf/leads-form%'AND post_status IN ('publish','draft','auto-draft','pending','future','private')" );
        $pages = array();
        //iterrating obver the results and assigning values for each page to variables
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
          if(isset($form_id[1]) && $form_id[1] == $post_id) {
              echo '<a href="' . $page_permalink . '" target="_blank">' . $page_title . '</a>' . $page_status . '<br>';
          }
        }
      } catch (exception $e) {
          echo 'Error: ' . $e->getMessage();
      }
    break;
  }
}
// add_action('manage_leads-form_posts_custom_column', __NAMESPACE__ . '\\leads_custom_column', 10, 2);

// Add a placeholder element to petition column so it can be accessed with JS
function leads_custom_column_placeholder($column, $post_id) {
  switch($column) {
    case "included" : echo "<div class='petition-custom-column-placeholder' id='$post_id'></div>";
  }
}


add_action('manage_leads-form_posts_custom_column', __NAMESPACE__ . '\\leads_custom_column_placeholder', 10, 2);


// add_action('save_post', __NAMESPACE__ . '\\check_petitions_publish_locations', 10, 3);
