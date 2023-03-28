<?php
// Returns the "Thank You Settings" field group
function get_thank_you_settings()
{
    $thank_you_settings = new StoutLogic\AcfBuilder\FieldsBuilder('thank_you_settings');
    $thank_you_settings->addGroup('thank_you_settings')
        ->addText('headline', [
            'label' => 'Thank you headline',
            'instructions' => 'The variable ${fname} can be used to include the signers name.',
            'default_value' => 'Thank you, ${fname}!',
        ])
        ->addWysiwyg('description', [
            'label' => 'Thank you description',
            'instructions' => 'Tell the signer why we are thankful, what difference their signature will make, etc.',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
        ])
        ->addText('share_headline', [
            'label' => 'Share block headline',
            'default_value' => 'Share',
        ])
        ->addWysiwyg('share_description', [
            'label' => 'Share block description',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
        ])
        ->addText('donate_headline', [
            'label' => 'Donation ask headline',
            'default_value' => 'Donate',
        ])
        ->addWysiwyg('donate_description', [
            'label' => 'Donation ask description',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
        ])
        ->addTrueFalse('enable_donation_amount', [
            'label' => 'Enable default donation amount',
            'instructions' => 'Allow users to change the pre-defined amount, by showing the input field on the thank you page.',
            'message' => 'Display the pre-defined donation amount field',
            'default_value' => 1,
            'ui' => 1,
        ])
        ->addNumber('donate_default_amount', [
            'label' => 'Default donation amount',
            'instructions' => 'The default donation amount in EUR.',
            'default_value' => 10,
            'min' => 1,
            'max' => 1000,
            'step' => 1,
        ])
        ->addText('donate_cta', [
            'label' => 'Donation button text',
            'default_value' => 'Donate now',
        ])
        ->addText('donate_url', [
            'label' => 'Donation page URL',
            'instructions' => 'The checkout URL of the donation page, where %amount% is replaced by the user selected amount. The donation page can be changed by merely changing the \'page\' value in the URL below.',
            'default_value' => '',
        ]);
    return $thank_you_settings;
}
