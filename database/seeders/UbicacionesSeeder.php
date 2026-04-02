<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbicacionesSeeder extends Seeder
{
    public function run()
    {
        DB::table('ubicaciones')->insert([
            ['nombre' => 'Marbella'],
            ['nombre' => 'Estepona'],
            ['nombre' => 'Mijas'],
            ['nombre' => 'Antequera'],
            ['nombre' => 'Ronda'],
            ['nombre' => 'Coín'],
        ]);
    }
}
