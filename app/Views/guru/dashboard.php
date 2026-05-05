<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Dashboard Pengajar</h3>
    <p class="text-slate-500">Monitor kelas dan input data perkembangan santri.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-5">
        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
            <i data-lucide="users" class="w-7 h-7"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-bold uppercase mb-1">Total Santri Diajar</p>
            <h3 class="text-3xl font-bold text-slate-800"><?= $stats['total_santri'] ?></h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-5">
        <div class="w-14 h-14 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600">
            <i data-lucide="calendar-check" class="w-7 h-7"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-bold uppercase mb-1">Rata-rata Kehadiran</p>
            <h3 class="text-3xl font-bold text-slate-800"><?= $stats['avg_attendance'] ?>%</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h4 class="font-bold text-slate-800">Daftar Santri</h4>
                <div class="flex space-x-2">
                    <a href="<?= base_url('guru/absensi') ?>" class="text-xs font-bold text-blue-600 border border-blue-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition-all uppercase">Absensi</a>
                    <a href="<?= base_url('guru/nilai') ?>" class="text-xs font-bold text-emerald-600 border border-emerald-200 px-3 py-1.5 rounded-lg hover:bg-emerald-50 transition-all uppercase">Nilai</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase tracking-wider border-b border-slate-50">
                            <th class="px-6 py-3 font-semibold">Nama Santri</th>
                            <th class="px-6 py-3 font-semibold">NISN</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if (empty($santri)) : ?>
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-400 italic text-sm">Belum ada data santri.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($santri as $s) : ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-700"><?= $s['name'] ?></td>
                                    <td class="px-6 py-4 text-slate-500 font-mono text-sm"><?= $s['nisn'] ?></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="<?= base_url('guru/nilai/input/' . $s['id']) ?>" class="text-emerald-600 hover:text-emerald-700" title="Input Nilai">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>
                                            <a href="<?= base_url('guru/absensi/input/' . $s['id']) ?>" class="text-blue-600 hover:text-blue-700" title="Input Absensi">
                                                <i data-lucide="check-square" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h4 class="font-bold text-slate-800 mb-6">Pengumuman Terbaru</h4>
            <div class="space-y-4">
                <?php if (empty($announcements)) : ?>
                    <p class="text-sm text-slate-400 italic text-center py-4">Tidak ada pengumuman baru.</p>
                <?php else : ?>
                    <?php foreach ($announcements as $anc) : ?>
                        <div class="p-4 border-l-4 border-blue-500 bg-slate-50 rounded-r-lg">
                            <p class="text-[10px] font-bold text-slate-400 uppercase"><?= date('d M Y', strtotime($anc['created_at'])) ?></p>
                            <h5 class="text-sm font-bold text-slate-700 mt-1"><?= $anc['title'] ?></h5>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2"><?= $anc['content'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
