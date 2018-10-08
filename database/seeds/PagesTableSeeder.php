<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([

            [
                'name' => 'About us',
                'name_ar' => ' عنا ',
                'desc' => ' About us ',
                'desc_ar' => ' عنا ',
                
            ],
            [
                'name' => 'Contacts',
                'name_ar' => ' اتصل بنا ',
                'desc' => ' Contacts  ',
                'desc_ar' => ' اتصل بنا ',
                
            ],
            [
                'name' => ' Terms and Conditions ',
                'name_ar' => ' الشروط والاحكام ',
                'desc' => ' Terms and Conditions  ',
                'desc_ar' => ' الشروط والاحكام ',
                
            ]

        ]);

    }
}
