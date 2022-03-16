<?php

use Illuminate\Database\Seeder;

class TurmasProfessoresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('turmas_professores')->delete();
        
        \DB::table('turmas_professores')->insert(array ());
    }
}