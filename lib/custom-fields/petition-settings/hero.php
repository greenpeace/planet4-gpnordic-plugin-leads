<?php
// Returns the "Hero Settings" field group
function get_hero_settings()
{
    $hero_settings = new StoutLogic\AcfBuilder\FieldsBuilder('hero_settings');
    $hero_settings->addGroup('hero_settings')
        ->addTextArea('headline', [
            'label' => 'Hero headline',
            'instructions' => 'The campaign title or slogan. Longer sentences will scale, but shorter texts are recommended.',
            'maxlength' => 140,
            'new_lines' => 'br',
        ])
        ->addTextArea('description', [
            'label' => 'Hero description',
            'instructions' => 'A brief campaign excerpt. Aim to keep this text concise and to-the-point. Use additional content blocks to elaborate on the matter. Texts longer than 300 characters will automatically be hidden under a \'read more\' link.',
            'new_lines' => 'br',
        ]);
    return $hero_settings;
}
