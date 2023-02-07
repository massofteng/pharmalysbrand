<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\PageBlockContent;
use App\Traits\UseExtractFormData;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePage extends CreateRecord
{
    use UseExtractFormData;

    public $re_page_id = '';

    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $this->sanitizeFieldNames($data);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $block_content = null;

        $default_lang_block_id = 0;

        foreach ($data as $lang => $row) {
            if (! $row['title'] || ! $row['block_type']) {
                continue;
            }

            /**
             * all non default lanaguage block has a parent id, the parent id is the default language block id
             */
            if ($lang != config('pharmalys.default_language')) {
                $page_block_data['parent_id'] = $default_lang_block_id;
            }

            //dd($row);

            $this->re_page_id = $row['page_id'];
            $page_block_data['page_id'] = $row['page_id'];
            $page_block_data['title'] = $row['title'];
            $page_block_data['country_id'] = $row['country'];
            $page_block_data['language_id'] = $row['language'];
            $page_block_data['title'] = $row['title'];
            $page_block_data['block_type'] = $row['block_type'];
            $page_block_data['display_order'] = 0;
            $page_block_data['lang'] = $lang;
            $page_block_data['is_published'] = $row['is_published'];
            $page_block_data['author_id'] = auth()->id();
            $page_block_data['published_at'] = $row['published_at'];

            $model = $this->getModel()::create($page_block_data);

            //store default language block id in local variable
            if ($lang == config('pharmalys.default_language')) {
                $default_lang_block_id = $model->id;
            }

            $block_content_data['block_id'] = $model->id;
            $block_content_data['content'] = $row['contents'];
            $block_content_data['display_order'] = 0;
            $block_content_data['author_id'] = auth()->id();
            $block_content_data['published_at'] = now();

            $block_content = PageBlockContent::create($block_content_data);
        }

        return $block_content;
    }

    protected function getRedirectUrl(): string
    {
        $index = $this->getResource()::getUrl('index');
        return "{$index}?page={$this->re_page_id}";
    }
}
