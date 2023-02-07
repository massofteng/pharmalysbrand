<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Country;
use App\Models\Language;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage($locale)
    {
        $language = Language::find($locale);
        Session::put('locale', $language->language_key);
        return true;
    }

    public function getLanguage($country_name)
    {

        //dd($country_name);
        $data = [];
        $countries = Country::where('status', 1)->get();
        $country_info = Country::with('languages')->where('countries.name', 'like', '%' . $country_name . '%')->first();
        if ($country_info) {
            $language_infos = $country_info->languages;
        }
        if ($language_infos) {
            foreach ($language_infos as $language_info) {
                if ($language_info->default == 1) {
                    Session::put('locale', $language_info->language_key);
                }
            }
        }

        $data['countries'] =  $countries;
        $data['languages'] =  $language_infos;

        return $data;
    }

    public function getOnChangeLanguage($id, $country_name)
    {
        //$data = [];
        //$countries = Country::where('status', 1)->get();
        // $country_info = Country::with('languages')->where('countries.name', 'like', '%' . $country_name . '%')->first();
        // if ($country_info) {
        //     $language_infos = $country_info->languages;
        // }

        $language = Language::find($id);
        Session::put('locale', $language->language_key);

        return $language->language_key;
    }

    public function getLanguageById($id)
    {
        $languages = Language::where('country_id', $id)->get();
        return $languages;
    }
}
