<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\PageMeta;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    public $page_id;

    public $page_meta = null;

    public function mount(): void
    {
        $this->page_id = request()->query('page');

        $this->initPageMeta();

        static::authorizeResourceAccess();
    }

    private function initPageMeta()
    {

        $page_meta = PageMeta::where('page_id', $this->page_id)->get();

        if ($page_meta) {
            $this->page_meta = $page_meta->toArray();
        }   


    }

    protected function getActions(): array
    {
       
        return [
            Actions\CreateAction::make()->label('New Page Block')->url("/admin/page-blocks/create/?page={$this->page_id}"),

            Action::make('Page Settings')->label(__('Page Meta Tags'))->action(function(PageMeta $records, array $data) {
               $this->savePageMeta($data);
               Notification::make()->success()->title('Page meta saved successfully!')->send();
               $this->initPageMeta();
            })->form([
                Grid::make()->schema([
                    Section::make('Common')->schema([
                        TextInput::make('title')->label(__('Page Title'))->placeholder(__('Page Title'))->default($this->getMetaValue('title')),
                        TagsInput::make('meta_keywords')->label(__('Meta Keywords'))->placeholder(__('Meta Keywords'))->default($this->getMetaValue('meta_keywords')),
                        Textarea::make('meta_description')->rows(2)->placeholder(__('Meta Description'))->default($this->getMetaValue('meta_description')),
                        Repeater::make('facebook_meta')->label(__('Facebook Og Tags'))->schema([
                            TextInput::make('property')->label(__('Property'))->placeholder(__('Property'))->required()->columnSpan(1),
                            Textarea::make('content')->label(__('Content'))->placeholder(__('Content'))->columnSpan(1)->rows(2),
                        ])->defaultitems(0)->columns(2)->collapsible()

                    ])->columnSpan(1),


                    Section::make('Site Settings')->schema([
                        TextInput::make('facebook_link')->label(__('Facebook Link'))->placeholder(__('Facebook Link'))->url(),
                        TextInput::make('twitter_link')->label(__('Twitter Link'))->placeholder(__('Twitter Link'))->url(),
                        TextInput::make('linkedin_link')->label(__('Linkedin Link'))->placeholder(__('Linkedin Link'))->url(),
                        TextInput::make('instagram_link')->label(__('Instagram Link'))->placeholder(__('Instagram Link'))->url(),
                        TextInput::make('youtube_link')->label(__('Youtube Link'))->placeholder(__('Youtube Link'))->url(),

                    ])->columnSpan(1)


                ])->columns(2)
            ])->modalWidth('large'),
        ];
    }

    private function savePageMeta($data)
    {   
        //info($data);
        foreach($data as $key => $value) {

            $where['page_id'] = $this->page_id;
            $where['key'] = $key;

            $row['key'] = $key;
            $row['value'] = $value;
           
            PageMeta::updateOrCreate($where, $row);
        }

    }

    private function getMetaValue($key, $default='')
    {
        if (!$this->page_meta) {
            return $default;
        }

        $row = array_filter($this->page_meta, function($record) use($key) {
            return $record['key'] == $key;
        });

        $row = array_values($row);
        
        return $row[0]['value'] ?? $default;
    }
}
