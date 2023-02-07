<form wire:ignore>
    <div class="modal fade" id="inlineEditModal">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inlineEditModalLabel">Quick Edit</h5>
                <button type="button" class="close" data-coreui-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="pb-3">
                    Language: <span id="single_lang">{{ $single_lang }}</span>
                </div>
                <div class="form-group">
                    <textarea wire:model.lazy='single_text' class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center">
                <button type="button" class="btn btn-secondary" wire:click="updateSingleTranslation()">Update</button>
            </div>
        </div>
        </div>
    </div>
</form>