<?php

namespace App\Filament\Resources\HomeResource\Pages;

use App\Models\Home;
use App\Models\Language;
use Filament\Pages\Actions;
use App\Models\PageBlockContent;
use App\Traits\UseExtractFormData;
use Illuminate\Support\Facades\App;
use App\Models\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\HomeResource;
use Filament\Resources\Pages\EditRecord;

class EditHome extends EditRecord
{
    use UseExtractFormData;

    public string $page_id = '';

    protected static string $resource = HomeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRecord(): Model
    {
        if (request()->query('page')) {
            $this->page_id = request()->query('page');
        }

        return $this->record;
    }

    protected function getRedirectUrl(): ?string
    {
        return  $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $blocks = Home::withoutGlobalScope(LanguageScope::class)->with('contents')
            ->where('id', $this->record->id)
            ->first();

        return (array) $this->getData($blocks);
    }

    /**
     * formate page block & page  block content data beform fill the form
     *
     * @param [type] $block_data
     * @return void
     */
    private function getData($block_data)
    {
        $form_data = [];
        $form_data['page_id'] = $this->page_id;

        //TODO
        // $locale = App::currentLocale();
        // $language = Language::where('language_key', $locale)->first();
        // $lang_wise_data = $block_data->where('language_id', $language->id)->first();

        $form_data['title'] = $block_data->title;
        $form_data['continent_id'] = $block_data->continent_id;
        $form_data['country_id'] = $block_data->country_id;
        $form_data['language_id'] = $block_data->language_id;
        $form_data['link'] = $block_data->link;
        $form_data['category_id'] = $block_data->category_id;
        $form_data['block_type'] = $block_data->block_type;
        $form_data['is_published'] = $block_data->is_published;
        $form_data['published_at'] = $block_data->published_at;

        $form_data['contents'] = [];
        foreach ($block_data->contents as $block_content) {
            if (!$block_content->content) {
                continue;
            }
            foreach ($block_content->content as $content) {
                if (!is_array($content)) {
                    continue;
                }
                $block_content_data = [];
                foreach ($content as $name => $value) {
                    $block_content_data[$name] = $value;
                }
                $form_data['contents'][] = $block_content_data;
            }
        }

        return $form_data;
    }

    protected function handleRecordUpdate(Model $record, array $row): Model
    {
        // $record->update($data);
        $block_content = null;
        $block = $this->getPageBlock($record->id);

        if (!$block) {
            $block = new Home();
        }

        $block->title = $row['title'];
        $block->block_type = $row['block_type'];
        $block->continent_id = $row['continent_id'];
        $block->category_id = $row['category_id'];
        $block->country_id = $row['country_id'];
        $block->language_id = $row['language_id'];
        $block->link = $row['link'];
        $block->is_published = $row['is_published'];
        $block->author_id = auth()->id();
        $block->published_at = $row['published_at'];
        $block->save();

        $block_content = PageBlockContent::where('block_id', $block->id)->first();
        if (!$block_content) {
            $block_content = new PageBlockContent();
            $block_content->block_id = $block->id;
        }

        $block_content->content = $row['contents'];
        $block_content->display_order = 0;
        $block_content->author_id = auth()->id();
        $block_content->published_at = now();
        $block_content->save();

        return $record;
    }

    /**
     * query page block
     *
     * @param  int  $block_id
     * @param  string  $lang
     * @return Home
     */
    private function getPageBlock(int $block_id): ?Home
    {
        return Home::withoutGlobalScope(LanguageScope::class)->find($block_id);
    }
}
