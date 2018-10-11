<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert([

            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => '$2y$12$bw.bakBVg5Bkj4lFhpMyheXLJAeFvDIKyK10.J/yCE9cqE9kxGTce', //123
                'activation' => '1',
                'image' => '0',
            ]
        ]);
        
    }
}
