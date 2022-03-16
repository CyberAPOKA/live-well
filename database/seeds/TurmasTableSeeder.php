<?php

use Illuminate\Database\Seeder;

class TurmasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('turmas')->delete();
        
        \DB::table('turmas')->insert(array ());
    }
}