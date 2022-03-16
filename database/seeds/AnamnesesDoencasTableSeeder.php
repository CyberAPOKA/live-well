<?php

use Illuminate\Database\Seeder;

class AnamnesesDoencasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('anamneses_doencas')->delete();
        
        \DB::table('anamneses_doencas')->insert(array ());
    }
}