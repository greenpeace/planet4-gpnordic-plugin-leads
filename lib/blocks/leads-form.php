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
            /* * PATCH: Support for Planet 4 Master Theme Editor 
             * apiVersion 2 allows the block to render inside the modern iframe 
             * without crashing older ACF Pro 5.9 installations.
             */
            'apiVersion'        => 2,
            'supports'          => array(
                'jsx'   => true, // Required for modern block compatibility
                'align' => array('full', 'wide'),
            ),
        ));
    }
}

function block_enqueue_assets()
{
    wp_enqueue_script('vue', GPLP_PLUGIN_ROOT . 'public/js/vendor/vue.min.js', array(), '2.7.16', true);
    wp_enqueue_script('gsap', GPLP_PLUGIN_ROOT . 'public/js/vendor/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('lodash', GPLP_PLUGIN_ROOT . 'public/js/vendor/lodash.min.js', array(), '4.17.21', true);
}
add_action('acf/init', __NAMESPACE__ . '\\acf_blocks_init');

function admin_enqueue_scripts()
{
    wp_enqueue_script('vue', GPLP_PLUGIN_ROOT . 'public/js/vendor/vue.min.js', array(), '2.7.16', true);
    wp_localize_script('vue', 'gplp', array(
        'nonce' => wp_create_nonce('wp_rest'),
    ));
}

add_action('admin_enqueue_scripts',  __NAMESPACE__ . '\\admin_enqueue_scripts');
