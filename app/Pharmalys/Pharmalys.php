<?php

namespace App\Pharmalys;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;


class Pharmalys
{
    public static function getPages(): array
    {
        // return [
        //     'home' => ['title' => __('Home'), 'icon' => 'heroicon-o-home'],
        //     'about' => ['title' => __('About'), 'icon' => 'heroicon-o-information-circle'],
        //     'brands' => ['title' => __('Brands'), 'icon' => 'heroicon-o-presentation-chart-line'],
        //     'partners' => ['title' => __('Partners'), 'icon' => 'heroicon-o-presentation-chart-line'],
        //     'stories' => ['title' => __('Stories'), 'icon' => 'heroicon-o-home'],
        // ];

        return [];
    }

    public static function getBlockTypes(): array
    {
        return [
            'banner-slider' => __('Banner Slider'),
            'facts' => __('Facts'),
            'brand-section' => __('Brand Section'),
            'story-section' => __('Story Section'),
        ];
    }

    public static function getBlockContentForms(): array
    {
        return [
            'banner-slider' => static::getBannerForm(),
            'stories' => static::getStoriesForm(),
            'facts' => static::getFactForm(),
            'brand-section' => static::getBrandForm(),
            'story-section' => static::getStoriesForm(),
        ];
    }


    public static function getAboutBlockTypes(): array
    {
        return [
            'first-section' => __('First Section'),
            'second-section' => __('Second Section'),
            'third-section' => __('Third Section'),
            'fourth-section' => __('Fourth Section'),
            'fifth-section' => __('Fifth Section'),
        ];
    }

    public static function getAboutBlockContentForms(): array
    {
        return [
            'first-section' => static::getFirstForm(),
            'second-section' => static::getSecondForm(),
            'third-section' => static::getThirdForm(),
            'fourth-section' => static::getFourthForm(),
            'fifth-section' => static::getFifthForm(),
        ];
    }

    public static function getAboutBlcokForm($block): array
    {
        return isset(static::getAboutBlockContentForms()[$block]) ? static::getAboutBlockContentForms()[$block] : [];
    }


    public static function positions(): array
    {
        return [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
        ];
    }

    public static function getFirstForm(): array
    {
        return [
            Repeater::make(static::getFieldName('contents'))->label('')->schema([
                TextInput::make(static::getFieldName('title'))->required()->placeholder(__('Title')),
                Textarea::make(static::getFieldName('sub_description'))->required()->rows(2)->placeholder(__('Sub Description')),
                FileUpload::make(static::getFieldName('image'))->image()->maxSize(500)->required(),
                Textarea::make(static::getFieldName('description'))->required()->rows(2)->placeholder(__('Description'))
            ])
                ->disableItemMovement()
                ->defaultItems(1)
                ->maxItems(1),
        ];
    }

    public static function getSecondForm(): array
    {
        return [
            Repeater::make(static::getFieldName('contents'))->label('')->schema([
                TextInput::make(static::getFieldName('title'))->required()->placeholder(__('Title')),
                FileUpload::make(static::getFieldName('background_image'))->image()->maxSize(500)->required(),
                TextInput::make(static::getFieldName('description_title'))->required()->placeholder(__('Description Title')),
                Textarea::make(static::getFieldName('description'))->required()->rows(2)->placeholder(__('Description')),
            ])
                ->disableItemMovement()
                ->defaultItems(1)
                ->maxItems(1),
        ];
    }

    public static function getThirdForm(): array
    {
        return [
            FileUpload::make(static::getFieldName('image'))->image()->maxSize(500)->required(),
            Repeater::make(static::getFieldName('contents'))->label('')->schema([
                TextInput::make(static::getFieldName('title'))->required(),
                Textarea::make(static::getFieldName('description'))->required()->rows(2)->placeholder(__('Description')),
                FileUpload::make(static::getFieldName('logo'))->image()->maxSize(500)->required(),
            ])
        ];
    }

    public static function getFourthForm(): array
    {
        return [
            Repeater::make(static::getFieldName('contents'))->label('')->schema([
                FileUpload::make(static::getFieldName('logo'))->image()->maxSize(500)->required(),
                TextInput::make(static::getFieldName('title'))->required()->label('Year'),
                Textarea::make(static::getFieldName('description'))->required()->rows(2)->placeholder(__('Description')),
            ])
        ];
    }

    public static function getFifthForm(): array
    {
        return [
            Repeater::make(static::getFieldName('contents'))->label('')->schema([

                FileUpload::make(static::getFieldName('image_one'))->image()->maxSize(500)->required(),
                TextInput::make(static::getFieldName('title'))->required()->placeholder(__('Title')),
                Textarea::make(static::getFieldName('description'))->required()->rows(2)->placeholder(__('Description')),
                FileUpload::make(static::getFieldName('image_two'))->image()->maxSize(500)->required(),
            ])
                ->disableItemMovement()
                ->defaultItems(1)
                ->maxItems(1),
            // ->disableItemCreation(),
        ];
    }

    public static function getBlcokForm($block): array
    {
        return isset(static::getBlockContentForms()[$block]) ? static::getBlockContentForms()[$block] : [];
    }

    public static function getBannerForm(): array
    {
        return [
            Repeater::make(static::getFieldName('contents'))->label('')->schema([
                TextInput::make(static::getFieldName('title'))->required(),
                Textarea::make(static::getFieldName('description'))->required()->rows(2)->placeholder(__('Description')),
                FileUpload::make(static::getFieldName('video'))
                    ->acceptedFileTypes(['video/mp4', 'video/3gpp'])
                    ->maxSize(400000)->required(),
            ])
                ->disableItemMovement()
                ->defaultItems(1)
                ->maxItems(1),
            // ->disableItemCreation(),
        ];
    }

    public static function getStoriesForm(): array
    {
        return [
            Repeater::make(static::getFieldName('contents'))->schema([
                TextInput::make(static::getFieldName('title'))->required()->placeholder(__('Title')),
                Textarea::make(static::getFieldName('description'))->required()->rows(2)->placeholder(__('Description')),
                FileUpload::make(static::getFieldName('logo'))->image()->maxSize(500)->required(),
            ])
        ];
    }

    public static function getFactForm(): array
    {
        return [
            Repeater::make(static::getFieldName('contents'))->label('')->schema([

                TextInput::make(static::getFieldName('title'))->columnSpan(1),
                TextInput::make(static::getFieldName('count'))->numeric()->columnSpan(1),
                Textarea::make(static::getFieldName('details'))->rows(2)->columnSpan(2),
            ])
                ->defaultItems(2)
                ->columns(2)
                ->collapsible(),
        ];
    }

    public static function getBrandForm(): array
    {
        return [
            Repeater::make(static::getFieldName('contents'))->schema([
                TextInput::make(static::getFieldName('title'))->required()->placeholder(__('Title')),
                Textarea::make(static::getFieldName('description'))->required()->rows(2)->placeholder(__('Description')),
                FileUpload::make(static::getFieldName('logo'))->image()->maxSize(500)->required(),
            ])->collapsible()
        ];
    }

    public static function getFieldName($name, $lang = null)
    {
        return  "{$name}";
    }

    public static function extractFieldName($name)
    {
        $field_name_segments = explode('_', $name);
        array_pop($field_name_segments);

        return implode('_', $field_name_segments);
    }
}
