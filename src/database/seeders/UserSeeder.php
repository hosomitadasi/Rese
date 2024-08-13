<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        $users = [
            ['name' => '田中太郎', 'email' => 'example1@example.com', 'password' => 'password'],

            ['name' => '佐藤恵', 'email' => 'example2@example.com', 'password' => 'password'],

            ['name' => '鈴木拓郎', 'email' => 'example3@example.com', 'password' => 'password'],
        ];

        foreach ($users as $user) {
            User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password'])
        ]);
        }
    }
}
