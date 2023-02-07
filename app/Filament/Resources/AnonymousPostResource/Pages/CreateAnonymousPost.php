<?php

namespace App\Filament\Resources\AnonymousPostResource\Pages;

use App\Traits\UseExtractFormData;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\AnonymousPostResource;

class CreateAnonymousPost extends CreateRecord
{
    use UseExtractFormData;

    protected static string $resource = AnonymousPostResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data = $this->sanitizeFieldNames($data);

    //     return $data;
    // }

    protected function handleRecordCreation(array $row): Model
    {
        $page_block_data['title'] = $row['title'];
        $page_block_data['continent_id'] = $row['continent_id'];
        $page_block_data['country_id'] = $row['country_id'];
        $page_block_data['language_id'] = $row['language_id'];
        $page_block_data['link'] = $row['link'];
        $page_block_data['description'] = $row['description'];
        $page_block_data['post_position'] = $row['post_position'];
        $page_block_data['is_published'] = $row['is_published'];
        $page_block_data['author_id'] = auth()->id();
        $page_block_data['published_at'] = $row['published_at'];
        $page_block_data['image'] = $row['image'];
        $page_block_data['category_id'] = 1;

        $model = $this->getModel()::create($page_block_data);

        return $model;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
