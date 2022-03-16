<?php

use Illuminate\Database\Seeder;

class PessoasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pessoas')->delete();
        
        \DB::table('pessoas')->insert(array ());
    }
}