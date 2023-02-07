<?php

return [
    "supported_locale"    => [
        'en' => 'English', 'de' => 'German', 'it' => 'Italian', 'fr' => 'French',
    ],

    'base_locale'         => 'en',

    "model_namespace"     => "App\Models",
    "model_folder"        => app_path() . "/Models",

    'translation_loaders' => [
        \ShamimShams\TranslationManager\TranslationLoaders\Db::class,
    ],

    'translation_manager' => \ShamimShams\TranslationManager\TranslationManager::class,

    'trans_functions'     => [
        'trans',
        'trans_choice',
        'Lang::get',
        'Lang::choice',
        'Lang::trans',
        'Lang::transChoice',
        '@lang',
        '@choice',
        '__',
        '$trans.get',
    ],

    'exclude_groups'      => [],
    'middleware'          => ['web'],
];
