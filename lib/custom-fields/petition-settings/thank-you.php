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
        'description' => 'Settings for the thank you page that the signer is redirected to after signing the petition.'
    ])
        ->addMessage(
            'thank_you_settings_message',
            'The thank you page is automatically generated based on the petition settings. The settings below allow you to customize the thank you page.<br/>Available variables:<ul><li><code>${fname}</code> - signers first name</li><li><code>${counterCurrent}</code> - counter current value</li><li><code>${counterGoal}</code> - counter goal value</li></ul>',
            [
                'label' => 'Variable reference'
            ]
        )
        ->addText('headline', [
            'label' => 'Thank you headline',
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
        ->addText('donate_url', $shared_donate_fields['donate_url']);
    return $thank_you_settings;
}
