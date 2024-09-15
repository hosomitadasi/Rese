<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'owner']);
        Role::firstOrCreate(['name' => 'user']);

        $users = [
            ['name' => '管理人', 'email' => 'owner@example.com', 'password' => 'adminpass', 'role' => 'admin'],
            ['name' => '店舗代表', 'email' => 'store@example.com', 'password' => 'ownerpass', 'role' => 'owner'],
            ['name' => 'テスト太郎', 'email' => 'example@example.com', 'password' => 'taropass', 'role' => 'user'],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'role' => $userData['role'] === 'admin' ? 1 : ($userData['role'] === 'owner' ? 2 : 3), // roleカラムに適切な値を設定
            ]);

            // Spatieのロールも同時に設定
            $user->assignRole($userData['role']);
        }
    }
}
