<?php
// Returns the "Apperance Settings" field group
function get_appearance_settings()
{
    $appearance = new StoutLogic\AcfBuilder\FieldsBuilder('appearance');
    $appearance->addGroup('form_styles', [
        'label' => 'Styles',
    ])
        ->addRadio('placement', [
            'label' => 'Placement',
            'choices' => [
                'left' => 'Align Left',
                'right' => 'Align Right',
            ],
        ])
        ->addGroup('colors', [
            'label' => 'Colors',
        ])
        ->addRadio('theme', [
            'label' => 'Theme',
            'choices' => [
                'light' => 'Light',
                'dark' => 'Dark',
            ],
        ])
        ->addColorPicker('form_headline', [
            'label' => 'Main color',
            'instructions' => 'Applied to backgrounds of buttons/icons, links and the form heading.',
            'default_value' => '#73BE1E',
        ])
        ->addColorPicker('cta_background', [
            'label' => 'Background overlay',
            'instructions' => 'Applied to the background image and counter element. If the dark theme is selected, this color is applied to the form instead.',
            'default_value' => '#000000',
        ])
        ->addColorPicker('cta_text', [
            'label' => 'Text color',
            'instructions' => 'Applied to the text in the form and counter element.',
            'default_value' => '#ffffff',
        ])
        ->addColorPicker('error', [
            'label' => 'Error color',
            'instructions' => 'Used for error messages and incomplete steps.',
            'default_value' => '#FF785A',
        ])
        ->addColorPicker('success', [
            'label' => 'Success color',
            'instructions' => 'Used for complete steps.',
            'default_value' => '#73BE1E',
        ])
        ->endGroup();

    return $appearance;
}
