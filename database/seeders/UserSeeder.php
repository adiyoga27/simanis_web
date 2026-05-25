<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Desa
        $desa1 = Desa::create([
            'name' => 'Desa Airlangga',
            'address' => 'Kecamatan Gubeng, Surabaya, Jawa Timur',
        ]);
        $desa2 = Desa::create([
            'name' => 'Desa Tlogomas',
            'address' => 'Kecamatan Lowokwaru, Malang, Jawa Timur',
        ]);
        $desa3 = Desa::create([
            'name' => 'Desa Sidokare',
            'address' => 'Kecamatan Sidoarjo, Sidoarjo, Jawa Timur',
        ]);

        // Superadmin
        User::create([
            'name' => 'Super Admin SIMANIS',
            'email' => 'superadmin@simanis.id',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
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

        // Kepala Puskesmas
        User::create([
            'name' => 'Dr. Andi Pratama',
            'email' => 'kapus@simanis.id',
            'username' => 'kapus',
            'password' => Hash::make('password123'),
            'role' => 'kepala_puskesmas',
            'email_verified_at' => now(),
            'birthdate' => '1985-03-15',
            'phone' => '081122334455',
            'jk' => 'L',
            'is_smoke' => false,
            'medical_history' => '-',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'subdistrict' => 'Gubeng',
            'village' => 'Airlangga',
            'address' => 'Jl. Dharmahusada No. 50',
            'kode_pos' => 60285,
            'tall' => 172,
            'weight' => 70,
            'blood' => 'A',
        ]);

        // Kepala Desa
        User::create([
            'name' => 'H. Ahmad Syahputra',
            'email' => 'kades@simanis.id',
            'username' => 'kades',
            'password' => Hash::make('password123'),
            'role' => 'kepala_desa',
            'desa_id' => $desa1->id,
            'email_verified_at' => now(),
            'birthdate' => '1978-07-20',
            'phone' => '085678901234',
            'jk' => 'L',
            'is_smoke' => false,
            'medical_history' => '-',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'subdistrict' => 'Gubeng',
            'village' => 'Airlangga',
            'address' => 'Jl. Airlangga No. 10',
            'kode_pos' => 60286,
            'tall' => 168,
            'weight' => 75,
            'blood' => 'B',
        ]);

        // Kader
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'kader@simanis.id',
            'username' => 'kader',
            'password' => Hash::make('password123'),
            'role' => 'kader',
            'desa_id' => $desa1->id,
            'email_verified_at' => now(),
            'birthdate' => '1992-04-10',
            'phone' => '089876543210',
            'jk' => 'P',
            'is_smoke' => false,
            'medical_history' => '-',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'subdistrict' => 'Gubeng',
            'village' => 'Airlangga',
            'address' => 'Jl. Kertajaya No. 25',
            'kode_pos' => 60286,
            'tall' => 160,
            'weight' => 55,
            'blood' => 'O',
        ]);

        // Pasien (Diabetes)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@simanis.id',
            'username' => 'budi',
            'password' => Hash::make('password123'),
            'role' => 'pasien',
            'desa_id' => $desa2->id,
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

        // Pasien (Diabetes - perempuan)
        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@simanis.id',
            'username' => 'siti',
            'password' => Hash::make('password123'),
            'role' => 'pasien',
            'desa_id' => $desa3->id,
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

        // Pasien (belum verifikasi email)
        User::create([
            'name' => 'Cahyo Wibowo',
            'email' => 'cahyo@simanis.id',
            'username' => 'cahyo',
            'password' => Hash::make('password123'),
            'role' => 'pasien',
            'desa_id' => $desa2->id,
            'email_verified_at' => null,
            'birthdate' => '1988-03-10',
            'phone' => '081122334455',
            'jk' => 'L',
            'is_smoke' => false,
            'medical_history' => 'Prediabetes',
            'province' => 'Jawa Timur',
            'city' => 'Malang',
            'subdistrict' => 'Lowokwaru',
            'village' => 'Tlogomas',
            'address' => 'Jl. Kalimantan No. 78',
            'kode_pos' => 65144,
            'tall' => 168,
            'weight' => 85,
            'blood' => 'AB',
        ]);
    }
}
