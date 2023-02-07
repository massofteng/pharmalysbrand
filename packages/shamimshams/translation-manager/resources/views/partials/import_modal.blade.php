<form wire:ignore>
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Translation</h5>
                <button type="button" class="close"  data-coreui-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                          <input 
                            type="file" 
                            class="custom-file-input" 
                            wire:model='file' 
                            id="importInput" 
                            accept=".csv,text/csv, application/csv">
                          <label class="custom-file-label" for="importInput">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center">
                <button type="button" class="btn btn-secondary" wire:click="importTranslations()">Upload</button>
                <button type="button" class="btn btn-outline btn-secondary" data-coreui-dismiss="modal">Cancel</button>
            </div>
        </div>
        </div>
    </div>
</form>