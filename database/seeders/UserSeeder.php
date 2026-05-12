<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin SIMANIS',
            'email' => 'admin@simanis.com',
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'birthdate' => '1990-01-01',
            'phone' => '081234567890',
            'jk' => 'L',
            'is_smoke' => false,
            'medical_history' => '-',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'subdistrict' => 'Gubeng',
            'village' => 'Airlangga',
            'address' => 'Jl. Kampus Unair No. 1',
            'kode_pos' => 60286,
            'tall' => 170,
            'weight' => 65,
            'blood' => 'O',
        ]);

        // User biasa (Diabetes)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@simanis.com',
            'username' => 'budi',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
            'birthdate' => '1975-05-15',
            'phone' => '085678901234',
            'jk' => 'L',
            'is_smoke' => true,
            'medical_history' => 'Diabetes Melitus Tipe 2, Hipertensi',
            'province' => 'Jawa Timur',
            'city' => 'Malang',
            'subdistrict' => 'Lowokwaru',
            'village' => 'Tlogomas',
            'address' => 'Jl. Raya Tlogomas No. 45',
            'kode_pos' => 65144,
            'tall' => 165,
            'weight' => 78,
            'blood' => 'B',
        ]);

        // User biasa (Diabetes - perempuan)
        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@simanis.com',
            'username' => 'siti',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
            'birthdate' => '1982-11-20',
            'phone' => '089876543210',
            'jk' => 'P',
            'is_smoke' => false,
            'medical_history' => 'Diabetes Melitus Tipe 2',
            'province' => 'Jawa Timur',
            'city' => 'Sidoarjo',
            'subdistrict' => 'Sidoarjo',
            'village' => 'Sidokare',
            'address' => 'Jl. Pahlawan No. 12',
            'kode_pos' => 61215,
            'tall' => 155,
            'weight' => 62,
            'blood' => 'A',
        ]);

        // User biasa (belum verifikasi email)
        User::create([
            'name' => 'Cahyo Wibowo',
            'email' => 'cahyo@simanis.com',
            'username' => 'cahyo',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => null,
            'birthdate' => '1988-03-10',
            'phone' => '081122334455',
            'jk' => 'L',
            'is_smoke' => false,
            'medical_history' => 'Prediabetes',
            'province' => 'Jawa Timur',
            'city' => 'Jember',
            'subdistrict' => 'Sumbersari',
            'village' => 'Sumbersari',
            'address' => 'Jl. Kalimantan No. 78',
            'kode_pos' => 68121,
            'tall' => 168,
            'weight' => 85,
            'blood' => 'AB',
        ]);
    }
}
