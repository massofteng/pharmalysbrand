<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Models\AboutBlockContent;
use App\Traits\UseExtractFormData;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\AboutResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAbout extends CreateRecord
{
    use UseExtractFormData;

    protected static string $resource = AboutResource::class;

    protected function handleRecordCreation(array $row): Model
    {
        $block_content = null;
        $page_block_data['continent_id'] = $row['continent_id'];
        $page_block_data['country_id'] = $row['country_id'];
        $page_block_data['language_id'] = $row['language_id'];
        $page_block_data['block_type'] = $row['block_type'];
        $page_block_data['display_order'] = 0;
        $page_block_data['is_published'] = $row['is_published'];
        $page_block_data['author_id'] = auth()->id();
        $page_block_data['published_at'] = $row['published_at'];

        $model = $this->getModel()::create($page_block_data);

        $block_content_data['block_id'] = $model->id;
        $block_content_data['content'] = isset($row['image']) ? $row['image'] : '';
        $block_content_data['content'] = $row['contents'];
        $block_content_data['display_order'] = 0;
        $block_content_data['author_id'] = auth()->id();
        $block_content_data['published_at'] = now();

        $block_content = AboutBlockContent::create($block_content_data);

        return $block_content;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
