<?php

use Illuminate\Database\Seeder;

class HistoricoNucleosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('historico_nucleos')->delete();
        
        \DB::table('historico_nucleos')->insert(array ());   
    }
}