<?php

use Illuminate\Database\Seeder;

class AnamnesesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('anamneses')->delete();
        
        \DB::table('anamneses')->insert(array ()); 
    }
}