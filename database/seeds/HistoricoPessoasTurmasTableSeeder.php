<?php

use Illuminate\Database\Seeder;

class HistoricoPessoasTurmasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('historico_pessoas_turmas')->delete();
        
        \DB::table('historico_pessoas_turmas')->insert(array ());
    }
}