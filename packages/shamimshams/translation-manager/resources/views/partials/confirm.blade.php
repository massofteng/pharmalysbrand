<div id="{{ $confirmId }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="justify-content: center">
                <h5 class="modal-title" id="{{ $confirmId }}-title">{{ $title ?? null }}</h5>
            </div>
            <div class="modal-body text-center">
                {{ $text ?? null }}
            </div>
            <div class="modal-footer justify-content-center">
                <button type='button' class="btn btn-success btn-md" wire:click='{{ $action ?? null }}'>Confirm</button>
                <button class="btn btn-danger btn-md" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>