<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <a href="<?= base_url('wali/raport') ?>"
           class="text-xs font-bold text-slate-400 hover:text-slate-600 flex items-center gap-1 uppercase mb-2">
            <i data-lucide="arrow-left" class="w-3 h-3"></i> Kembali
        </a>
        <h3 class="text-xl font-bold text-slate-800">Raport: <?= esc($child['name']) ?></h3>
        <p class="text-slate-500 text-sm">Tahun Pelajaran <?= esc($academic_year['year'] ?? '-') ?> &bull; Semester <?= esc($academic_year['semester'] ?? '-') ?></p>
    </div>
    <button onclick="window.print()"
            class="flex items-center gap-2 border border-slate-200 text-slate-600 hover:bg-slate-50 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
        <i data-lucide="printer" class="w-4 h-4"></i> Cetak Raport
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- ══ KOLOM KIRI: Nilai + Perkembangan ════════════════════════════════ -->
    <div class="lg:col-span-2 space-y-6">

        <!-- HASIL EVALUASI BELAJAR (sesuai format rapor asli) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-blue-50 flex items-center gap-3">
                <i data-lucide="book-open" class="w-5 h-5 text-blue-600"></i>
                <h4 class="font-bold text-blue-800 uppercase text-xs tracking-widest">Hasil Evaluasi Belajar &mdash; Ragam Prestasi</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                            <th class="px-5 py-3 text-center w-10">No</th>
                            <th class="px-5 py-3 text-left">Ragam Prestasi</th>
                            <th class="px-5 py-3 text-center w-24">Angka</th>
                            <th class="px-5 py-3 text-center w-20">Huruf</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php
                        $labels = [
                            'a' => "Iqro'/Tartam Al-Qur'an",
                            'b' => 'Ilmu Tajwid *)',
                            'c' => 'Praktek Tajwid',
                            'd' => 'Bacaan Islam *)',
                            'e' => 'Hafalan Bacaan Sholat',
                            'f' => 'Hafalan Doa Sehari-hari',
                            'g' => 'Hafalan Surat-Surat Pendek',
                            'h' => 'Hafalan Ayat-Ayat Pilihan',
                            'i' => 'Menulis/Tahsinul Kitabah',
                            'j' => 'Praktek Sholat',
                        ];
                        // Muatan Lokal
                        $muatanLokal = [
                            'a' => 'Hafalan Hadits/Mahfuzhat',
                            'b' => 'Bahasa Arab',
                            'c' => 'Bahasa Inggris',
                        ];

                        // Build lookup dari grades
                        $gradeByCategory = [];
                        foreach ($grades ?? [] as $g) {
                            $gradeByCategory[$g['category']] = $g;
                        }

                        $allCategories = array_merge(
                            array_values($labels),
                            array_values($muatanLokal)
                        );

                        $totalAngka = 0;
                        $countAngka = 0;

                        $idx = 1;
                        foreach ($labels as $alpha => $label) :
                            $g = $gradeByCategory[$label] ?? null;
                            $score = $g['score_numeric'] ?? null;
                            if ($score !== null) { $totalAngka += $score; $countAngka++; }
                        ?>
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 text-center text-slate-400 font-medium"><?= strtolower($alpha) ?></td>
                                <td class="px-5 py-3 text-slate-700"><?= esc($label) ?></td>
                                <td class="px-5 py-3 text-center">
                                    <?php if ($score !== null) : ?>
                                        <span class="inline-block px-3 py-1 rounded-lg font-bold text-sm
                                            <?= $score >= 80 ? 'bg-green-100 text-green-700' : ($score >= 65 ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-600') ?>">
                                            <?= $score ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="text-slate-300 text-xs">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3 text-center font-bold text-slate-600"><?= esc($g['score_letter'] ?? '—') ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Muatan Lokal Section -->
                        <tr class="bg-slate-100">
                            <td colspan="4" class="px-5 py-2 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                11. Muatan Lokal
                            </td>
                        </tr>
                        <?php foreach ($muatanLokal as $alpha => $label) :
                            $g     = $gradeByCategory[$label] ?? null;
                            $score = $g['score_numeric'] ?? null;
                            if ($score !== null) { $totalAngka += $score; $countAngka++; }
                        ?>
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 text-center text-slate-400 pl-8"><?= strtolower($alpha) ?></td>
                                <td class="px-5 py-3 text-slate-700 pl-8"><?= esc($label) ?></td>
                                <td class="px-5 py-3 text-center">
                                    <?php if ($score !== null) : ?>
                                        <span class="inline-block px-3 py-1 rounded-lg font-bold text-sm
                                            <?= $score >= 80 ? 'bg-green-100 text-green-700' : ($score >= 65 ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-600') ?>">
                                            <?= $score ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="text-slate-300 text-xs">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3 text-center font-bold text-slate-600"><?= esc($g['score_letter'] ?? '—') ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Total & Rata-rata -->
                        <tr class="bg-slate-50 border-t-2 border-slate-200">
                            <td colspan="2" class="px-5 py-3 font-bold text-slate-700">Jumlah Nilai</td>
                            <td class="px-5 py-3 text-center font-bold text-blue-700 text-lg"><?= $totalAngka ?></td>
                            <td></td>
                        </tr>
                        <tr class="bg-slate-50">
                            <td colspan="2" class="px-5 py-3 font-bold text-slate-700">Nilai Rata-rata</td>
                            <td class="px-5 py-3 text-center font-bold text-blue-700 text-lg">
                                <?= $countAngka > 0 ? number_format($totalAngka / $countAngka, 1) : '—' ?>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PERKEMBANGAN INDIVIDU SANTRI -->
        <?php if ($development) : ?>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-green-50 flex items-center gap-3">
                <i data-lucide="user-check" class="w-5 h-5 text-green-600"></i>
                <h4 class="font-bold text-green-800 uppercase text-xs tracking-widest">Perkembangan Individu Santri</h4>
            </div>
            <div class="p-6 space-y-6">

                <!-- Kegiatan Ekstra Kurikulum -->
                <?php if (!empty($development['ekskul_1']) || !empty($development['ekskul_2']) || !empty($development['ekskul_3'])) : ?>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kegiatan Ekstra Kurikulum</p>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 text-xs text-slate-500">
                                    <th class="px-4 py-2 text-left">Kegiatan</th>
                                    <th class="px-4 py-2 text-center w-24">Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php for ($i = 1; $i <= 3; $i++) :
                                    $kegiatan = $development["ekskul_{$i}"] ?? '';
                                    $nilai    = $development["ekskul_{$i}_nilai"] ?? '';
                                    if (empty($kegiatan)) continue;
                                    $nilaiColor = ['B' => 'text-green-700 bg-green-100', 'C' => 'text-amber-700 bg-amber-100', 'K' => 'text-red-700 bg-red-100'];
                                ?>
                                    <tr>
                                        <td class="px-4 py-2.5 font-medium text-slate-700"><?= esc($kegiatan) ?></td>
                                        <td class="px-4 py-2.5 text-center">
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold <?= $nilaiColor[$nilai] ?? 'text-slate-500 bg-slate-100' ?>">
                                                <?= $nilai ?: '—' ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Kepribadian -->
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kepribadian</p>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 text-xs text-slate-500">
                                    <th class="px-4 py-2 text-left">Aspek</th>
                                    <th class="px-4 py-2 text-center w-20">B</th>
                                    <th class="px-4 py-2 text-center w-20">C</th>
                                    <th class="px-4 py-2 text-center w-20">K</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php
                                $kepItems = [
                                    'disiplin'           => 'Kedisiplinan',
                                    'jujur'              => 'Kejujuran',
                                    'kerja_sama'         => 'Kerjasama',
                                    'rajin'              => 'Kerajinan',
                                    'kemampuan_berfikir' => 'Kemampuan Berfikir/Akal',
                                ];
                                foreach ($kepItems as $field => $label) :
                                    $val = $development[$field] ?? null;
                                ?>
                                    <tr>
                                        <td class="px-4 py-2.5 text-slate-700"><?= $label ?></td>
                                        <?php foreach (['B', 'C', 'K'] as $opt) : ?>
                                            <td class="px-4 py-2.5 text-center">
                                                <?php if ($val === $opt) : ?>
                                                    <span class="inline-block w-5 h-5 rounded-full
                                                        <?= $opt === 'B' ? 'bg-green-500' : ($opt === 'C' ? 'bg-amber-400' : 'bg-red-500') ?>
                                                        mx-auto"></span>
                                                <?php else : ?>
                                                    <span class="inline-block w-5 h-5 rounded-full border-2 border-slate-200 mx-auto"></span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-slate-50 border-t border-slate-200 text-xs">
                                    <td class="px-4 py-2 text-slate-400">Keterangan:</td>
                                    <td class="px-4 py-2 text-center text-green-700 font-bold">Baik</td>
                                    <td class="px-4 py-2 text-center text-amber-600 font-bold">Cukup</td>
                                    <td class="px-4 py-2 text-center text-red-600 font-bold">Kurang</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Catatan Wali Kelas -->
                <?php if (!empty($development['teacher_notes'])) : ?>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Untuk Orang Tua / Wali</p>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-5 py-4 text-sm text-slate-700 italic leading-relaxed">
                        "<?= esc($development['teacher_notes']) ?>"
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- ══ KOLOM KANAN: Absensi + Info Santri ════════════════════════════== -->
    <div class="space-y-6">

        <!-- Ketidakhadiran (dari development) -->
        <?php if ($development) : ?>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h4 class="font-bold text-slate-700 text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="calendar-x" class="w-4 h-4 text-red-500"></i>
                Ketidakhadiran
            </h4>
            <div class="space-y-2">
                <?php
                $absenItems = [
                    ['label' => 'Sakit',             'value' => $development['sakit_hari'] ?? 0,            'color' => 'blue'],
                    ['label' => 'Izin',              'value' => $development['izin_hari'] ?? 0,             'color' => 'amber'],
                    ['label' => 'Tanpa Keterangan',  'value' => $development['tanpa_keterangan_hari'] ?? 0, 'color' => 'red'],
                ];
                foreach ($absenItems as $item) :
                ?>
                    <div class="flex items-center justify-between p-3 bg-<?= $item['color'] ?>-50 rounded-xl border border-<?= $item['color'] ?>-100">
                        <span class="text-xs font-semibold text-<?= $item['color'] ?>-700"><?= $item['label'] ?></span>
                        <span class="text-lg font-bold text-slate-800"><?= $item['value'] ?> <span class="text-xs text-slate-400">hari</span></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Rekapitulasi Absensi (dari data absensi harian) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h4 class="font-bold text-slate-700 text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="clipboard-list" class="w-4 h-4 text-blue-500"></i>
                Rekap Absensi Harian
            </h4>
            <div class="grid grid-cols-2 gap-2">
                <?php
                $attItems = [
                    ['label' => 'Hadir', 'value' => $attendance['Hadir'] ?? 0, 'color' => 'green'],
                    ['label' => 'Sakit', 'value' => $attendance['Sakit'] ?? 0, 'color' => 'blue'],
                    ['label' => 'Izin',  'value' => $attendance['Izin'] ?? 0,  'color' => 'amber'],
                    ['label' => 'Alpa',  'value' => $attendance['Alpa'] ?? 0,  'color' => 'red'],
                ];
                foreach ($attItems as $a) : ?>
                    <div class="p-3 bg-<?= $a['color'] ?>-50 rounded-xl border border-<?= $a['color'] ?>-100 text-center">
                        <p class="text-xl font-bold text-slate-800"><?= $a['value'] ?></p>
                        <p class="text-[10px] font-bold text-<?= $a['color'] ?>-600 uppercase"><?= $a['label'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Data Santri -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h4 class="font-bold text-slate-700 text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="id-card" class="w-4 h-4 text-slate-500"></i>
                Data Santri
            </h4>
            <div class="space-y-2.5 text-sm">
                <?php
                $infoItems = [
                    ['label' => 'Nama Lengkap',    'value' => $child['name']],
                    ['label' => 'Nama Panggilan',  'value' => $child['nickname'] ?? '-'],
                    ['label' => 'NIS',             'value' => $child['nisn'] ?? '-'],
                    ['label' => 'Jenis Kelamin',   'value' => $child['gender'] === 'L' ? 'Laki-laki' : 'Perempuan'],
                    ['label' => 'Tempat Lahir',    'value' => $child['birth_place'] ?? '-'],
                    ['label' => 'Tanggal Lahir',   'value' => !empty($child['birth_date']) ? date('d M Y', strtotime($child['birth_date'])) : '-'],
                    ['label' => 'Agama',           'value' => $child['agama'] ?? 'Islam'],
                    ['label' => 'Kelas',           'value' => $child['class_name'] ?? '-'],
                ];
                foreach ($infoItems as $info) :
                ?>
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-slate-400 text-xs flex-shrink-0 w-28"><?= $info['label'] ?></span>
                        <span class="text-slate-700 font-medium text-xs text-right"><?= esc($info['value']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
