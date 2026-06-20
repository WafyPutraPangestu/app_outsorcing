<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Klien;
use App\Models\Karyawan;
use App\Models\Penempatan;
use App\Models\KriteriaPenilaian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Super Admin Valdo',
            'email'    => 'admin@gmail.com',
            'role'     => 'admin',
            'password' => Hash::make('password123'),
        ]);
        User::create([
            'name'     => 'Manajemen Operasional',
            'email'    => 'manajemen@gmail.com',
            'role'     => 'manajemen',
            'password' => Hash::make('password123'),
        ]);
        KriteriaPenilaian::insert([
            [
                'nama_kriteria' => 'Kedisiplinan & Kehadiran',
                'bobot_nilai' => 30.00,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_kriteria' => 'Pencapaian Target / KPI',
                'bobot_nilai' => 45.00,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_kriteria' => 'Sikap & Kerjasama Tim',
                'bobot_nilai' => 25.00,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        $klienWafy = Klien::create([
            'nama_perusahaan' => 'PT Teknologi Wafy',
            'alamat_kantor' => 'Jl. Sudirman Tower A, Lt. 12, Jakarta',
            'email_hrd_klien' => 'wafyputrapangestu@gmail.com',
            'nama_kontak_person' => 'Bapak Wafy (HR Manager)',
        ]);
        $klienWahyu = Klien::create([
            'nama_perusahaan' => 'PT Wahyu Sejahtera',
            'alamat_kantor' => 'Jl. Gatot Subroto No. 45, Jakarta',
            'email_hrd_klien' => 'wahyusyipul@gmail.com',
            'nama_kontak_person' => 'Bapak Wahyu (Direktur Operasional)',
        ]);
        $karyawan1 = Karyawan::create([
            'nik' => 'KRY-2026001',
            'nama_karyawan' => 'Budi Santoso',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Kebon Kacang Raya, Jakarta Pusat',
            'no_hp' => '081234567890',
            'posisi' => 'IT Support Specialist',
            'status_karyawan' => 'aktif',
        ]);
        $karyawan2 = Karyawan::create([
            'nik' => 'KRY-2026002',
            'nama_karyawan' => 'Siti Aminah',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Melati Jingga, Jakarta Selatan',
            'no_hp' => '081987654321',
            'posisi' => 'Customer Service Representative',
            'status_karyawan' => 'aktif',
        ]);
        Penempatan::create([
            'id_karyawan' => $karyawan1->id_karyawan,
            'id_klien' => $klienWafy->id_klien,
            'tanggal_mulai' => Carbon::now()->subMonths(3)->format('Y-m-d'),
            'tanggal_selesai' => Carbon::now()->addMonths(9)->format('Y-m-d'),
            'status_aktif' => true,
            'rekomendasi_sistem' => 'belum_dievaluasi',
        ]);
        Penempatan::create([
            'id_karyawan' => $karyawan2->id_karyawan,
            'id_klien' => $klienWahyu->id_klien,
            'tanggal_mulai' => Carbon::now()->subMonths(11)->format('Y-m-d'),
            'tanggal_selesai' => Carbon::now()->addMonths(1)->format('Y-m-d'),
            'status_aktif' => true,
            'rekomendasi_sistem' => 'belum_dievaluasi',
        ]);
    }
}
