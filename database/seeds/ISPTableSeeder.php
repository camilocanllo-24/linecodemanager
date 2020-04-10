<?php

use Illuminate\Database\Seeder;

class ISPTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('isps')->insert([
               'nombre' => 'LINE CODE',
            'direccion' => 'Calle 103 # 14-22',
            'municipio' => 'Turbo Antioquia',
            'telefono' => '3108295191',
            'estado' => 'activo',
            'nit' => '1045524493',
            'contacto' => 'Yuan Mosquera',
            'email' => 'yuan.mosquera@linecode.com'
        ]);
    }
}
