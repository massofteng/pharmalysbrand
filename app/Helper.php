<?php

use App\Models\Country;

if (!function_exists('get_countries')) {
    function get_countries()
    {
        $countries = Country::where('status', 1)->get();
        return $countries;
    }
}

if (!function_exists('get_content_field')) {
    /**
     * get content field
     *
     * @param  array  $content
     * @param  string  $field
     * @param  string  $default
     * @return string
     */
    function get_content_field($content, $field, $default = ''): string
    {
        if (isset($content[$field])) {
            return $content[$field];
        }

        return $default;
    }
}


if (!function_exists('get_image_content')) {
    /**
     * get content field
     *
     * @param  array  $content
     * @param  string  $field
     * @param  string  $default
     * @return string
     */
    function get_image_content($content, $field): string
    {
        $content = get_content_field($content, $field);

        if ($content) {
            return asset('storage/' . $content);
        }

        //TODO: ADD DEFAULT IMAGE
        return '';
    }
}


if (!function_exists('pharmalys_get_banner_mime')) {
    /**
     * get storage file mime type
     *
     * @param  string  $storage_file
     * @return string
     */
    function pharmalys_get_banner_mime($file)
    {
        $file_part = explode('.', $file);
        $ext = end($file_part);

        $allowed_banner_file_types = config('pharmalys.allowed_banner_file_types');

        return isset($allowed_banner_file_types[$ext]) ? $allowed_banner_file_types[$ext] : '';
    }
}

if (!function_exists('page_meta_cache_key')) {
    function page_meta_cache_key($pageId)
    {
        return "settings" . $pageId;
    }
}
