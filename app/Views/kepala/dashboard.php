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
                <i data-lucide="activity" class="w-5 h-5 text-blue-500"></i>
            </div>
            <div class="space-y-4">
                <?php if (empty($recent_activities)) : ?>
                    <div class="flex items-start space-x-3 p-3 border-b border-slate-50 last:border-0">
                        <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center mt-0.5">
                            <i data-lucide="bell" class="w-4 h-4 text-slate-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Belum ada aktivitas yang tercatat.</p>
                        </div>
                    </div>
                <?php else : ?>
                    <?php foreach ($recent_activities as $log) : ?>
                        <div class="flex items-start space-x-4 p-3 hover:bg-slate-50/50 rounded-xl transition-all border-b border-slate-50 last:border-0">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex-shrink-0 flex items-center justify-center text-slate-500 font-bold text-xs">
                                <?php 
                                    $icon = 'info';
                                    $color = 'text-blue-500';
                                    if (strpos($log['activity'], 'Tambah') !== false) { $icon = 'plus-circle'; $color = 'text-emerald-500'; }
                                    if (strpos($log['activity'], 'Hapus') !== false) { $icon = 'trash-2'; $color = 'text-red-500'; }
                                    if (strpos($log['activity'], 'Update') !== false) { $icon = 'edit-3'; $color = 'text-amber-500'; }
                                    if (strpos($log['activity'], 'Bayar') !== false) { $icon = 'credit-card'; $color = 'text-indigo-500'; }
                                ?>
                                <i data-lucide="<?= $icon ?>" class="w-5 h-5 <?= $color ?>"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold text-slate-800 truncate"><?= $log['activity'] ?></p>
                                    <span class="text-[10px] text-slate-400 font-medium"><?= date('H:i', strtotime($log['created_at'])) ?> WIB</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5"><?= $log['description'] ?></p>
                                <div class="flex items-center mt-2 space-x-2">
                                    <span class="text-[9px] font-black uppercase tracking-tighter px-1.5 py-0.5 bg-slate-100 text-slate-400 rounded"><?= $log['user_role'] ?></span>
                                    <span class="text-[10px] font-bold text-slate-400">by <?= $log['user_name'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
