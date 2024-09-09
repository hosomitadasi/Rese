<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StoreSeeder::class);

        User::created([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin_password'),
            'role'=> 1,
        ]);
    }
}
