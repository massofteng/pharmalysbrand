<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = [
            'name'         => 'USA',
            'status'       => 1,
            'continent_id' => 1,
        ];

        Country::updateOrCreate(['name' => $country['name']], $country);
    }
}
