<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UbicacionesSeeder::class,
            DepartamentosSeeder::class,
            CodigosConcesionarioSeeder::class,
            PuestosSeeder::class,
        ]);
    }
}
