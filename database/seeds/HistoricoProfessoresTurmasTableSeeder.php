<?php

use Illuminate\Database\Seeder;

class HistoricoProfessoresTurmasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('historico_professores_turmas')->delete();
        
        \DB::table('historico_professores_turmas')->insert(array ());
    }
}