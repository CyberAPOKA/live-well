<?php

use Illuminate\Database\Seeder;

class HistoricoTurmasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('historico_turmas')->delete();
        
        \DB::table('historico_turmas')->insert(array ());
    }
}