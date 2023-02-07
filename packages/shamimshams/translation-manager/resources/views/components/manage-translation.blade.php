<div class="col-12">
@if(session()->has('message'))
  <div> {{ session()->get('message') }}
@endif
    <div class="row toolbar justify-content-between">
        <div class="col-lg-auto col-md-auto col-12 mb-3">
            <div class="columns columns-right btn-group">
                <button 
                    class="btn btn-light" 
                    type="button" 
                    name="toggle" 
                    wire:click.prevent="syncMissingTranslations()" 
                    aria-label="Show card view" 
                    title="Show card view">
                    <i wire:loading.class.remove="fa-refresh" wire:loading.class='fa-refresh fa-spinner' wire:target="syncMissingTranslations" class="fa fa-refresh"></i> 
                </button>
                @if(count($selected) > 0)
                <button class="btn btn-light" wire:click.prevent='showConfirm()' type="button" name="fullscreen" aria-label="Fullscreen" title="Fullscreen">
                    <i class="fa fa-trash"></i> 
                </button>
                @endif
                <div class="keep-open btn-group" title="Languages">
                    <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-label="Columns" title="Columns">
                        <i class="fa fa-filter"></i> 
                        <span>{{ $type[$filters['type']] }}</span>
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu">
                        <a href='#' wire:click="$set('filters.type', 'all')" class="dropdown-item dropdown-item-marker">
                            <span>All Translation</span>
                        </a>
                        <a href='#' wire:click="$set('filters.type', 'missing')" class="dropdown-item dropdown-item-marker">
                            <span>Missing Translation</span>
                        </a>
                        <a href='#' wire:click="$set('filters.type', 'group')" class="dropdown-item dropdown-item-marker">
                            <span>Group Key Translation</span>
                        </a>
                    </div>
                </div>
            </div>
          
            <div class="columns columns-left btn-group">
                <button class="btn btn-light" type="button" name="Import" wire:click='openImportModal()' aria-label="Import" title="Import">
                    <i class="fa fa-upload"></i> 
                </button>
                <button 
                    class="btn btn-light" 
                    type="button" 
                    name="Export" 
                    wire:click.prevent='export()' 
                    aria-label="Export" 
                    title="Export">
                    <i class="fa fa-download"></i> 
                </button>
                <button type="button" wire:click.prevent="openTranslationModal()" class="btn btn-light">
                    <i wire:loading.class.remove="fa-plus" wire:target='openTranslationModal' wire:loading.class='fa-spin fa-spinner' class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="col-lg-auto col-md-auto col-12 mb-3">
            <div class="keep-open btn-group" wire:ignore title="Languages">
                <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-label="Columns" title="Columns">
                    <i class="fa fa-filter"></i> 
                    <span>Search</span>
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu" style="transform: translate3d(-50px, 38px, 0px) !important;">
                    <form class="px-3 py-3">
                        <div class="form-group mb-2">
                          <input type="text" class="form-control" wire:model.lazy='filter_group' id="txtGroup" placeholder="Group">
                        </div>
                        <div class="form-group mb-2">
                          <input type="text" class="form-control" wire:model.lazy='filter_key' id="txtKey" placeholder="Key">
                        </div>
                        <div class="form-group mb-2">
                          <input type="text" class="form-control" wire:model.lazy='filter_text' id="txtText" placeholder="Text">
                        </div>
                        <button type="button" wire:click.prevent='search' class="btn btn-light">
                            <i class="fa fa-search"></i>
                        </button>
                        <button type="button" wire:click.prevent='clearSeach' class="btn btn-light"><i class="fa fa-refresh"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('ltm::partials.message')
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <x-lwdtbl-table class="table-bordered table-hover">
                    <x-slot name="thead">
                        <tr>
                            <x-lwdtbl-th width="70px" class="text-center align-middle">
                                <label><input type="checkbox" wire:model="selectPage" id="ck_all"></label>
                            </x-lwdtbl-th>
                            <x-lwdtbl-th sortable :direction="$sorts['group'] ?? null" wire:click="sortBy('group')">Group</x-lwdtbl-th>
                            <x-lwdtbl-th sortable :direction="$sorts['name'] ?? null" wire:click="sortBy('key')">Key</x-lwdtbl-th>
                            <x-lwdtbl-th>Tranlsations</x-lwdtbl-th>
                            <x-lwdtbl-th width="70px" class="text-right">Action</x-lwdtbl-th>
                        </tr>
                        @if(count($selected) > 0)
                        <tr>
                            <th colspan="5" class="text-center">
                                @unless ($selectAll)
                                <div>
                                    <span>
                                        You have selected <strong>{{ count($selected) }}</strong> translations,</span> 
                                    <span> do you want to select all <strong>{{ $translations->total() }}</strong>?
                                    </span>
                                    <button wire:click="selectAll" class="ml-1 btn btn-link">Select All</button>
                                </div>
                                @else
                                <span>You are currently selecting all <strong>{{ $translations->total() }}</strong> translations.</span>
                                @endif
                            </th>
                        </tr>
                        @endif
                    </x-slot>
                    <x-slot name="tbody">
                        @foreach($translations as $translation)
                        <tr class="{{ count($translation->text) == 0 ? 'bg-warning' : null  }}">
                            <td class="align-middle text-center">
                                <label><input type="checkbox" value="{{ $translation->id }}" wire:model="selected" id="ck_select_{{ $loop->index }}"></label>
                            </td>
                            <td class="align-middle">{{ $translation->group ?? 'N/A' }}</td>
                            <td class="align-middle">{{ $translation->key }}</td>
                            <td class="align-middle">
                                @foreach($translation->text as $lang => $text)
                                <p class="p-2 @if(!$loop->last) border-bottom @endif">
                                    <span class="circle-box mr-2">
                                        {{ strtoupper($lang) }}
                                    </span>
                                    <span>
                                        <a wire:click.prevent='openInlineEditModal({{ $translation->id }}, "{{ $lang }}")' class="lnk-edit text-dark">
                                            {{ $text }}
                                        </a>
                                    </span>
                                </p>
                                @endforeach
                            </td>
                            <td class="align-middle">
                                <span class="circle-box circle-box-hover">
                                    <a wire:click.prevent="openEditTranslationModal({{ $translation->id }})">
                                        <i wire:loading.class="fa-spin fa-spinner" wire:loading.class.remove="fa-edit" wire:target='openEditTranslationModal' class="fa fa-edit"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </x-slot>
                </x-lwdtbl-table>
                <div>
                    {{ $translations->links() }}
                </div>
            </div>
        </div>
    </div>

   @include('ltm::partials.add_update_translation')
   @include('ltm::partials.inline_edit_modal')
   @include('ltm::partials.import_modal')
   @include('ltm::partials.confirm', [
       'action' => 'delete',
       'confirmId' => 'mdlConfirmDelete',
       'title' => 'Confirm Delete',
       'text' => 'Are you sure to delete selected translations?'])

</div>

@push('header')
<link rel="stylesheet" href="{{ asset('assets/vendor/lw-datatable/css/lw-datatable.css') }}">
<style>
    .circle-box {
        width: 2rem;
        height: 2rem;
        font-size: .75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 400;
        color: #6e7582;
        text-align: center;
        text-transform: uppercase;
        vertical-align: bottom;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background: #f1f3f8 no-repeat center/cover;
        border-radius: 50%;
    }

    .circle-box-hover:hover {
        border: 1px solid #f1f3f8;
        background: #fff;
        cursor: pointer;
    }

    .lnk-edit {
        border-bottom: 1px dotted #ccc;
    }
    
    .lnk-edit:hover {
        text-decoration:none;
        cursor: pointer;
    }


</style>
@endpush

@push('footer')
<script type="text/javascript">
$(document).ready(function () {
    window.addEventListener('openNewTranslationModal', (event) => {
        $('#translationModal').modal('show');
    });

    window.addEventListener('openImportModal', (event) => {
        $('#importModal').modal('show');
        //alert(456);
    });

    window.addEventListener('hideModal', (event) => {
        //alert(123);
          $('#translationModal').modal('hide');
          $('#inlineEditModal').modal('hide');
          $('#importModal').modal('hide');
          $('#mdlConfirmDelete').modal('hide');
    });

    window.addEventListener('openInlineEditModal', (event) => {
        $('#inlineEditModal').modal('show');
    });

    $('#group_name_content').addClass('d-none');
    $('#ck_is_keyed_translation').click(function() {
        if (this.checked) {
            $('#group_name_content').removeClass('d-none');
        } else {
            $('#group_name_content').addClass('d-none');
        }
    });

    $('#translationModal').on('shown.bs.modal', function () {
        const trans_id= @this.get('trans_id');
        const group = @this.get('group');

        if (group != '*' && group.length > 0) {
            $('#ck_is_keyed_translation').attr('checked', true);
            $('#group_name_content').removeClass('d-none');
        } else {
            $('#ck_is_keyed_translation').attr('checked', false);
            $('#group_name_content').addClass('d-none');
        }

        if (!trans_id) {
            $('#btnAdd').removeClass('d-none');
            $('#btnUpdate').addClass('d-none');
        } else {
            $('#btnAdd').addClass('d-none');
            $('#btnUpdate').removeClass('d-none');
        }
    });

    $('#inlineEditModal').on('shown.bs.modal', function () {
        const single_lang= @this.get('single_lang');
        $('#single_lang').text(single_lang.toUpperCase());
    });

    window.addEventListener('showConfirmDialog', (event) => {
        $('#mdlConfirmDelete').modal('show');
    });

});
</script>
@endpush