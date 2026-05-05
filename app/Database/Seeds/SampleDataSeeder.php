<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks for clean seeding
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        
        // Clean existing data
        $this->db->table('attendance')->truncate();
        $this->db->table('grades')->truncate();
        $this->db->table('santri')->truncate();
        $this->db->table('classes')->truncate();
        $this->db->table('academic_years')->truncate();
        $this->db->table('announcements')->truncate();
        $this->db->table('development')->truncate();
        $this->db->table('users')->truncate();
        
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

        // 1. Create Academic Year
        $this->db->table('academic_years')->insert([
            'year'       => '2024/2025',
            'semester'   => '1',
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $ayId = $this->db->insertID();

        // 2. Create Multi-User Authentication (Username & Email)
        // Admin
        $this->db->table('users')->insert([
            'username' => 'admin',
            'email'    => 'admin@sipersan.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'kepala',
            'name'     => 'Drs. H. Ahmad Fauzi, M.Pd.I',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Teachers (5 Teachers)
        $teacherNames = [
            'Ustadz Mansur Al-Hafiz', 'Ustadzah Siti Maryam, S.Ag', 
            'Ustadz Zaki Mubarok', 'Ustadzah Nurul Hidayah', 'Ustadz Abdul Somad'
        ];
        $teacherUsernames = ['mansur', 'maryam', 'zaki', 'nurul', 'somad'];
        $teacherIds = [];

        foreach ($teacherNames as $i => $name) {
            $this->db->table('users')->insert([
                'username' => $teacherUsernames[$i],
                'email'    => $teacherUsernames[$i] . '@pesantren.com',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'role'     => 'guru',
                'name'     => $name,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $teacherIds[] = $this->db->insertID();
        }

        // Walis (10 Walis)
        $waliNames = [
            'Ir. Bambang Susanto', 'Dr. Ratna Sari', 'H. Mulyadi, S.E', 'Siti Aminah, M.Pd',
            'Budi Setiawan', 'Ani Wijaya', 'Hendra Kurniawan', 'Dewi Lestari',
            'Agus Saputra', 'Rina Pratama'
        ];
        $waliIds = [];
        foreach ($waliNames as $i => $name) {
            $uname = 'wali' . ($i + 1);
            $this->db->table('users')->insert([
                'username' => $uname,
                'email'    => $uname . '@gmail.com',
                'password' => password_hash('wali123', PASSWORD_DEFAULT),
                'role'     => 'wali',
                'name'     => $name,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $waliIds[] = $this->db->insertID();
        }

        // 3. Create Classes (Linked to Teachers)
        $classNames = [
            'Tahfidz - Al Jazari', 'Ibtidaiyah - Al Khawarizmi', 'Persiapan - Al Battani',
            'Lanjutan - Ibn Sina', 'Khusus - Al Biruni'
        ];
        $classIds = [];
        foreach ($classNames as $i => $name) {
            $this->db->table('classes')->insert([
                'name' => $name,
                'teacher_id' => $teacherIds[$i],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $classIds[] = $this->db->insertID();
        }

        // 4. Create Santris (20 Santris, distributed)
        $santriNames = [
            'Muhammad Fatih Al-Ayubi', 'Annisa Rahmawati', 'Hamzah bin Abdul Muthalib', 'Zaidan Al-Ghifari',
            'Aisyah Humaira', 'Bilal bin Rabah', 'Yusuf Mansur Jr.', 'Maryam Azzahra',
            'Ibrahim Khalil', 'Sarah Sholiha', 'Hasan Al-Banna', 'Husain Al-Mujtaba',
            'Khairunnisa', 'Raihan Ananda', 'Thariq bin Ziyad', 'Khalid bin Walid',
            'Sumayyah binti Khayyat', 'Umar bin Abdul Aziz', 'Abdurrahman bin Auf', 'Usman bin Affan'
        ];
        $santriIds = [];
        foreach ($santriNames as $i => $name) {
            $cId = $classIds[$i % 5];
            $wId = $waliIds[$i % 10];
            $this->db->table('santri')->insert([
                'name' => $name,
                'nisn' => '2024' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'gender' => ($i % 2 == 0) ? 'L' : 'P',
                'class_id' => $cId,
                'wali_id' => $wId,
                'address' => 'Jl. Pendidikan No. ' . ($i + 1),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $santriIds[] = $this->db->insertID();
        }

        // 5. Create Announcements
        $adminId = $this->db->table('users')->where('username', 'admin')->get()->getRow()->id;
        $announcements = [
            [
                'title'       => 'Libur Menyambut Ramadhan 1446 H', 
                'content'     => 'Diberitahukan kepada seluruh wali santri bahwa kegiatan belajar mengajar akan diliburkan mulai tanggal 1 s/d 3 Ramadhan.', 
                'target_role' => 'all',
                'created_by'  => $adminId,
                'created_at'  => date('Y-m-d H:i:s')
            ],
            [
                'title'       => 'Pemeriksaan Kesehatan Rutin', 
                'content'     => 'Akan dilaksanakan pemeriksaan kesehatan gigi dan mulut bagi seluruh santri pada hari Sabtu depan. Harap santri sarapan terlebih dahulu.', 
                'target_role' => 'all',
                'created_by'  => $adminId,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'title'       => 'Laporan Perkembangan Bulanan', 
                'content'     => 'Raport bulanan sudah dapat diakses melalui dashboard wali masing-masing mulai hari ini.', 
                'target_role' => 'wali',
                'created_by'  => $adminId,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'title'       => 'Rapat Koordinasi Pengajar', 
                'content'     => 'Diharapkan kehadirannya untuk seluruh asatidz pada rapat bulanan hari Jumat ini pukul 13.00.', 
                'target_role' => 'guru',
                'created_by'  => $adminId,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-1 days'))
            ],
        ];
        $this->db->table('announcements')->insertBatch($announcements);

        // 6. Create Attendance & Grades for all 20 Santris
        $categories = ['Tahfidz', 'Iqro', 'Adab', 'Doa', 'Fiqih', 'Bahasa Arab'];
        foreach ($santriIds as $sid) {
            // Attendance (Last 7 days)
            for ($d = 0; $d < 7; $d++) {
                $this->db->table('attendance')->insert([
                    'santri_id' => $sid,
                    'academic_year_id' => $ayId,
                    'date' => date('Y-m-d', strtotime("-$d days")),
                    'status' => 'Hadir',
                    'notes' => 'Hadir',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            // Grades
            foreach ($categories as $cat) {
                $score = rand(75, 98);
                $this->db->table('grades')->insert([
                    'santri_id' => $sid,
                    'academic_year_id' => $ayId,
                    'category' => $cat,
                    'score_numeric' => $score,
                    'score_letter' => ($score >= 90 ? 'A' : ($score >= 80 ? 'B' : 'C')),
                    'notes' => 'Sangat baik',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            // Development
            $this->db->table('development')->insert([
                'santri_id' => $sid,
                'academic_year_id' => $ayId,
                'extracurricular' => 'Kaligrafi, Panahan',
                'personality' => 'Sangat sopan dan disiplin.',
                'teacher_notes' => 'Lanjutkan prestasimu!',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
