<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        // 1. Generate 20 Anggota (Members)
        echo "Generating 20 Members...\n";
        $anggotaData = [];
        for ($i = 0; $i < 20; $i++) {
            $anggotaData[] = [
                'nama'       => $faker->name,
                'email'      => $faker->unique()->safeEmail,
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'Member',
                'no_telp'    => $faker->numerify('081#########'),
                'alamat'     => substr($faker->address, 0, 200),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('users')->insertBatch($anggotaData);

        // 2. Generate 50 Buku (Books)
        echo "Generating 50 Books...\n";
        $bukuData = [];
        $kategoriList = ['Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Biografi', 'Bisnis', 'Seni'];
        for ($i = 0; $i < 50; $i++) {
            $bukuData[] = [
                'judul'      => ucwords(implode(' ', $faker->words(rand(2, 5)))),
                'penulis'    => $faker->name,
                'penerbit'   => $faker->company,
                'tahun_terbit'=> $faker->year,
                'isbn'       => $faker->isbn13,
                'kategori'   => $faker->randomElement($kategoriList),
                'cover_image'=> null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('books')->insertBatch($bukuData);

        // 3. Generate Eksemplar untuk setiap Buku (Masing-masing 2 eksemplar)
        echo "Generating Copies (Eksemplar)...\n";
        $eksemplarData = [];
        $bukuIds = $this->db->table('books')->select('id_buku')->orderBy('id_buku', 'DESC')->limit(50)->get()->getResultArray();
        
        foreach ($bukuIds as $b) {
            for ($j = 1; $j <= 2; $j++) {
                $eksemplarData[] = [
                    'id_buku'         => $b['id_buku'],
                    'kode_eksemplar'  => 'EKS-' . $b['id_buku'] . '-' . str_pad($j, 3, '0', STR_PAD_LEFT),
                    'status_tersedia' => 'tersedia',
                    'kondisi'         => $faker->randomElement(['baik', 'baik', 'rusak ringan']),
                    'lokasi_rak'      => 'Rak ' . $faker->randomLetter . '-' . rand(1, 10)
                ];
            }
        }
        $this->db->table('book_copies')->insertBatch($eksemplarData);

        // 4. Generate 15 Riwayat Peminjaman Dummy
        echo "Generating 15 Loan Records...\n";
        $peminjamanData = [];
        $userIds = $this->db->table('users')->select('id_user')->where('role', 'Member')->orderBy('id_user', 'DESC')->limit(20)->get()->getResultArray();
        $eksemplarIds = $this->db->table('book_copies')->select('id_eksemplar')->orderBy('id_eksemplar', 'DESC')->limit(100)->get()->getResultArray();
        
        $statuses = ['diajukan', 'dipinjam', 'kembali', 'terlambat'];

        for ($i = 0; $i < 15; $i++) {
            $tgl_pinjam = $faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d');
            $tgl_jatuh_tempo = date('Y-m-d', strtotime($tgl_pinjam . ' + 7 days'));
            $status = $faker->randomElement($statuses);
            
            $tgl_kembali = null;
            if ($status == 'kembali' || $status == 'terlambat') {
                $hari_kembali = rand(5, 12); 
                $tgl_kembali = date('Y-m-d', strtotime($tgl_pinjam . " + $hari_kembali days"));
            }

            $user = $faker->randomElement($userIds);
            $eks = $faker->randomElement($eksemplarIds);

            $peminjamanData[] = [
                'id_user' => $user['id_user'],
                'id_eksemplar' => $eks['id_eksemplar'],
                'tgl_pinjam' => $tgl_pinjam,
                'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
                'tgl_kembali' => $tgl_kembali,
                'status_pinjam' => $status,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($status == 'dipinjam' || $status == 'terlambat') {
                $this->db->table('book_copies')->where('id_eksemplar', $eks['id_eksemplar'])->update(['status_tersedia' => 'dipinjam']);
            }
        }
        $this->db->table('loans')->insertBatch($peminjamanData);

        echo "Seeding completed successfully!\n";
    }
}
