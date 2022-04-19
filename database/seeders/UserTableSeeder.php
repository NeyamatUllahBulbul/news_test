<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'SuperAdmin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'type'     => User::TYPE_SUPERADMIN,
        ]);
    }
}
