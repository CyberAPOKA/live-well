<?php

use Illuminate\Database\Seeder;

class DoencasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('doencas')->delete();
        
        \DB::table('doencas')->insert(array ());
    }
}