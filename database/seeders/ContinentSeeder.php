<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Seeder;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $continent = [
            'name'        => 'Europe',
            'status'      => 1,
        ];

        Continent::updateOrCreate(['name' => $continent['name']], $continent);
    }
}
