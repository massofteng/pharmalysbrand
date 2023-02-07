<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**r
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language = [
            'language_key'  => 'en',
            'language_name' => 'English',
            'status'        => 1,
            'country_id'    => 1,
            'default'       => 1,
        ];
        Language::updateOrCreate(['language_key' => $language['language_key']], $language);
    }
}
