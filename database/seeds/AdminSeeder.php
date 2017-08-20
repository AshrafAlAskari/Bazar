<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\Admin([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$auS.lBj1Za95mm4xOHkUfe3biMBi4Q5JbNqO920xPnysBctWiPYdy'
        ]);
        $admin->save();
    }
}
