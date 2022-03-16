<?php

use Illuminate\Database\Seeder;

class NucleosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('nucleos')->delete();
        
        \DB::table('nucleos')->insert(array ());
    }
}