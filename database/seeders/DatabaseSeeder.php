<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['Admin MyLaundry', 'admin@mylaundry.test', UserRole::Admin],
            ['Karyawan 1', 'staff@mylaundry.test', UserRole::Staff],
            ['Pelanggan Demo', 'client@mylaundry.test', UserRole::Client],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            User::firstOrNew(['email' => $email])
                ->forceFill([
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => $role,
                    'email_verified_at' => now(),
                ])
                ->save();
        }

        $services = [
            ['Cuci Kiloan Reguler', 'kg', 7000, 3],
            ['Cuci + Setrika', 'kg', 9000, 3],
            ['Setrika Saja', 'kg', 5000, 2],
            ['Cuci Express', 'kg', 15000, 1],
            ['Bed Cover', 'pcs', 25000, 3],
            ['Jas / Blazer', 'pcs', 30000, 4],
        ];

        foreach ($services as [$name, $unit, $price, $days]) {
            Service::firstOrCreate(
                ['name' => $name],
                ['unit' => $unit, 'price' => $price, 'estimated_days' => $days, 'is_active' => true]
            );
        }
    }
}