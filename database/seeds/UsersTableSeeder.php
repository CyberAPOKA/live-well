<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        // \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nick' => 'Admin',
                'name' => 'admin',
                'permissao' => 1,
                'email' => 'admin@admin.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$WxCuRbyZGTC93/DyxcE3kuGRIpT2HVJfPQX07IufhKOH7acwL.jNG',
                'remember_token' => 'KKxj9D9BZIwDvSDG9ddlwLGtt1nKSxiVonuzk6EKUK6bu8Gb2LdpjnMs8wEe',
                'created_at' => '2018-11-27 15:58:41',
                'updated_at' => '2018-11-27 15:58:41',
                'deleted_at' => NULL,
            ),
        ));
    }
}