<?php

$petition_options = new \StoutLogic\AcfBuilder\FieldsBuilder('Petition-wide Settings');
$petition_options->setLocation('options_page', '==', 'acf-options-leads-form')
    ->addTab('Connection', [
        'placement' => 'top',
    ])
    ->addText('database_host', [
        'label' => 'Host',
        'instructions' => 'The host of the database where the leads are stored.',
        'required' => true,
    ])
    ->addText('database_name', [
        'label' => 'Database Name',
        'instructions' => 'The name of the database where the leads are stored.',
        'required' => true,
    ])
    ->addText('database_user', [
        'label' => 'Database User',
        'instructions' => 'The user of the database where the leads are stored.',
        'required' => true,
    ])
    ->addPassword('database_password', [
        'label' => 'Database Password',
        'instructions' => 'The password of the database where the leads are stored.',
        'required' => true,
    ])
    ->addTextarea('ssl_certificate', [
        'label' => 'SSL Certificate',
        'instructions' => 'The SSL certificate used to connect to the database.',
    ])
    ->addTab('form_settings', [
        'placement' => 'top',
    ])
    ->addText('country_code_iso', [
        'label' => 'Country Code ISO',
        'instructions' => 'The country code ISO used to identify the country of the lead.',
        'required' => true,
        'default_value' => 'US',
    ])
    ->addGroup('form_fields_translations', [
        'label' => 'Defaults & translations',
        'layout' => 'block',
    ])
    ->addText('goal', [
        'label' => 'Goal',
        'default_value' => 'Goal',
    ])
    ->addText('signed_up', [
        'label' => 'Signed up',
        'default_value' => 'Signed up',
    ])
    ->addText('read_more', [
        'label' => 'Read More',
        'default_value' => 'Read More',
    ])
    ->addText('read_less', [
        'label' => 'Read Less',
        'default_value' => 'Read Less',
    ])
    ->addText('first_name', [
        'label' => 'First Name',
        'default_value' => 'First Name',
    ])
    ->addText('last_name', [
        'label' => 'Last Name',
        'default_value' => 'Last Name',
    ])
    ->addText('email', [
        'label' => 'Email',
        'default_value' => 'Email',
    ])
    ->addText('phone', [
        'label' => 'Phone',
        'default_value' => 'Phone',
    ])
    ->addText('country_code', [
        'label' => 'Country Code',
        'default_value' => '+46',
    ])
    ->addText('sending', [
        'label' => 'Sending',
        'default_value' => 'Sending...',
    ])
    ->addText('donate_currency', [
        'label' => 'Donation Currency',
        'default_value' => '€',
    ])
    ->addNumber('donate_minimum_amount', [
        'label' => 'Minimum Donation Amount',
        'default_value' => 10,
    ])
    ->addText('donate_url_option', [
        'label' => 'Donation URL',
        'default_value' => 'donate_url',
        'instructions' => 'Amount is replaced if written as: %amount%',
        'default_value' => 'https://stod.greenpeace.org/checkout?amount=%amount%&page=engangsgava',
    ])
    ->addWysiwyg('terms_agree', [
        'label' => 'Consent Message',
        'default_value' => 'I agree to the terms and conditions',
        'toolbar' => 'basic',
        'media_upload' => 0,
    ])
    ->addText('error_required', [
        'label' => 'Error (Required)',
        'default_value' => 'This field is required',
        'instructions' => 'The variable ${fieldName} inserts the field name.',
        'default_value' => 'Required field "${fieldName}" has no value.',
    ])
    ->addText('error_format', [
        'label' => 'Error (Format)',
        'instructions' => 'The variable ${fieldName} inserts the field name.',
        'default_value' => 'Field "${fieldName}" has wrong format.',
    ])
    ->addText('error_format_phone', [
        'label' => 'Error (Phone format)',
        'instructions' => 'Write a custom error message with the allowed phone format.',
        'default_value' => 'Ops, the field "Telephone number" has the wrong format. Use 8 digits without spaces.',
    ])
    ->addText('multistep_skip_step')
    ->addText('multistep_go_back_step')
    ;

acf_add_local_field_group($petition_options->build());
