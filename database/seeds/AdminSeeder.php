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
            'password' => '$2y$10$305Li22WnlXGPbkoXxzeL.gOECgdwD3.JhdUPhAcw7OP5jLx1pu2e'
        ]);
        $admin->save();
    }
}
