<?php

use Illuminate\Database\Seeder;

class TurmasPessoasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('turmas_pessoas')->delete();
        
        \DB::table('turmas_pessoas')->insert(array ());
    }
}