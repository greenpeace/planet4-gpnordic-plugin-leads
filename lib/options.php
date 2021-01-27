<?php

/* Register options page */
function gplp_add_options_page() {
	acf_add_options_page();
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Leads Form',
		'menu_title' 	=> 'Options',
		'slug' => 'acf-options-leads-form',
		'parent_slug'	=> 'edit.php?post_type=leads-form',
	));
}
add_action( 'after_setup_theme', 'gplp_add_options_page' );
