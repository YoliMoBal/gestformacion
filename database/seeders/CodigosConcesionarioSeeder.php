<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CodigosConcesionarioSeeder extends Seeder
{
    public function run()
    {
        $ubicaciones = DB::table('ubicaciones')->pluck('id', 'nombre');

        DB::table('codigos_concesionario')->insert([
            ['codigo' => '5037',  'ubicacion_id' => $ubicaciones['Marbella']],
            ['codigo' => '5473',  'ubicacion_id' => $ubicaciones['Marbella']],
            ['codigo' => '5040',  'ubicacion_id' => $ubicaciones['Estepona']],
            ['codigo' => '5039',  'ubicacion_id' => $ubicaciones['Mijas']],
            ['codigo' => '5439',  'ubicacion_id' => $ubicaciones['Antequera']],
            ['codigo' => '5364',  'ubicacion_id' => $ubicaciones['Ronda']],
            ['codigo' => '55000', 'ubicacion_id' => $ubicaciones['Coín']],
        ]);
    }
}