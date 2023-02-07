<?php

namespace App\Filament\Resources\HomeResource\Pages;

use App\Models\PageBlockContent;
use App\Traits\UseExtractFormData;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\HomeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHome extends CreateRecord
{
    use UseExtractFormData;

    protected static string $resource = HomeResource::class;

    protected function handleRecordCreation(array $row): Model
    {
        $block_content = null;

        $page_block_data['page_id'] = 'home';
        $page_block_data['continent_id'] = $row['continent_id'];
        $page_block_data['country_id'] = $row['country_id'];
        $page_block_data['language_id'] = $row['language_id'];
        $page_block_data['category_id'] = $row['category_id'] ? $row['category_id'] : 0;
        $page_block_data['title'] = $row['title'];
        $page_block_data['link'] = $row['link'];
        $page_block_data['block_type'] = $row['block_type'];
        $page_block_data['display_order'] = 0;
        $page_block_data['is_published'] = $row['is_published'];
        $page_block_data['author_id'] = auth()->id();
        $page_block_data['published_at'] = $row['published_at'];

        $model = $this->getModel()::create($page_block_data);

        $block_content_data['block_id'] = $model->id;
        $block_content_data['content'] = $row['contents'];
        $block_content_data['display_order'] = 0;
        $block_content_data['author_id'] = auth()->id();
        $block_content_data['published_at'] = now();

        $block_content = PageBlockContent::create($block_content_data);

        return $block_content;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
