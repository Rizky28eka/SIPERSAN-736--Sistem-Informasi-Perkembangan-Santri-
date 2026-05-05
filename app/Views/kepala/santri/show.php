<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-3">
        <a href="<?= base_url('kepala/santri') ?>" class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-500">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Detail Perkembangan Santri</h3>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('kepala/santri/edit/' . $santri['id']) ?>" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl hover:bg-blue-100 transition-all text-sm font-medium flex items-center space-x-2">
            <i data-lucide="edit-2" class="w-4 h-4"></i>
            <span>Edit Profil</span>
        </a>
        <a href="<?= base_url('kepala/santri/print/' . $santri['id']) ?>" target="_blank" class="bg-slate-800 text-white px-4 py-2 rounded-xl hover:bg-slate-900 transition-all text-sm font-medium flex items-center space-x-2">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Cetak Raport</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Student Profile -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center">
            <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-3xl mx-auto mb-4 border-4 border-white shadow-lg shadow-blue-100">
                <?= substr($santri['name'], 0, 1) ?>
            </div>
            <h4 class="text-lg font-bold text-slate-800"><?= $santri['name'] ?></h4>
            <p class="text-slate-500 text-sm mb-4"><?= $santri['nisn'] ?></p>
            
            <div class="flex justify-center space-x-2 mb-6">
                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-semibold uppercase tracking-wider">
                    <?= $santri['class_name'] ?>
                </span>
                <span class="px-3 py-1 <?= $santri['gender'] == 'L' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' ?> rounded-full text-xs font-semibold uppercase tracking-wider">
                    <?= $santri['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                </span>
            </div>

            <div class="space-y-4 text-left border-t border-slate-50 pt-6">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Wali Santri</label>
                    <p class="text-sm text-slate-700 font-medium"><?= $santri['wali_name'] ?></p>
                    <p class="text-xs text-slate-400"><?= $santri['wali_email'] ?></p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Alamat</label>
                    <p class="text-sm text-slate-600 leading-relaxed"><?= $santri['address'] ?></p>
                </div>
            </div>
        </div>

        <!-- Attendance Stats Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h5 class="text-sm font-bold text-slate-800 mb-4 flex items-center space-x-2">
                <i data-lucide="calendar" class="w-4 h-4 text-blue-600"></i>
                <span>Statistik Kehadiran</span>
            </h5>
            <?php
            $total = count($attendance);
            $present = count(array_filter($attendance, fn($a) => $a['status'] == 'Hadir'));
            $absent = $total - $present;
            $percent = $total > 0 ? round(($present / $total) * 100) : 0;
            ?>
            <div class="relative pt-1">
                <div class="flex mb-2 items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                            Persentase
                        </span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold inline-block text-blue-600">
                            <?= $percent ?>%
                        </span>
                    </div>
                </div>
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-100">
                    <div style="width:<?= $percent ?>%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-1000"></div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-2">
                <div class="bg-emerald-50 rounded-xl p-3 text-center">
                    <span class="text-xs text-emerald-500 font-medium block">Hadir</span>
                    <span class="text-lg font-bold text-emerald-700"><?= $present ?></span>
                </div>
                <div class="bg-red-50 rounded-xl p-3 text-center">
                    <span class="text-xs text-red-500 font-medium block">Izin/Sakit/Alfa</span>
                    <span class="text-lg font-bold text-red-700"><?= $absent ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Academic & Development -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Grades Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                <h5 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                    <i data-lucide="award" class="w-4 h-4 text-amber-500"></i>
                    <span>Capaian Akademik (TA <?= $activeAY['year'] ?? '-' ?>)</span>
                </h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-6 py-3">Mata Pelajaran / Materi</th>
                            <th class="px-6 py-3 text-center">Nilai Angka</th>
                            <th class="px-6 py-3 text-center">Nilai Huruf</th>
                            <th class="px-6 py-3">Catatan Pengajar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($grades)) : ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data nilai semester ini.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($grades as $g) : ?>
                                <tr>
                                    <td class="px-6 py-4 font-medium text-slate-700"><?= $g['category'] ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-bold text-slate-700"><?= $g['score_numeric'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 bg-slate-100 rounded-md font-bold text-slate-600"><?= $g['score_letter'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 text-xs italic"><?= $g['notes'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Development Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h5 class="text-sm font-bold text-slate-800 mb-6 flex items-center space-x-2">
                <i data-lucide="trending-up" class="w-4 h-4 text-emerald-500"></i>
                <span>Catatan Perkembangan & Karakter</span>
            </h5>
            
            <div class="space-y-6">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Kegiatan Ekstrakurikuler</label>
                    <div class="flex flex-wrap gap-2">
                        <?php if ($development && $development['extracurricular']) : ?>
                            <?php foreach (explode(',', $development['extracurricular']) as $ext) : ?>
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium"><?= trim($ext) ?></span>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <span class="text-slate-400 italic text-sm">Belum ada data.</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Kepribadian & Akhlak</label>
                        <p class="text-sm text-slate-600 leading-relaxed italic">
                            <?= $development['personality'] ?? 'Belum ada catatan kepribadian.' ?>
                        </p>
                    </div>
                    <div class="bg-blue-50/50 rounded-2xl p-4">
                        <label class="text-[10px] font-bold text-blue-400 uppercase tracking-widest block mb-2">Rekomendasi Pengajar</label>
                        <p class="text-sm text-slate-700 leading-relaxed font-medium">
                            <?= $development['teacher_notes'] ?? 'Belum ada rekomendasi pengajar.' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
