<?php
// Returns the "Form Settings" field group
function get_form_settings()
{
    $form_settings = new StoutLogic\AcfBuilder\FieldsBuilder('form_settings');
    $form_settings
        ->addSelect('form_type', [
            'label' => 'Form type',
            'instructions' => 'Select the type of form you want to use.',
            'choices' => [
                'default' => 'Default',
                'multistep' => 'Multi-step',
            ],
            'default_value' => 'petition',
            'layout' => 'vertical',
            'allow_null' => 0,
            'return_format' => 'value',
        ])
        ->addGroup('steps', [
            'conditional_logic' => [
                [
                    [
                        'field' => 'form_type',
                        'operator' => '==',
                        'value' => 'multistep',
                    ],
                ],
            ],
        ])
        ->addRepeater('step', [
            'label' => 'Steps',
            'instructions' => 'Add the steps for the multi-step form (first and last step is not editable)',
            'layout' => 'block',
            'button_label' => 'Add step',
        ])
            ->addSelect('select_step', [
                'label' => 'Step',
                'instructions' => 'Select the step',
                'choices' => [
                    'share' => 'Share',
                    'custom_ask' => 'Custom Ask',
                    'donation' => 'Donation',
                ],
                'default_value' => 'petition',
                'layout' => 'vertical',
                'allow_null' => 0,
                'return_format' => 'value',
            ])
        ->endRepeater()
        ->addTab('thank_you')
        ->addText('thank_you_headline')
        ->addWysiwyg('thank_you_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
        ->addText('thank_you_share_button_caption', ['default_value' => 'Share'])
        ->addText('thank_you_skip_button_caption', ['default_value' => 'Skip'])
        ->addTab('share')
        ->addText('share_headline')
        ->addWysiwyg('share_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
        ->addText('share_copy_url_button_caption', ['default_value' => 'Share'])
        ->addText('share_skip_button_caption', ['default_value' => 'Skip'])
        ->addTab('custom_ask')
        ->addText('custom_ask_headline')
        ->addWysiwyg('custom_ask_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
        ->addText('custom_ask_button_caption', ['default_value' => 'Share'])
        ->addUrl('custom_ask_button_url')
        ->addColorPicker('custom_ask_button_color', ['default_value' => '#000000'])
        ->addTab('donation')
        ->addText('donation_headline')
        ->addWysiwyg('donation_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
        ->addTab('final')
        ->addText('final_headline')
        ->addWysiwyg('final_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
        ->addText('final_copy_url_button_caption', ['default_value' => 'Share'])
        ->addUrl('final_skip_button_url')
        ->endGroup()
        ->addGroup('form_settings')
        ->addText('source_code', [
            'label' => 'Campaign code',
        ])
        ->addRadio('consent_method', [
            'label' => 'Consent method',
            'choices' => array(
                'checkbox_checked' => 'Checkbox (checked)',
                'checkbox_unchecked' => 'Checkbox (unchecked)',
                'assumed' => 'No checkbox (assuming legitimate interest)',
            ),
            'default_value' => 'assumed',
            'layout' => 'vertical',
            'return_format' => 'value',
        ])
        ->addWysiwyg('consent_message', [
            'label' => 'Consent message',
            'instructions' => 'This is the default consent message. Only change this message if the data-handling deviates from the norm.',
            'default_value' => 'This is the default consent message. Only change this message if the data-handling deviates from the norm.',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
        ])
        ->addRadio('collapse_inputs', [
            'label' => 'Collapse inputs',
            'instructions' => 'Collapse the inputs into a single line on mobile.',
            'choices' => [
                'collapse' => 'Only show e-mail input until active',
                'expand' => 'Show all form-fields from start',
            ],
            'default_value' => 'collapse',
            'layout' => 'vertical',
            'allow_null' => 0,
            'return_format' => 'value',
        ])
        ->addTrueFalse('enable_counter', [
            'label' => 'Enable counter',
            'message' => 'Display the counter',
            'instructions' => 'Toggle the counter elements on both the form and the thank you page. The counter is always counting behind-the-scenes, which means this can be turned on at a later stage.',
            'default_value' => 1,
            'ui' => 1,
        ])
        ->addNumber('counter', [
            'label' => 'Counter start value',
            'instructions' => 'The counter will start counting from this value.',
            'default_value' => 0,
            'min' => 0,
            'conditional_logic' => [
                [
                    [
                        'field' => 'enable_counter',
                        'operator' => '==',
                        'value' => '1',
                    ],
                ],
            ],
        ])
        ->addNumber('counter_goal_value', [
            'label' => 'Counter goal value',
            'default_value' => 0,
            'min' => 0,
            'conditional_logic' => [
                [
                    [
                        'field' => 'enable_counter',
                        'operator' => '==',
                        'value' => '1',
                    ],
                ],
            ],
        ])
        ->addRepeater('counter_api-endpoints', [
            'label' => 'Counter API endpoints',
            'instructions' => 'Every petition has an API-endpoint. By adding other petition API-endpoints to this list, the counter value of each will be added to this petition\'s displayed counter value.',
            'conditional_logic' => [
                [
                    [
                        'field' => 'enable_counter',
                        'operator' => '==',
                        'value' => '1',
                    ],
                ],
            ],
        ])
        ->addUrl('endpoint', [
            'label' => 'Endpoint',
        ])
        ->endRepeater('counter_api-endpoints')
        ->addRadio('phone', [
            'label' => 'Phone number field',
            'instructions' => '',
            'choices' => [
                'required' => 'Enabled (required)',
                'optional' => 'Enabled (optional)',
                'false' => 'Disabled',
            ],
            'default_value' => 'optional',
            'layout' => 'vertical',
            'return_format' => 'value',
        ])
        ->addTextarea('headline', [
            'label' => 'Form headline',
            'instructions' => 'A short call to action is recommended.',
            'default_value' => '',
            'placeholder' => 'Headline',
            'maxlength' => 140,
            'rows' => '',
            'new_lines' => 'br',
        ])
        ->addWysiwyg('description', [
            'label' => 'Form description',
            'instructions' => 'A small elaboration on the call to action.',
            'default_value' => '',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
        ])
        ->addText('call_to_action', [
            'label' => 'Form button text',
            'instructions' => 'The called-for action. (sign now, join, stay updated, etc)',
            'default_value' => '',
            'placeholder' => 'Call to action',
            'maxlength' => 40,
        ])
        ->endGroup();
    return $form_settings;
}
