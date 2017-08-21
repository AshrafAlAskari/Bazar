<?php

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
        $category = new \App\Category([
            'name' => 'Cars',
        ]);
        $category->save();

        $category = new \App\Category([
            'name' => 'Laptops',
        ]);
        $category->save();

        $category = new \App\Category([
            'name' => 'Books',
        ]);
        $category->save();
        
        $category = new \App\Category([
            'name' => 'Movies',
        ]);
        $category->save();
    }
}
