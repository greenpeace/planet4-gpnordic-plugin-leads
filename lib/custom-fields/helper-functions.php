<?php
function load_counter_api_field($field)
{
    $rest_url = get_rest_url();
    $source_code = get_post_meta(get_the_ID(), 'form_settings_source_code', true);
    $field['instructions'] = "The endpoint for this form is <strong>{$rest_url}gplp/v2/leads/count/$source_code</strong>";
    return $field;
}
add_filter('acf/load_field/name=counter_api-endpoints', 'load_counter_api_field');

function load_consent_message_field($field)
{
    $default_value = get_option('options_form_fields_translations_terms_agree');
    $field['default_value'] = $default_value;
    return $field;
}
add_filter('acf/load_field/name=consent_message', 'load_consent_message_field');

function load_donate_url_field($field)
{
    $default_value = get_option('options_form_fields_translations_donate_url_option');
    $field['default_value'] = $default_value;
    return $field;
}
add_filter('acf/load_field/name=donate_url', 'load_donate_url_field');
