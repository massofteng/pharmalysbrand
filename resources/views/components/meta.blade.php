@props([
    'currentPageId' => null
])

@php
    if ( !$currentPageId ) {
        return;
    }

    $page_meta_cache_key = "current_page_".$currentPageId;
    $metas = cache()->get($page_meta_cache_key);

    if ( !$metas ) {
        $metas = \App\Models\PageMeta::where('page_id', $currentPageId)->get();
        cache()->set($page_meta_cache_key, $metas);
    }

    $title = $metas->where('key', 'title')->first()?->value;
    $keywords = $metas->where('key', 'meta_keywords')->first()?->value;
    $description = $metas->where('key', 'meta_description')->first()?->value;

@endphp
<title>{{ $title }} | {{ config('app.name') }}</title>
<meta name="keywords" content="{{ is_array($keywords) ? implode(',', $keywords) : '' }}" />
<meta name="description" content="{{ $description }}" />

