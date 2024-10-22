<?php

namespace GPLP;

function acf_blocks_init()
{
    $plugin_data = get_plugin_data(GPLP_PLUGIN_ROOT_FILE);
    // Check function exists.
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'leads-form',
            'title'             => __('Petition Form'),
            'description'       => __('Select a petition form and how it should be displayed.'),
            'render_template'   => GPLP_PLUGIN_ROOT_URI . 'templates/blocks/leads-form/leads-form.php',
            'enqueue_style'     => GPLP_PLUGIN_ROOT . 'public/css/app.css?v=' . $plugin_data['Version'],
            'enqueue_script'    => GPLP_PLUGIN_ROOT . 'public/js/modules/leads-form.js?v=' . $plugin_data['Version'],
            'category'          => 'planet4-blocks',
            'icon'              => 'welcome-write-blog',
            'enqueue_assets'    => __NAMESPACE__ . '\\block_enqueue_assets',
        ));
    }
}

function block_enqueue_assets()
{
    wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2', array(), '', true);
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '', true);
    wp_enqueue_script('lodash', GPLP_PLUGIN_ROOT . '/bower_components/lodash/dist/lodash.min.js', array(), '', true);
}
add_action('acf/init', __NAMESPACE__ . '\\acf_blocks_init');

function admin_enqueue_scripts()
{
    wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2', array(), '', true);
    wp_localize_script('vue', 'gplp', array(
        'nonce' => wp_create_nonce('wp_rest'),
    ));
}

add_action('admin_enqueue_scripts',  __NAMESPACE__ . '\\admin_enqueue_scripts');
