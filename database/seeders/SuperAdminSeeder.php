<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::where('email', 'admin@denpasarinstitute.id')->delete();
        
        $user = User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@denpasarinstitute.id',
            'password' => Hash::make('Admin@DI2026'),
            'role'     => 'superadmin',
            'is_active'=> true,
            'email_verified_at' => now(),
        ]);
    }
}