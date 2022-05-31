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
      $page_ids = array('post_status' => array('draft', 'pending', 'future', 'private', 'publish', 'auto-draft', 'inherit'));
      $pages = get_pages($page_ids);

      if (is_array($pages) || is_object($pages))
      {
        foreach ($pages as $page) {
          $page_ids[] = $page->ID;
          $page_title = $page->post_title;
          $page_content = $page->post_content;
          $page_id = $page->ID;
          $page_status = get_post_status($page_id, 'any');
          $page_edit_link = get_edit_post_link($page_id);

          //add the page status to the array
          $page_ids[] = $page_status;
          $page_ids[] = $page_edit_link;

          $user = is_user_logged_in() ? wp_get_current_user() : null;
          //returns true if the user is allowed to see the page
          $user_can_see_page = user_can($user, 'read_post', $page_id);
          if ($user_can_see_page) {
            $page_ids[] = $page_id;
          }
          //check and add it to the array
          if ($user_can_see_page !== null && $page_status == 'publish' || $page_status == 'draft' || $page_status == 'pending' || $page_status == 'future' || $page_status == 'private') {
            $page_ids[] = $page_id;
          }
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

          // $page_content = $page->post_content;
          $page_permalink = get_permalink($page_id);
          $page_meta = get_post_meta($page_id);
          //parse the contents
          $page_content = apply_filters('the_content', $page_content);
          //if the post id is equal to the 'data-form-id' value and display it
          if (strpos($page_content, 'data-form-id="' . $post_id . '"') !== false) {
            $font_end = '<strong><a href="' . $page_permalink . '" target="_blank">' . $page_title . '</a></strong>' . $page_status . '</br>';
            // $back_end = '<strong><a href="' . $page_edit_link . '" target="_blank"> Editor page: ' . $page_title . '</a></strong></br></br>';
            echo $font_end;
            // echo $back_end;
          }
        }
      }
    break;
  }
}
add_action('manage_leads-form_posts_custom_column', __NAMESPACE__ . '\\leads_custom_column', 10, 2);

