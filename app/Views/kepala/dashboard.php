<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Ringkasan Data Yayasan</h3>
    <p class="text-slate-500">Monitor perkembangan santri dan performa guru secara real-time.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Cards -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
            <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-bold uppercase mb-1">Total Santri</p>
            <h3 class="text-2xl font-bold text-slate-800"><?= $stats['total_santri'] ?></h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600">
            <i data-lucide="user-check" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-bold uppercase mb-1">Total Guru</p>
            <h3 class="text-2xl font-bold text-slate-800"><?= $stats['total_guru'] ?></h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600">
            <i data-lucide="calendar" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-bold uppercase mb-1">Absensi Hari Ini</p>
            <h3 class="text-2xl font-bold text-slate-800"><?= $stats['avg_attendance'] ?>%</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
            <i data-lucide="layers" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-bold uppercase mb-1">Total Kelas</p>
            <h3 class="text-2xl font-bold text-slate-800"><?= $stats['total_class'] ?></h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h4 class="font-bold text-slate-800">Aktivitas Terakhir</h4>
                <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-400 cursor-pointer"></i>
            </div>
            <div class="space-y-4">
                <div class="flex items-start space-x-3 p-3 hover:bg-slate-50 rounded-lg transition-colors border-b border-slate-50 last:border-0">
                    <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center mt-0.5">
                        <i data-lucide="bell" class="w-4 h-4 text-slate-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Belum ada aktivitas yang tercatat untuk hari ini.</p>
                        <p class="text-[10px] text-slate-400 mt-1 uppercase"><?= date('H:i') ?> WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h4 class="font-bold text-slate-800 mb-6">Pengumuman Terbaru</h4>
            <div class="space-y-4">
                <?php if (empty($announcements)) : ?>
                    <p class="text-sm text-slate-400 italic">Tidak ada pengumuman.</p>
                <?php else : ?>
                    <?php foreach ($announcements as $anc) : ?>
                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <p class="text-[10px] font-bold text-blue-600 uppercase mb-1"><?= date('d M Y', strtotime($anc['created_at'])) ?></p>
                            <h5 class="text-sm font-bold text-slate-700"><?= $anc['title'] ?></h5>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2"><?= $anc['content'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <a href="<?= base_url('announcements') ?>" class="block text-center mt-6 text-xs font-bold text-blue-600 hover:underline uppercase">Lihat Semua</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
