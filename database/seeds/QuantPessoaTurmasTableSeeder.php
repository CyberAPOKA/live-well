<?php

use Illuminate\Database\Seeder;

class QuantPessoaTurmasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('quant_pessoa_turmas')->delete();
        
        \DB::table('quant_pessoa_turmas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'quantidade' => 3,
                'created_at' => NULL,
                'updated_at' => '2019-02-13 14:32:13',
            ),
        ));
        
        
    }
}