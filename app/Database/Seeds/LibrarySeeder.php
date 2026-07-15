<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class LibrarySeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        // PENTING: Kosongkan tabel dulu agar tidak ada data ganda yang bikin error login
        // Matikan sementara foreign key checks agar bisa truncate tabel yang berelasi
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('users')->truncate();
        $this->db->table('books')->truncate();
        $this->db->table('book_copies')->truncate();
        $this->db->table('loans')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // 1. SEED AKUN ADMIN (Password: admin123)
        $this->db->table('users')->insert([
            'nama'       => 'Admin Pustakawan',
            'email'      => 'admin@perpus.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'no_telp'    => '08123456789',
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // 2. SEED 3 AKUN MEMBER (Password: member123)
        for ($i = 0; $i < 3; $i++) {
            $this->db->table('users')->insert([
                'nama'       => $faker->name,
                'email'      => $faker->unique()->safeEmail,
                'password'   => password_hash('member123', PASSWORD_DEFAULT),
                'no_telp'    => $faker->phoneNumber,
                'role'       => 'member',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // --- SEED BUKU ---
        for ($i = 1; $i <= 5; $i++) {
            $isbn = $faker->unique()->isbn13;
            $this->db->table('books')->insert([
                'isbn'         => $isbn,
                'judul'        => $faker->sentence(3),
                'penulis'      => $faker->name,
                'penerbit'     => $faker->company,
                'tahun_terbit' => $faker->year,
                'cover_url'    => "https://covers.openlibrary.org/b/isbn/$isbn-M.jpg", 
            ]);

            $bookId = $this->db->insertID();

            // Buat 2 eksemplar fisik untuk setiap buku
            for ($j = 1; $j <= 2; $j++) {
                $this->db->table('book_copies')->insert([
                    'id_buku'         => $bookId,
                    'kode_eksemplar'  => "EKS-" . str_pad((string)$bookId, 3, '0', STR_PAD_LEFT) . "-$j",
                    'kondisi'         => 'bagus',
                    'lokasi_rak'      => 'RAK-' . $faker->randomElement(['A1', 'B2', 'C3', 'D4']),
                    'status_tersedia' => 'tersedia'
                ]);
            }
        }

        // --- SEED PEMINJAMAN ---
        // Catatan: Karena tabel baru di-truncate, ID user hanya dari 1 s/d 4 (1 Admin, 3 Member)
        // Dan ID eksemplar hanya dari 1 s/d 10 (5 buku x 2)
        for ($i = 0; $i < 10; $i++) {
            $tglPinjam = $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d');
            $this->db->table('loans')->insert([
                'id_user'         => rand(2, 4), // Disesuaikan: Hanya ambil dari ID Member (2,3,4)
                'id_eksemplar'    => rand(1, 10), // Disesuaikan: Hanya ada 10 eksemplar
                'tgl_pinjam'      => $tglPinjam,
                'tgl_jatuh_tempo' => date('Y-m-d', strtotime($tglPinjam . ' + 7 days')),
                'status_pinjam'   => 'dipinjam'
            ]);
        }
    }
}