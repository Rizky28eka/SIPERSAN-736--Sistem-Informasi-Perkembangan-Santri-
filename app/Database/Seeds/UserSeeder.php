<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'kepala',
                'name'     => 'Kepala Yayasan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'guru',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'role'     => 'guru',
                'name'     => 'Guru Contoh',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'wali',
                'password' => password_hash('wali123', PASSWORD_DEFAULT),
                'role'     => 'wali',
                'name'     => 'Wali Santri Contoh',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
