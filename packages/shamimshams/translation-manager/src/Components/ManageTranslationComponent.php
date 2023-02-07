<?php
namespace ShamimShams\TranslationManager\Components;

use Livewire\Component;
use Livewire\WithFileUploads;
use Google\Cloud\Translate\V2\TranslateClient;
use ShamimShams\LWDatatable\Traits\WithSorting;
use ShamimShams\LWDatatable\Traits\WithCachedRows;
use ShamimShams\LWDatatable\Traits\WithBulkActions;
use ShamimShams\TranslationManager\MissingTranslations;
use ShamimShams\LWDatatable\Traits\WithPerPagePagination;
use ShamimShams\TranslationManager\Exports\TranslationImport;
use ShamimShams\TranslationManager\Models\TranslationManager;

class ManageTranslationComponent extends Component
{
    use WithFileUploads, WithPerPagePagination, WithBulkActions, WithSorting, WithCachedRows;

    public $trans_id;

    public $group;

    public $key;

    public $translation_text = [];

    public $base_locale = "";

    public $single_text;

    public $single_lang;

    public $file;

    public $is_importing = false;

    public $filter_group;
    public $filter_key;
    public $filter_text;

    public $filters = [
        'group' => '',
        'key'   => '',
        'text'  => '',
        'type'  => 'all',
    ];

    public $type = [
        'all'     => 'All Translation',
        'missing' => 'Missing Translation',
        'group'   => 'Group Key Translation',
        'string'  => 'String Translation',
    ];

    public $sorts = [];

    public function mount()
    {
        $this->base_locale = config( 'ltm.base_locale' );

        $this->setTranslatableLang();
    }

    public function render()
    {
        $data['translations'] = $this->rows;

        return view( "ltm::components.manage-translation", $data );
    }

    public function search()
    {
        $this->filters['group'] = $this->filter_group;
        $this->filters['key']   = $this->filter_key;
        $this->filters['text']  = $this->filter_text;
    }

    public function clearSeach()
    {
        $this->filters['group'] = '';
        $this->filters['key']   = '';
        $this->filters['text']  = '';
        $this->reset( 'filter_group', 'filter_key', 'filter_text' );
    }

    public function getRowsQueryProperty()
    {
        $query = TranslationManager::query()
            ->when( $this->filters['type'] == 'missing', fn( $query, $status ) => $query->where( 'text', '[]' ) )
            ->when( $this->filters['type'] == 'group', fn( $query, $status ) => $query->where( 'group', '!=', '*' )->Where( 'group', '!=', '' ) )
            ->when( $this->filters['type'] == 'string', fn( $query, $status ) => $query->where( 'group', '*' )->orWhere( 'group', '' ) )
            ->when( $this->filters['group'], fn( $query, $search ) => $query->where( 'group', 'like', '%' . $search . '%' ) )
            ->when( $this->filters['key'], fn( $query, $search ) => $query->where( 'key', 'like', '%' . $search . '%' ) )
            ->when( $this->filters['text'], fn( $query, $search ) => $query->where( 'text', 'like', '%' . $search . '%' ) );

        return $this->applySorting( $query );
    }

    public function getRowsProperty()
    {
        return $this->cache( function () {
            return $this->applyPagination( $this->rowsQuery );
        } );
    }

    public function openTranslationModal()
    {
        $this->reset( 'trans_id', 'group', 'key', 'translation_text' );
        $this->setTranslatableLang();
        $this->dispatchBrowserEvent( 'openNewTranslationModal' );
    }

    public function updatedKey( $value )
    {

        if ( empty( $group ) ) {
            $this->translation_text[$this->base_locale] = $value;
        }

    }

    public function setTranslatableLang()
    {

        foreach ( config( 'ltm.supported_locale' ) as $key => $lang ) {
            $this->translation_text[$key] = "";
        }

    }

    public function saveTranslation( $save_and_new = false )
    {
        $rule['key']                                    = "required|unique:translation_manager";
        $rule['translation_text.' . $this->base_locale] = "required";

        $this->validate( $rule );

        $manager = new TranslationManager();

        $manager->group = !$this->group ? '*' : $this->group;
        $manager->key   = $this->key;
        $manager->text  = $this->translation_text;
        $manager->save();

        session()->flash( 'success', 'New Translation saved successfully!' );
        $this->reset( 'trans_id', 'group', 'key', 'translation_text' );
        $this->hideModal();
    }

    public function openEditTranslationModal( $trans_id )
    {
        //dd($trans_id);
        $this->reset( 'trans_id', 'group', 'key', 'translation_text' );
        $this->setTranslatableLang();

        $trans                  = TranslationManager::findOrFail( $trans_id );
        $this->group            = $trans->group;
        $this->key              = $trans->key;
        $this->translation_text = $trans->text;
        $this->trans_id         = $trans->id;

        $this->dispatchBrowserEvent( 'openNewTranslationModal' );
    }

    public function updateTranslation()
    {
        $rule['key']                                    = "required|unique:translation_manager,id";
        $rule['translation_text.' . $this->base_locale] = "required";

        $this->validate( $rule );

        $manager = TranslationManager::findOrFail( $this->trans_id );

        $manager->group = !$this->group ? '*' : $this->group;
        $manager->key   = $this->key;
        $manager->text  = $this->translation_text;
        $manager->save();

        session()->flash( 'success', "Translation updated successfully!" );
        $this->reset( 'trans_id', 'group', 'key', 'translation_text' );
        $this->hideModal();
    }

    public function openInlineEditModal( $trans_id, $lang )
    {
        $this->reset( 'trans_id', 'group', 'key', 'translation_text', 'single_text', 'single_lang' );

        $this->single_lang = $lang;

        $trans             = TranslationManager::findOrFail( $trans_id );
        $this->trans_id    = $trans_id;
        $this->single_text = isset( $trans->text[$lang] ) ? $trans->text[$lang] : null;

        $this->dispatchBrowserEvent( 'openInlineEditModal' );

    }

    public function updateSingleTranslation()
    {

        if ( !$this->trans_id ) {
            return;
        }

        $trans                    = TranslationManager::findOrFail( $this->trans_id );
        $text                     = $trans->text;
        $text[$this->single_lang] = $this->single_text;
        $trans->text              = $text;
        $trans->save();

        session()->flash( 'success', 'Translation updated successfully!' );
        $this->reset( 'trans_id', 'group', 'key', 'translation_text', 'single_text', 'single_lang' );
        $this->hideModal();
    }

    private function alertMessage( $message, $type = "success" )
    {
        $this->dispatchBrowserEvent( 'alert', ['type' => $type, 'message' => $message] );
    }

    public function syncMissingTranslations()
    {
        $translations = MissingTranslations::missing();

        foreach ( $translations['groupKeys'] as $key ) {
            list( $group, $item ) = explode( '.', $key, 2 );

            TranslationManager::firstOrCreate( [
                'group' => $group,
                'key'   => $item,
                'text'  => [],
            ] );
        }

        foreach ( $translations['stringKeys'] as $key ) {
            TranslationManager::firstOrCreate( [
                'group' => '*',
                'key'   => $key,
                'text'  => [],
            ] );
        }

        session()->flash( 'success', "Total {$translations['total']} missing translations synced." );

    }

    public function openImportModal()
    {
        $this->is_importing = false;
        $this->dispatchBrowserEvent( 'openImportModal' );
    }

    public function importTranslations()
    {
        try {
            $this->is_importing = true;

            $originalName = $this->file->getClientOriginalName();
            $filePart     = explode( '.', $originalName );
            $ext          = end( $filePart );

            $filename = 'translations.' . $ext;
            $file     = $this->file->storeAs( 'import', $filename );

            ( new TranslationImport )->import( $file, null, \Maatwebsite\Excel\Excel::CSV );
            session()->flash('success', 'Translation imported successfully!');
            $this->dispatchBrowserEvent( 'success', ['message' => 'Translation imported successfully!'] );

            $this->show_upload_form = false;
            $this->is_importing     = false;
            $this->hideModal();

        } catch ( \Exception $ex ) {
            $this->is_importing = false;
        }

    }

    public function export()
    {
        return redirect()->route( 'ltm.download' );
    }

    public function showConfirm()
    {
        $this->dispatchBrowserEvent( 'showConfirmDialog' );
    }

    public function delete()
    {
        try {
            TranslationManager::whereIn( 'id', $this->selected )->delete();

            session()->flash( 'success', 'selected translations deleted successfully!' );
            $this->selected = [];
            $this->hideModal();

        } catch ( \Exception $ex ) {
            session()->flash( 'error', 'unable to delete!' );
        }

    }

    public function hideModal()
    {
        $this->dispatchBrowserEvent( 'hideModal' );
    }

    public function translateText($key) {
        $translate = new TranslateClient([
            'keyFilePath' => public_path("wetalents-api-ce804c6529e9.json")
        ]);

        $languages = ['de', 'fr', 'it', 'en'];
        
        if( $this->translation_text[$key] ) {
            unset($languages[$key]);
            foreach($languages as $lang) {
                $result = $translate->translate($this->translation_text[$key], [
                    'target' => $lang,
                    'format' => 'text',
                ]);

                $this->translation_text[$lang] = $result['text'];
            }
        }
    }

}
