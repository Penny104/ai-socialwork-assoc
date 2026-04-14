<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 管理員
        User::create([
            'name'           => '系統管理員',
            'email'          => 'admin@socialwork.org.tw',
            'password'       => Hash::make('password'),
            'phone'          => '02-12345678',
            'role'           => 'admin',
            'license_number' => null,
            'is_active'      => true,
            'email_verified_at' => now(),
        ]);

        // 社工師會員
        User::create([
            'name'           => '陳雅婷',
            'email'          => 'yating.chen@example.com',
            'password'       => Hash::make('password'),
            'phone'          => '0912-345-678',
            'role'           => 'member',
            'license_number' => 'SW-001234',
            'is_active'      => true,
            'email_verified_at' => now(),
        ]);

        // 一般訪客
        User::create([
            'name'           => '林志明',
            'email'          => 'chiaming.lin@example.com',
            'password'       => Hash::make('password'),
            'phone'          => '0987-654-321',
            'role'           => 'guest',
            'license_number' => null,
            'is_active'      => true,
            'email_verified_at' => now(),
        ]);
    }
}
