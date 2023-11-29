<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Adiciona o usuario principal admin
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@teste.com.br',
            'password' => Hash::make('admin')
        ]);

        //Adiciona os status dos pedidos
        DB::table('pedidos_status')->insert([
            'descricao' => 'Solicitado'
        ]);
        DB::table('pedidos_status')->insert([
            'descricao' => 'Concluído'
        ]);
        DB::table('pedidos_status')->insert([
            'descricao' => 'Cancelado'
        ]);
    }
}
