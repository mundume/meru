<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class categorieseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Festive/December Season',
            'School Opening',
            'School Closing',
            'Easter Season',
            'Valentine Season',
            'Others'
        ];
        foreach($data as $category) {
            Category::create(['name' => $category]);
        }
    }
}
