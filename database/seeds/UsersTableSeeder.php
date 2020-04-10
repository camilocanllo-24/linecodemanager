<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->insert([
            'nombres' => 'Dilinson Murillo',
            'agency_id' => 1,
            'rol' => 'superadmin',
            'email' => 'dilinso.murillo@linecode.com',
            'password' => Hash::make('1996'),
            'fecha_registro' => \Carbon\Carbon::now(),
            'estado' => 'Activo'
        ]);
        DB::table('users')->insert([
            'nombres' => 'Yuan Mosquera',
            'agency_id' => 1,
            'rol' => 'superadmin',
            'email' => 'yuan.mosquera@linecode.com',
            'password' => Hash::make('DiosNumero1'),
            'fecha_registro' => \Carbon\Carbon::now(),
            'estado' => 'Activo'
        ]);
        DB::table('users')->insert([
            'nombres' => 'Camilo Andres Llorente',
            'agency_id' => 1,
            'rol' => 'superadmin',
            'email' => 'camilo.llorente@linecode.com',
            'password' => Hash::make('1995141622Canllo'),
            'fecha_registro' => \Carbon\Carbon::now(),
            'estado' => 'Activo'
        ]);
    }
}
