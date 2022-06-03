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
      $page_ids = array('post_status' => array('auto-draft', 'draft', 'publish', 'pending', 'future', 'private', 'inherit'));
      $pages = get_pages($page_ids);

      if (is_array($pages) || is_object($pages))
      {
        foreach ($pages as $page) {
          //add to the page_ids array the page id, title, content, permalink, edit page link, page meta, and post id (for the delete link)
          $page_id = $page->ID;
          $page_title = $page->post_title;
          $page_content = $page->post_content;
          $page_permalink = get_permalink($page->ID);
          $page_edit_link = get_edit_post_link($page->ID);
          $page_page_meta = get_post_meta($page->ID);
          $page_post_id = $post_id;
          $page_status = get_post_status($page_id, 'auto-draft', 'draft', 'publish', 'pending', 'future', 'private', 'inherit');
          //parse the contents
          $page_content = apply_filters('the_content', $page_content);

          //switch case the post status
          switch ($page_status) {
            case $page_status == 'auto-draft':
              $page_status = '<span style="padding-left:0.2rem;color:darkorange;"><small> (Draft) </small></span>';
              break;

            case $page_status == 'draft':
              $page_status = '<span style="padding-left:0.2rem;color:darkorange;"><small> (Draft) </small></span>';
              break;

            case $page_status == 'publish':
              $page_status = '<span style="padding-left:0.2rem;color:green;"><small> (Published) </small></span>';
              break;

            case $page_status == 'pending':
              $page_status = '<span style="padding-left:0.2rem;color:darkorange;"><small> (Pending) </small></span>';
              break;

            case $page_status == 'future':
              $page_status = '<span style="padding-left:0.2rem;color:green;"><small> (Scheduled) </small></span>';
              break;

            case $page_status == 'private':
              $page_status = '<span style="padding-left:0.2rem;color:darkorange;"><small> (Private) </small></span>';
              break;

            default:
              $page_status = '<span style="padding-left:0.2rem;color:darkorange;"><small> (Inherit) </small></span>';
              break;
          }

          $dom = new \DOMDocument();
          @$dom->loadHTML($page_content);
          $xpath = new \DOMXPath($dom);
          $page_attrs = $xpath->query('//div[@data-form-id]');
          //convert the $page_attrs to an array and then loop through it
          $page_attrs_array = array();
          foreach ($page_attrs as $page_attr) {
            $page_attrs_array[] = $page_attr->getAttribute('data-form-id');
          }
          //if the current post id is in the array then list the page
          if (in_array($post_id, $page_attrs_array)) {
            echo '<a href="' . $page_permalink . '" target="_blank">' . $page_title . '</a>' . $page_status . '<br>';
          }

          //loop throught the post_id array and if the current post_id matcher the page_attrs_array then list the page
          // foreach ($page_attrs_array as $page_attr_array) {
          //   if ($post_id == $page_attr_array) {
          //     echo '<a href="' . $page_permalink . '" target="_blank">' . $page_title . '</a>' . $page_status . '<br>';
          //   }
          // }

          //if the current post id value is equal to the 'data-form-id' value display it
          // if (strpos($page_content, 'data-form-id="' . $page_attrs . '"') == $post_id) {
          //   // echo 'Form id: ' . $post_id . '<br>';
          //   $font_end = '<strong><a href="' . $page_permalink . '" target="_blank">' . $page_title . '</a></strong>' . $page_status . '</br>';
          //   // $back_end = '<strong><a href="' . $page_edit_link . '" target="_blank"> Editor page: ' . $page_title . '</a></strong></br></br>';
          //   echo $font_end;
          //   // echo $back_end;
          // }
        }
      }
      else {
        exit;
      }
    break;
  }
}
add_action('manage_leads-form_posts_custom_column', __NAMESPACE__ . '\\leads_custom_column', 10, 2);

