<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('akun_admins')->insert([
            'nama' => 'Super Admin',
            'username' => 'admin_400',
            'password' => Hash::make('Admin_313212')
        ]);
    }
}
