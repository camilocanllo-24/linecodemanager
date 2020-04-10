<?php

use Illuminate\Database\Seeder;

class AgencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agencies')->insert([
            'nombre' => 'Principal',
            'direccion' => 'Turbo Antioquia',
            'contacto' => 'Yuan Mosquera',
            'telefono' => '3108295191',
            'email' => 'yuan.mosquera@linecode.com',
            'municipio' => 'Turbo',
            'isp_id' => 1,
            'estado' => 'activo',
            'dia_facturacion' => -1,
            'dia_pago' => -1,
            'dia_corte' => -1,
            'facturas_vencidas' => 1,
            'tipo_facturacion' => 'prepago'
        ]);
    }
}
