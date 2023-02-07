<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Models\About;
use Filament\Pages\Actions;
use App\Models\AboutBlockContent;
use App\Traits\UseExtractFormData;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\AboutResource;
use App\Models\Scopes\LanguageScope;

class EditAbout extends EditRecord
{
    use UseExtractFormData;

    protected static string $resource = AboutResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRecord(): Model
    {
        return $this->record;
    }

    protected function getRedirectUrl(): ?string
    {
        return  $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $blocks = About::withoutGlobalScope(LanguageScope::class)->with('contents')
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
        $form_data['continent_id'] = $block_data->continent_id;
        $form_data['country_id'] = $block_data->country_id;
        $form_data['language_id'] = $block_data->language_id;
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
        //dd($row['contents']);
        $block_content = null;
        $block = $this->getPageBlock($record->id);

        $block->block_type = $row['block_type'];
        $block->continent_id = $row['continent_id'];
        $block->country_id = $row['country_id'];
        $block->language_id = $row['language_id'];
        $block->is_published = $row['is_published'];
        $block->author_id = auth()->id();
        $block->published_at = $row['published_at'];
        $block->save();

        $block_content = AboutBlockContent::where('block_id', $block->id)->first();
        if (!$block_content) {
            $block_content = new AboutBlockContent();
            $block_content->block_id = $block->id;
        }

        $block_content->content = $row['contents'];
        $block_content->image = isset($row['image']) ? $row['image'] : '';
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
     * @return About
     */
    private function getPageBlock(int $block_id): ?About
    {
        return About::withoutGlobalScope(LanguageScope::class)->find($block_id);
    }
}
