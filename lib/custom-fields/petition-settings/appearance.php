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
        ->endGroup();
    return $appearance;
}


/*
    acf_add_local_field_group(array(
        'key' => 'group_5f96dbc96094b',
        'title' => 'Appearance',
        'fields' => array(
            array(
                'key' => 'field_5f96dbd8037d6',
                'label' => 'Styles',
                'name' => 'form_styles',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_5f96dbfb037d7',
                        'label' => 'Placement',
                        'name' => 'placement',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'left' => 'Align Left',
                            'right' => 'Align Right',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'vertical',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_5f96dc4c037d9',
                        'label' => 'Colors',
                        'name' => 'colors',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5f96dc55037da',
                                'label' => 'Theme',
                                'name' => 'theme',
                                'type' => 'radio',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array(
                                    'light' => 'Light',
                                    'dark' => 'Dark',
                                ),
                                'allow_null' => 0,
                                'other_choice' => 0,
                                'default_value' => '',
                                'layout' => 'vertical',
                                'return_format' => 'value',
                                'save_other_choice' => 0,
                            ),
                            array(
                                'key' => 'field_5f96dc76037db',
                                'label' => 'Main color',
                                'name' => 'form_headline',
                                'type' => 'color_picker',
                                'instructions' => 'Applied to backgrounds of buttons/icons, links and the form heading.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '#73BE1E',
                            ),
                            array(
                                'key' => 'field_5f96dc8b037dc',
                                'label' => 'Background overlay',
                                'name' => 'cta_background',
                                'type' => 'color_picker',
                                'instructions' => 'Applied to the background image and counter element. If the dark theme is selected, this color is applied to the form instead.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '#005C42',
                            ),
                            array(
                                'key' => 'field_5f96dca5037dd',
                                'label' => 'CTA Text',
                                'name' => 'cta_text',
                                'type' => 'color_picker',
                                'instructions' => 'Applied to text and symbols on CTAs, buttons and icons.',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '#FFFFFF',
                            ),
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_5f9652337d6',
                'label' => 'Extra options',
                'name' => 'extra_options',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_5f7a52379a452',
                        'label' => 'Small screen image',
                        'name' => 'small_screen_image',
                        'type' => 'image',
                        'instructions' => 'Can be used for when the selected background image (featured image) does not look ideal on e.g. mobile.',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'leads-form',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

*/