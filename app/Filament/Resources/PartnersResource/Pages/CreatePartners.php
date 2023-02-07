<?php

namespace App\Filament\Resources\PartnersResource\Pages;

use App\Traits\UseExtractFormData;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PartnersResource;

class CreatePartners extends CreateRecord
{
    use UseExtractFormData;

    protected static string $resource = PartnersResource::class;

    protected function handleRecordCreation(array $row): Model
    {
        $page_block_data['title'] = $row['title'];
        $page_block_data['continent_id'] = $row['continent_id'];
        $page_block_data['country_id'] = $row['country_id'];
        $page_block_data['language_id'] = $row['language_id'];
        $page_block_data['description'] = $row['description'];
        $page_block_data['link'] = $row['link'];
        $page_block_data['image_one'] = $row['image_one'];
        $page_block_data['image_two'] = $row['image_two'];
        $page_block_data['is_published'] = $row['is_published'];
        $page_block_data['author_id'] = auth()->id();
        $page_block_data['published_at'] = $row['published_at'];

        $model = $this->getModel()::create($page_block_data);

        return $model;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
