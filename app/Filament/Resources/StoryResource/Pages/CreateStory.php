<?php

namespace App\Filament\Resources\StoryResource\Pages;

use App\Traits\UseExtractFormData;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\StoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStory extends CreateRecord
{
    use UseExtractFormData;

    protected static string $resource = StoryResource::class;


    protected function handleRecordCreation(array $row): Model
    {
        $page_block_data['title']         = $row['title'];
        $page_block_data['page_id']       = 'story';
        $page_block_data['block_type']    = 'story-section';
        $page_block_data['continent_id']  = $row['continent_id'];
        $page_block_data['country_id']    = $row['country_id'];
        $page_block_data['language_id']   = $row['language_id'];
        $page_block_data['category_id']   = $row['category_id'];
        $page_block_data['description']   = $row['description'];
        $page_block_data['link']          = $row['link'];
        $page_block_data['is_published']  = $row['is_published'];
        $page_block_data['feature']       = $row['feature'];
        $page_block_data['header']        = $row['header'];
        $page_block_data['author_id']     = auth()->id();
        $page_block_data['published_at']  = $row['published_at'];
        $page_block_data['image']         = $row['image'];

        $model = $this->getModel()::create($page_block_data);

        return $model;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
