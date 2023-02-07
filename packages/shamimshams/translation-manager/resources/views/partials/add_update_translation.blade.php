<form wire:ignore>
    <div class="modal fade" id="translationModal">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTranslationLabel">Add New Translation</h5>
                <button type="button" class="close" data-coreui-dismiss="modal" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="ck_is_keyed_translation">
                    <label class="custom-control-label" for="ck_is_keyed_translation">Keyed Translation</label>
                </div> group_name_content-->
                
                <div class="form-group mb-2" id="">
                    <label for="">{{ __('Group Name') }}</label>
                    <input type="text" wire:model.lazy="group" id="group_name" class="form-control" placeholder="{{ __('Group Name') }}">
                </div>

                <div class="form-group">
                    <label for="">{{ __('Key Name') }}</label>
                    <textarea wire:model.lazy="key" id="key_name" placeholder="{{ __('Key Name') }}" class="form-control"></textarea>
                </div>

                @foreach($translation_text as $key => $locale_item)
                <div class="row mt-3">
                    <div class="col-sm-9">
                        <div class="form-group">
                            <label for="">{{ __(':key Translation', ['key' => strtoupper($key)]) }}</label>
                            <textarea 
                                wire:model.lazy="translation_text.{{ $key }}" 
                                id="locale_item_{{ $loop->index }}" 
                                data-key="{{ $key }}"
                                placeholder="{{ __(':key Translation', ['key' => strtoupper($key)]) }}" 
                                class="form-control"></textarea>
                        </div>
                    </div>
                    
                    @if($key == 'de')
                    <div class="col-sm-3 d-flex align-items-center">
                        <button wire:loading.attr="disabled" wire:click.prevent="translateText('{{ $key }}')" type="button" class="btn btn-sm btn-success">{{ __('Translate') }}</button>
                    </div>
                    @endif
                </div>                
                @endforeach
                
            </div>
            <div class="modal-footer" style="justify-content: center">
                <div id="btnAdd" class="">
                    <button type="button" class="btn btn-secondary" wire:click.prevent="saveTranslation()">Save &amp; Close</button>
                    <button type="button" class="btn btn-secondary" wire:click.prevent="saveTranslation(true)">Save &amp; New</button>
                </div>
                <div id="btnUpdate" class="">
                    <button type="button" class="btn btn-secondary" wire:click.prevent="updateTranslation()">Update</button>
                </div>
            </div>
        </div>
        </div>
    </div>
</form>