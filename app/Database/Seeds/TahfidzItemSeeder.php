<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder data master Tahfidz
 * Isi data awal: Surah-surah pendek, Hadits, dan materi lainnya
 */
class TahfidzItemSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada
        $this->db->table('tahfidz_items')->truncate();

        // Surah-surah Pendek (Juz 30)
        $surahs = [
            'An-Nas', 'Al-Falaq', 'Al-Ikhlas', 'Al-Masad', 'An-Nashr',
            'Al-Kafirun', 'Al-Kautsar', 'Al-Maun', 'Quraisy', 'Al-Fil',
            'Al-Humazah', 'Al-Ashr', 'At-Takatsur', 'Al-Qariah', 'Al-Adiyat',
            'Az-Zalzalah', 'Al-Bayyinah', 'Al-Qadr', 'Al-Alaq', 'At-Tin',
        ];

        foreach ($surahs as $i => $name) {
            $this->db->table('tahfidz_items')->insert([
                'type'       => 'surah',
                'name'       => $name,
                'sort_order' => $i + 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Hadits-hadits Pendek
        $hadiths = [
            'Hadits Niat (Innama al-a\'malu binniyat)',
            'Hadits Kasih Sayang (Arhamurrahiimiin)',
            'Hadits Muslim Bersaudara',
            'Hadits Kebersihan Sebagian Iman',
            'Hadits Senyum Adalah Sedekah',
        ];

        foreach ($hadiths as $i => $name) {
            $this->db->table('tahfidz_items')->insert([
                'type'       => 'hadits',
                'name'       => $name,
                'sort_order' => $i + 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Lainnya
        $others = [
            'Doa Sebelum Makan',
            'Doa Sesudah Makan',
            'Doa Masuk Masjid',
            'Doa Keluar Masjid',
            'Doa Sebelum Belajar',
            'Bacaan Sholat (Al-Fatihah)',
            'Bacaan Tahiyat Akhir',
        ];

        foreach ($others as $i => $name) {
            $this->db->table('tahfidz_items')->insert([
                'type'       => 'lainnya',
                'name'       => $name,
                'sort_order' => $i + 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
