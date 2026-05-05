<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Dashboard Wali Santri</h3>
    <p class="text-slate-500">Pantau perkembangan akademik dan kehadiran ananda.</p>
</div>

<?php if (empty($children)) : ?>
    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center shadow-sm">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400">
            <i data-lucide="user-x" class="w-8 h-8"></i>
        </div>
        <h4 class="text-xl font-bold text-slate-700">Data Belum Terhubung</h4>
        <p class="text-slate-500 mt-2 max-w-sm mx-auto">Akun Anda belum terhubung dengan data santri manapun. Silakan hubungi operator sekolah.</p>
    </div>
<?php else : ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <?php foreach ($children as $child) : ?>
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                                <?= substr($child['name'], 0, 1) ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800"><?= $child['name'] ?></h4>
                                <p class="text-xs text-slate-500">Kelas: <?= $child['class_name'] ?? '-' ?> | NISN: <?= $child['nisn'] ?></p>
                            </div>
                        </div>
                        <a href="<?= base_url('wali/raport') ?>" class="text-xs font-bold text-blue-600 hover:underline flex items-center space-x-1 uppercase">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>Detail Raport</span>
                        </a>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Statistik Kehadiran</h5>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 bg-emerald-50 p-4 rounded-lg border border-emerald-100">
                                        <p class="text-[10px] text-emerald-600 font-bold uppercase">Hadir</p>
                                        <p class="text-2xl font-bold text-slate-800"><?= $child['total_present'] ?></p>
                                    </div>
                                    <div class="flex-1 bg-red-50 p-4 rounded-lg border border-red-100">
                                        <p class="text-[10px] text-red-600 font-bold uppercase">Alpa</p>
                                        <p class="text-2xl font-bold text-slate-800"><?= $child['total_absent'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Update Nilai Terbaru</h5>
                                <div class="space-y-2">
                                    <?php if (empty($child['latest_grades'])) : ?>
                                        <p class="text-sm text-slate-400 italic">Belum ada data nilai.</p>
                                    <?php else : ?>
                                        <?php foreach ($child['latest_grades'] as $g) : ?>
                                            <div class="flex justify-between items-center p-2.5 bg-slate-50 rounded border border-slate-100">
                                                <span class="text-xs font-bold text-slate-600"><?= $g['category'] ?></span>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-sm font-bold text-blue-600"><?= $g['score_numeric'] ?></span>
                                                    <span class="text-[10px] font-bold text-slate-400">(<?= $g['score_letter'] ?>)</span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h4 class="font-bold text-slate-800 mb-6">Pengumuman</h4>
                <div class="space-y-4">
                    <?php if (empty($announcements)) : ?>
                        <p class="text-sm text-slate-400 italic text-center py-4">Tidak ada pengumuman.</p>
                    <?php else : ?>
                        <?php foreach ($announcements as $anc) : ?>
                            <div class="pb-4 border-b border-slate-50 last:border-0 last:pb-0">
                                <p class="text-[10px] font-bold text-blue-500 uppercase"><?= date('d M Y', strtotime($anc['created_at'])) ?></p>
                                <h5 class="text-sm font-bold text-slate-700 mt-1"><?= $anc['title'] ?></h5>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2"><?= $anc['content'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="bg-slate-800 rounded-xl p-6 text-white shadow-lg">
                <h5 class="font-bold mb-2">Bantuan Teknis</h5>
                <p class="text-slate-400 text-xs leading-relaxed mb-4">Mengalami kendala pada akun atau data? Hubungi tim IT sekolah di jam kerja.</p>
                <a href="#" class="inline-block bg-white text-slate-800 text-xs font-bold py-2 px-4 rounded hover:bg-slate-100 transition-colors uppercase">Hubungi Kami</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
