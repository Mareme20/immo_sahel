<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@agence-sahel.sn',
        ], [
            'name' => 'Admin Sahel',
            'email_verified_at' => now(),
            'password' => 'password',
            'role' => 'admin',
            'phone' => '+221770000001',
        ]);

        User::query()->updateOrCreate([
            'email' => 'agent@agence-sahel.sn',
        ], [
            'name' => 'Conseiller Sahel',
            'email_verified_at' => now(),
            'password' => 'password',
            'role' => 'agent',
            'phone' => '+221770000002',
        ]);

        $this->call([
            CategorySeeder::class,
            ContactSeeder::class,
            PropertySeeder::class,
            PropertyImageSeeder::class,
            InquirySeeder::class,
            RentPaymentSeeder::class,
            MaintenanceRequestSeeder::class,
        ]);
    }
}
