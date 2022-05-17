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
      echo get_post_status($post_id) == 'publish' ? '<span style="color:darkgreen;">Yes</span>' : '<span style="color:darkorange;">No</span>';
      break;
    case 'included':
      $pages = get_pages();
      $page_ids = array();
      foreach ($pages as $page) {
        $page_ids[] = $page->ID;
        $page_title = $page->post_title;
        $page_content = $page->post_content;
        $page_id = $page->ID;
        $page_status = $page->post_status;
        if ($page_status == 'publish') {
          $page_status = '<small style="padding-left:0.2rem;"> (Published) </small>';
        } else if ($page_status == 'draft') {
          $page_status = '<span style="padding-left:0.2rem;"><small> (Draft) </small></span>';
        } else {
          $page_status = '<span style="padding-left:0.2rem;"><small> (Pending review) </small></span>';
        }
        $page_content = $page->post_content;
        $page_permalink = get_permalink($page_id);
        $page_meta = get_post_meta($page_id);
        //parse the contents
        $page_content = apply_filters('the_content', $page_content);
          //if the post id is equal to the 'data-form-id' value
          if (strpos($page_content, 'data-form-id="' . $post_id . '"') !== false) {
            echo '<strong><a href="' . $page_permalink . '" target="_blank">' . $page_title . '</a></strong>' . $page_status . '</br>';
          }
      }
    break;
  }
}
add_action('manage_leads-form_posts_custom_column', __NAMESPACE__ . '\\leads_custom_column', 10, 2);

