<?php
$petition_form_block = new \StoutLogic\AcfBuilder\FieldsBuilder('Petition Form Block');

$petition_form_block
    ->setLocation('block', '==', 'acf/leads-form')
    ->addRadio('display', [
        'label' => 'Display',
        'instructions' => '',
        'required' => true,
        'choices' => [
            'hero' => 'Hero',
            'small' => 'Small',
        ],
        'default_value' => 'hero',
        'layout' => 'vertical',
        'return_format' => 'value',
    ])
    ->addPostObject('form', [
        'label' => 'Form',
        'instructions' => '',
        'required' => false,
        'post_type' => ['leads-form'],
        'return_format' => 'id',
        'ui' => 1,
    ]);

acf_add_local_field_group($petition_form_block->build());
