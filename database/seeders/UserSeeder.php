<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name'=>'Admin',
            'email'=>'admin17@gmail.com',
            'password'=>Hash::make('admin17'),
            'phone_number'=>'081346371568',
            'avatar'=>'',
            'role'=>'admin',
            'created_at'=>now(),
            'updated_at'=>now()
            // ,'name'=>'Putu Aditya Eka Putra',
            // 'email'=>'putuaditya17800@gmail.com',
            // 'password'=>Hash::make('putu17'),
            // 'phone_number'=>'085820488947',
            // 'avatar'=>'',
            // 'role'=>'admin',
            // 'created_at'=>now(),
            // 'updated_at'=>now()
        ]);
    }
}
