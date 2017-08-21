<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = new \App\Item([
            'name' => 'Mercedes-Benz CLA-Class',
            'info' => 'Mercedes-Benz CLA-Class',
            'price' => '30000',
            'image' => 'aHZvcfF28naXaK31.jpg',
            'category_id' => '1'
        ]);
        $item->save();

        $item = new \App\Item([
            'name' => 'Lenovo Tablet',
            'info' => 'Ideapad with core i5',
            'price' => '700',
            'image' => 'PJLZ82Xvbet6PpTn.jpg',
            'category_id' => '2'
        ]);
        $item->save();

        $item = new \App\Item([
            'name' => 'Nissan GTR',
            'info' => 'Nissan GTR',
            'price' => '40000',
            'image' => 'mfF3JvF6bO8AoHOH.jpg',
            'category_id' => '1'
        ]);
        $item->save();

        $item = new \App\Item([
            'name' => 'Lenovo Ideapad',
            'info' => 'Idea pad with core i7',
            'price' => '1000',
            'image' => 'ln5w5YGFwumPiMUh.jpg',
            'category_id' => '2'
        ]);
        $item->save();

        $item = new \App\Item([
            'name' => 'Dunkirk',
            'info' => 'The new Christopher Nolan movie',
            'price' => '10',
            'image' => 'S3lKnceR3V3puegZ.jpg',
            'category_id' => '4'
        ]);
        $item->save();

        $item = new \App\Item([
            'name' => 'Mercedes-Benz C-Class',
            'info' => 'Mercedes-Benz C-Class',
            'price' => '35000',
            'image' => '20Wmpsckb6Rzg0bB.jpg',
            'category_id' => '1'
        ]);
        $item->save();
    }
}
