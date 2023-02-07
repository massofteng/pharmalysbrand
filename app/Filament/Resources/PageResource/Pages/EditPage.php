<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\PageBlock;
use App\Models\PageBlockContent;
use App\Pharmalys\Pharmalys;
use App\Traits\UseExtractFormData;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPage extends EditRecord
{
    use UseExtractFormData;

    protected static string $resource = PageResource::class;

    public string $page_id = '';

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

    // protected function getRedirectUrl(): ?string
    // {
    //     return  $this->getResource()::getUrl('index');
    // }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $blocks = PageBlock::with('contents')
            ->where('id', $this->record->id)
            ->orWhere('parent_id', $this->record->id)
            ->where('page_id', request()->query('page'))
            ->get();

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

        foreach (config('pharmalys.language') as $lang => $value) {
            $form_data[Pharmalys::getFieldName('lang', $lang)] = $lang;
            $form_data[Pharmalys::getFieldName('page_id', $lang)] = $this->page_id;

            $lang_wise_data = $block_data->where('lang', $lang)->first();

            if (! $lang_wise_data) {
                continue;
            }

            $form_data[Pharmalys::getFieldName('title', $lang)] = $lang_wise_data->title;
            $form_data[Pharmalys::getFieldName('block_type', $lang)] = $lang_wise_data->block_type;
            $form_data[Pharmalys::getFieldName('is_published', $lang)] = $lang_wise_data->is_published;
            $form_data[Pharmalys::getFieldName('published_at', $lang)] = $lang_wise_data->published_at;

            $form_data[Pharmalys::getFieldName('contents', $lang)] = [];
            foreach ($lang_wise_data->contents as $block_content) {
                if (! $block_content->content) {
                    continue;
                }
                foreach ($block_content->content as $content) {
                    if (! is_array($content)) {
                        continue;
                    }
                    $block_content_data = [];
                    foreach ($content as $name => $value) {
                        $block_content_data[Pharmalys::getFieldName($name, $lang)] = $value;
                    }

                    $form_data[Pharmalys::getFieldName('contents', $lang)][] = $block_content_data;
                }
            }
        }

        return $form_data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = $this->sanitizeFieldNames($data);

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // $record->update($data);

        $block_content = null;
        foreach ($data as $lang => $row) {
            if (! $row['title'] || ! $row['block_type']) {
                continue;
            }

            $block = $this->getPageBlock($record->id, $lang);

            if (! $block) {
                $block = new PageBlock();
                $block->page_id = $this->page_id;
            }

            $block->title = $row['title'];
            $block->block_type = $row['block_type'];
            $block->display_order = 0;
            $block->lang = $lang;
            $block->is_published = $row['is_published'];
            $block->author_id = auth()->id();
            $block->published_at = $row['published_at'];
            $block->save();

            $block_content = PageBlockContent::where('block_id', $block->id)->first();
            if (! $block_content) {
                $block_content = new PageBlockContent();
                $block_content->block_id = $block->id;
            }

            $block_content->content = $row['contents'];
            $block_content->display_order = 0;
            $block_content->author_id = auth()->id();
            $block_content->published_at = now();
            $block_content->save();
        }

        return $record;
    }

    /**
     * query page block
     *
     * @param  int  $block_id
     * @param  string  $lang
     * @return PageBlock
     */
    private function getPageBlock(int $block_id, string $lang): ?PageBlock
    {
        $is_default_lang = config('pharmalys.default_language') == $lang ? true : false;

        if ($is_default_lang) {
            return PageBlock::find($block_id);
        }

        return PageBlock::where('parent_id', $block_id)->where('lang', $lang)->first();
    }
}
