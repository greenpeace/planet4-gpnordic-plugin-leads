<?php
include_once('petition-settings/donate.php');
include_once('petition-settings/thank-you.php');
include_once('petition-settings/hero.php');
include_once('petition-settings/multistep.php');
include_once('petition-settings/form.php');
include_once('petition-settings/appearance.php');

// Define your field group using the FieldsBuilder class
$option_fields = new StoutLogic\AcfBuilder\FieldsBuilder('Options', [
    'title' => 'Petition Settings',
    'style' => 'seamless',
]);
$option_fields->setLocation('post_type', '==', 'leads-form');

// Add fields to the "Form Settings" group
$form_settings = get_form_settings();
$option_fields->addFields($form_settings);

// Add fields to the "Hero Settings" group
$hero_settings = get_hero_settings();
$option_fields->addFields($hero_settings);

// Add fields to the "Multisteps" group
$multistep_settings = get_multistep_settings();
$option_fields->addFields($multistep_settings);

// Add fields to the "Thank You Settings" group
$thank_you_settings = get_thank_you_settings();
$option_fields->addFields($thank_you_settings);

// Build the field group and register it with ACF
acf_add_local_field_group($option_fields->build());

$appearance_fields = new StoutLogic\AcfBuilder\FieldsBuilder('Appearance', [
    'title' => 'Petition Settings',
    'style' => 'seamless',
    'position' => 'side',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
]);
$appearance_fields->setLocation('post_type', '==', 'leads-form');

// Add fields to the "Appearance Settings" group
$appearance_settings = get_appearance_settings();
$appearance_fields->addFields($appearance_settings);
// acf_add_local_field_group($appearance_fields->build());

$extra_options = new StoutLogic\AcfBuilder\FieldsBuilder('extra_options', [
    'title' => 'Extra Options',
    'style' => 'seamless',
    'position' => 'side',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
]);

$extra_options->setLocation('post_type', '==', 'leads-form')
    ->addGroup('extra_options')
    ->addImage('small_screen_image', [
        'label' => 'Small screen image',
        'instructions' => 'Can be used for when the selected background image (featured image) does not look ideal on e.g. mobile.',
        'return_format' => 'array',
        'preview_size' => 'thumbnail',
        'library' => 'all',
    ])
    ->endGroup();

$appearance_fields->addFields($extra_options);
acf_add_local_field_group($appearance_fields->build());
