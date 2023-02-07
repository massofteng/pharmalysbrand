<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'         => 'Insights',
                'status'       => 1
            ],
            [
                'name'         => 'Manufacturing',
                'status'       => 1
            ],
            [
                'name'         => 'Research',
                'status'       => 1
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
