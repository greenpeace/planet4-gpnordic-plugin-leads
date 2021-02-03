<?php

namespace GPLP;

function acf_blocks_init()
{
    $plugin_data = get_plugin_data(GPLP_PLUGIN_ROOT_FILE);
    // Check function exists.
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'leads-form',
            'title'             => __('Leads Form'),
            'description'       => __('A custom leads form.'),
            'render_template'   => GPLP_PLUGIN_ROOT_URI . 'templates/blocks/leads-form/leads-form.php',
            'enqueue_style'     => GPLP_PLUGIN_ROOT . 'css/app.css?v=' . $plugin_data['Version'],
            'enqueue_script'    => GPLP_PLUGIN_ROOT . 'public/js/modules/leads-form.js?v=' . $plugin_data['Version'],
            'category'          => 'widgets',
            'icon'              => 'welcome-write-blog',
            'enqueue_assets'    => __NAMESPACE__ . '\\block_enqueue_assets',
        ));
    }
}

function block_enqueue_assets() {
    wp_enqueue_script('vue', GPLP_PLUGIN_ROOT . '/bower_components/vue/dist/vue.min.js', array(), '', true);
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js', array(), '', true);
    wp_enqueue_script('lodash', 'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.20/lodash.min.js', array(), '', true);
}
add_action('acf/init', __NAMESPACE__ . '\\acf_blocks_init');
