<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <a href="<?= base_url('wali/raport') ?>" class="text-xs font-bold text-slate-400 hover:text-slate-600 flex items-center space-x-1 uppercase mb-2">
            <i data-lucide="arrow-left" class="w-3 h-3"></i>
            <span>Kembali ke Daftar</span>
        </a>
        <h3 class="text-2xl font-bold text-slate-800">Detail Raport: <?= $child['name'] ?></h3>
        <p class="text-slate-500">Tahun Ajaran: <?= $academic_year['year'] ?? '-' ?> (Semester <?= $academic_year['semester'] ?? '-' ?>)</p>
    </div>
    <button onclick="window.print()" class="bg-white border border-slate-200 text-slate-700 font-bold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-slate-50 transition-all text-sm">
        <i data-lucide="printer" class="w-4 h-4"></i>
        <span>Cetak Raport</span>
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Grades Table -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h4 class="font-bold text-slate-800 uppercase text-xs tracking-widest">Capaian Nilai Perkembangan</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-widest border-b border-slate-50">
                            <th class="px-6 py-4 font-black">Materi / Kategori</th>
                            <th class="px-6 py-4 font-black text-center">Nilai Angka</th>
                            <th class="px-6 py-4 font-black text-center">Huruf</th>
                            <th class="px-6 py-4 font-black">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if (empty($grades)) : ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic text-sm">Belum ada data nilai untuk semester ini.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($grades as $g) : ?>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-700"><?= $g['category'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-2.5 py-1 bg-blue-50 text-blue-700 rounded font-bold text-sm">
                                            <?= number_format($g['score_numeric'], 0) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-600"><?= $g['score_letter'] ?></td>
                                    <td class="px-6 py-4">
                                        <p class="text-xs text-slate-500 italic"><?= $g['notes'] ?: '-' ?></p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Development Notes -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h4 class="font-bold text-slate-800 uppercase text-xs tracking-widest">Catatan Perkembangan & Karakter</h4>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kepribadian & Adab</h5>
                    <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                        <?= $development['personality'] ?? 'Belum ada catatan.' ?>
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Ekstrakurikuler</h5>
                        <p class="text-sm text-slate-700 bg-slate-50 p-4 rounded-lg border border-slate-100">
                            <?= $development['extracurricular'] ?? 'Belum ada catatan.' ?>
                        </p>
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan Wali Kelas</h5>
                        <p class="text-sm text-slate-700 bg-blue-50 p-4 rounded-lg border border-blue-100 italic">
                            "<?= $development['teacher_notes'] ?? 'Belum ada catatan.' ?>"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Attendance & Info -->
    <div class="space-y-8">
        <!-- Attendance Summary -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h4 class="font-bold text-slate-800 uppercase text-xs tracking-widest mb-6">Rekapitulasi Absensi</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                    <span class="text-xs font-bold text-emerald-700 uppercase">Hadir</span>
                    <span class="text-xl font-bold text-slate-800"><?= $attendance['Hadir'] ?></span>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-100 text-center">
                        <p class="text-[9px] font-bold text-blue-600 uppercase mb-1">Sakit</p>
                        <p class="text-lg font-bold text-slate-800"><?= $attendance['Sakit'] ?></p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-lg border border-amber-100 text-center">
                        <p class="text-[9px] font-bold text-amber-600 uppercase mb-1">Izin</p>
                        <p class="text-lg font-bold text-slate-800"><?= $attendance['Izin'] ?></p>
                    </div>
                    <div class="p-3 bg-red-50 rounded-lg border border-red-100 text-center">
                        <p class="text-[9px] font-bold text-red-600 uppercase mb-1">Alpa</p>
                        <p class="text-lg font-bold text-slate-800"><?= $attendance['Alpa'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Info Card -->
        <div class="bg-slate-50 rounded-xl border border-slate-200 p-6">
            <h4 class="font-bold text-slate-800 text-sm mb-4">Informasi Santri</h4>
            <div class="space-y-3">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-400">Nama Lengkap</span>
                    <span class="text-slate-700 font-semibold"><?= $child['name'] ?></span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-slate-400">NISN</span>
                    <span class="text-slate-700 font-mono"><?= $child['nisn'] ?></span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-slate-400">Jenis Kelamin</span>
                    <span class="text-slate-700 font-semibold"><?= $child['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
