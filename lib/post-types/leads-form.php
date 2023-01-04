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
      $page_ids = array('post_status' => array('draft', 'pending', 'future', 'private', 'publish'));
      $cache_key = 'pages_with_post_id_' . $post_id;
      $pages = wp_cache_get($cache_key);
      if (false === $pages) {
        $pages = get_pages($page_ids);
        wp_cache_set($cache_key, $pages);
      }
      $all_pages = count($pages);
      $page_statuses = [];
      $page_contents = [];


      $status_labels = [
        'draft' => '<span style="padding-left:0.2rem;color:darkorange;"><small> (Draft) </small></span>',
        'publish' => '<span style="padding-left:0.2rem;color:green;"><small> (Published) </small></span>',
        'pending' => '<span style="padding-left:0.2rem;color:darkorange;"><small> (Pending) </small></span>',
        'future' => '<span style="padding-left:0.2rem;color:green;"><small> (Scheduled) </small></span>',
        'private' => '<span style="padding-left:0.2rem;color:darkorange;"><small> (Private) </small></span>'
      ];

      if (is_array($pages) || is_object($pages)) {
        for ($i = 0; $i < $all_pages; $i++) {
          $page = $pages[$i];
          $page_id = $page->ID;
          $page_title = $page->post_title;
          $page_content = $page->post_content;
          $page_status = get_post_status($page_id, 'any');
          $page_edit_link = get_edit_post_link($page_id);

          if (!array_key_exists($page_id, $page_statuses)) {
          $page_statuses[$page_id] = $page_status;
          }
          if (!array_key_exists($page_id, $page_contents)) {
          $page_contents[$page_id] = apply_filters('the_content', $page_content);
          }

          $page_permalink = get_permalink($page_id);
          $page_meta = get_post_meta($page_id);

            $page_status = $status_labels[$page_statuses[$page_id]] ?? '<span style="padding-left:0.2rem;color:darkorange;"><small> (Draft) </small></span>';
            if (strpos($page_contents[$page_id], 'data-form-id="' . $post_id . '"') !== false) {
              $font_end = '<strong><a href="' . $page_permalink . '" target="_blank">' . $page_title . '</a></strong>' . $page_status . '</br>';
              echo $font_end;
            }
        }
      }
  break;
  }
}
add_action('manage_leads-form_posts_custom_column', __NAMESPACE__ . '\\leads_custom_column', 10, 2);
