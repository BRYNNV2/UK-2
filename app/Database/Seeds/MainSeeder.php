<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Truncate tables to avoid duplicates
        $this->db->disableForeignKeyChecks();
        $this->db->table('auth_groups_users')->truncate();
        $this->db->table('users')->truncate();
        $this->db->table('auth_groups')->truncate();
        $this->db->table('prodi')->truncate();
        $this->db->table('jurusan')->truncate();
        $this->db->table('fakultas')->truncate();
        $this->db->enableForeignKeyChecks();

        // 1. Roles (Auth Groups)
        $groups = [
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'kaprodi', 'description' => 'Ketua Program Studi'],
            ['name' => 'pimpinan', 'description' => 'Pimpinan Fakultas/Univ'],
            ['name' => 'mahasiswa', 'description' => 'Mahasiswa'],
        ];

        echo "DEBUG: Inserting Groups...\n";
        try {
            $this->db->table('auth_groups')->insertBatch($groups);
            echo "DEBUG: Groups Inserted.\n";
        } catch (\Throwable $e) {
            echo "DEBUG: Groups Insert Error: " . $e->getMessage() . "\n";
        }

        // 2. Admin User
        echo "DEBUG: Inserting Admin (Raw)...\n";
        $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);
        $this->db->table('users')->insert([
            'email'         => 'admin@uk2.com',
            'username'      => 'admin',
            'password_hash' => $passwordHash,
            'active'        => 1,
            'nama_user'     => 'Administrator Utama',
            'role'          => 'admin',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        $userId = $this->db->insertID();
        echo "DEBUG: Admin Inserted ID: $userId\n";

        // Assign Admin to Group
        if ($userId) {
            $this->db->table('auth_groups_users')->insert([
                'group_id' => 1, // admin
                'user_id'  => $userId,
            ]);
        }

        // 3. Fakultas (FTTK)
        echo "DEBUG: Inserting Fakultas...\n";
        $this->db->table('fakultas')->insert([
            'nama_fakultas' => 'FTTK'
        ]);
        $idFakultas = $this->db->insertID();
        echo "DEBUG: Fakultas ID: $idFakultas\n";

        // 4. Jurusan
        $jurusans = [
            ['nama_jurusan' => 'Jurusan Teknik Elektro dan Informatika', 'id_fakultas' => $idFakultas],
            ['nama_jurusan' => 'Jurusan Teknik Industri Maritim', 'id_fakultas' => $idFakultas],
            ['nama_jurusan' => 'Jurusan Teknik Sipil dan Arsitektur', 'id_fakultas' => $idFakultas],
        ];
        $this->db->table('jurusan')->insertBatch($jurusans);
        
        // Get Jurusan IDs (assuming standard order 1, 2, 3)
        // 5. Prodi (Sample Data)
        // Elektro & Informatika (ID 1)
        $prodis = [
            ['nama_prodi' => 'Teknik Informatika', 'id_jurusan' => 1],
            ['nama_prodi' => 'Sistem Informasi', 'id_jurusan' => 1],
            ['nama_prodi' => 'Teknik Elektro', 'id_jurusan' => 1],
            // Maritim (ID 2)
            ['nama_prodi' => 'Teknik Perkapalan', 'id_jurusan' => 2],
            // Sipil (ID 3)
            ['nama_prodi' => 'Teknik Sipil', 'id_jurusan' => 3],
            ['nama_prodi' => 'Arsitektur', 'id_jurusan' => 3],
        ];
        $this->db->table('prodi')->insertBatch($prodis);
    }
}
