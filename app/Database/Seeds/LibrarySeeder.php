<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class LibrarySeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        // seed 3 user
        $this->db->table('users')->insert([
            'nama'       => 'Admin Pustakawan',
            'email'      => 'admin@perpus.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'no_telp'    => '08123456789',
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

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

        // seed 5 buku
        for ($i = 1; $i <= 5; $i++) {
            $isbn = $faker->unique()->isbn13;
            $this->db->table('books')->insert([
                'isbn'         => $isbn,
                'judul'        => $faker->sentence(3),
                'penulis'      => $faker->name,
                'penerbit'     => $faker->company,
                'tahun_terbit' => $faker->year,
                'cover_url'    => "https://covers.openlibrary.org/b/isbn/$isbn-M.jpg", // Simulasi Open Library API
            ]);

            $bookId = $this->db->insertID();

            // Buat 2 eksemplar fisik untuk setiap buku
            for ($j = 1; $j <= 2; $j++) {
                $this->db->table('book_copies')->insert([
                    'id_buku'        => $bookId,
                    'kode_eksemplar' => "EKS-" . str_pad($bookId, 3, '0', STR_PAD_LEFT) . "-$j",
                    'kondisi'        => 'bagus',
                    'lokasi_rak'     => 'RAK-' . $faker->randomElement(['A1', 'B2', 'C3', 'D4']),
                    'status_tersedia'=> 'tersedia'
                ]);
            }
        }

        // seed loans
        for ($i = 0; $i < 15; $i++) {
            $tglPinjam = $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d');
            $this->db->table('loans')->insert([
                'id_user'         => rand(2, 26), // Random member
                'id_eksemplar'    => rand(1, 110), // Random copy
                'tgl_pinjam'      => $tglPinjam,
                'tgl_jatuh_tempo' => date('Y-m-d', strtotime($tglPinjam . ' + 7 days')),
                'status_pinjam'   => 'dipinjam'
            ]);
        }
    }
}