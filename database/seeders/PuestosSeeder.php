<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class PuestosSeeder extends Seeder
{
    public function run()
{
    $ventasId = DB::table('departamentos')
        ->where('nombre', 'LIKE', '%venta%')
        ->value('id');

    $postventaId = DB::table('departamentos')
        ->where('nombre', 'LIKE', '%postventa%')
        ->value('id');

    DB::table('puestos')->insert([
        // Ventas
        ['nombre' => 'RESPONSABLE DE MARKETING', 'departamento_id' => $ventasId],
        ['nombre' => 'ASESOR COMERCIAL EXPO', 'departamento_id' => $ventasId],
        ['nombre' => 'ADMINISTRACION VN-VO', 'departamento_id' => $ventasId],
        ['nombre' => 'COORDINADOR VN', 'departamento_id' => $ventasId],
        ['nombre' => 'JEFE DE VENTAS', 'departamento_id' => $ventasId],

        // Postventa
        ['nombre' => 'ASESOR DE SERVICIO', 'departamento_id' => $postventaId],
        ['nombre' => 'JEFE DE POSTVENTA', 'departamento_id' => $postventaId],
        ['nombre' => 'MECANICO POST VENTA', 'departamento_id' => $postventaId],
        ['nombre' => 'ELECTROMECANICO', 'departamento_id' => $postventaId],
        ['nombre' => 'CHAPISTA', 'departamento_id' => $postventaId],
        ['nombre' => 'PINTOR', 'departamento_id' => $postventaId],
        ['nombre' => 'ALMACENERO', 'departamento_id' => $postventaId],
        ['nombre' => 'VENDEDOR PIEZAS RECAMBIO', 'departamento_id' => $postventaId],
        ['nombre' => 'COTEC', 'departamento_id' => $postventaId],
        ['nombre' => 'CARTEC', 'departamento_id' => $postventaId],

        // Transversales
        ['nombre' => 'PERSONAL ADMINISTRATIVO', 'departamento_id' => null],
        ['nombre' => 'MARKETING', 'departamento_id' => null],
        ['nombre' => 'RESPONSABLE DISTRIBUCION', 'departamento_id' => null],
    ]);
}

}

