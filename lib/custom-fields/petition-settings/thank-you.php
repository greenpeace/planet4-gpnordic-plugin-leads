<?php
// Returns the "Thank You Settings" field group
function get_thank_you_settings()
{
    $shared_donate_fields = get_shared_donate_fields();
    $thank_you_settings = new StoutLogic\AcfBuilder\FieldsBuilder('thank_you_settings');
    $thank_you_settings->addGroup('thank_you_settings', [
        'conditional_logic' => [
            [
                [
                    'field' => 'form_type',
                    'operator' => '!=',
                    'value' => 'multistep',
                ],
            ],
        ],
    ])
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
        ->addTrueFalse('enable_donation_amount', $shared_donate_fields['enable_donation_amount'])
        ->addNumber('donate_default_amount', $shared_donate_fields['donate_default_amount'])
        ->addText('donate_cta', $shared_donate_fields['donate_cta'])
        ->addText('donate_url', $shared_donate_fields['donate_url'])
        ;
    return $thank_you_settings;
}
