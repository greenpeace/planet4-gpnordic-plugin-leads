<?php
// Returns the "Form Settings" field group
function get_multistep_settings()
{
    $shared_donate_fields = get_shared_donate_fields();

    $multistep_settings = new StoutLogic\AcfBuilder\FieldsBuilder('multistep_settings');
    $multistep_settings

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
                'max' => 3,
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
            ->addText('thank_you_share_button_caption', ['default_value' => 'Of course!'])
            ->addText('thank_you_skip_button_caption', ['default_value' => 'No thank you'])
            ->addTab('share')
            ->addText('share_headline')
            ->addWysiwyg('share_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
            ->addTab('custom_ask')
            ->addText('custom_ask_headline')
            ->addWysiwyg('custom_ask_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
            ->addRepeater('custom_ask_buttons', ['max' => 2, 'layout' => 'block'])
                ->addText('button_caption')
                ->addUrl('button_url')
                ->addColorPicker('button_color', ['default_value' => '#000000'])
                ->addColorPicker('button_text_color', ['default_value' => '#FFFFFF'])
            ->endRepeater()
            ->addTab('donation')
            ->addText('donation_headline')
            ->addWysiwyg('donation_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
            ->addNumber('donate_default_amount', $shared_donate_fields['donate_default_amount'])
            ->addTrueFalse('enable_donation_amount', $shared_donate_fields['enable_donation_amount'])
            ->addRepeater('donate_preset_amounts', ['instructions' => 'Fill in preset amounts if desired.', 'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_donation_amount',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ]])
                ->addNumber('amount')
            ->endRepeater()
            ->addText('donate_cta', $shared_donate_fields['donate_cta'])
            ->addText('donate_url', $shared_donate_fields['donate_url'])
            ->addTab('final')
            ->addText('final_all_completed_headline')
            ->addWysiwyg('final_all_completed_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
            ->addText('final_all_completed_button_caption')
            ->addUrl('final_all_completed_button_url')
            ->addText('final_incomplete_headline')
            ->addWysiwyg('final_incomplete_description', ['tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0, 'delay' => 0])
            ->addText('final_incomplete_button_caption')
            ->addUrl('final_incomplete_button_url')
        ->endGroup()
        ;
    return $multistep_settings;
}
