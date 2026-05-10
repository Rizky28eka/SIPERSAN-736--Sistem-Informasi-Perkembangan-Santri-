<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Greeting -->
<div class="mb-6">
    <h3 class="text-xl font-bold text-slate-800">Selamat Datang, <?= esc(session()->get('name')) ?>!</h3>
    <p class="text-slate-500 text-sm mt-1">
        <?php if (!empty($activeYear)) : ?>
            Tahun Ajaran <?= esc($activeYear['year']) ?> &bull; Semester <?= esc($activeYear['semester']) ?>
        <?php endif; ?>
    </p>
</div>

<!-- Data Santri (Anak) -->
<?php if (empty($children)) : ?>
    <div class="bg-amber-50 border border-amber-200 text-amber-700 px-5 py-4 rounded-xl text-sm mb-6">
        <strong>Perhatian:</strong> Belum ada data santri yang terhubung ke akun Anda. Hubungi Admin.
    </div>
<?php else : ?>
    <?php foreach ($children as $child) : ?>
        <?php
        $att   = $child['attendance'] ?? ['Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpa' => 0, 'total' => 0];
        $pct   = $att['total'] > 0 ? round(($att['Hadir'] / $att['total']) * 100) : 0;
        $spp   = $child['spp_status'] ?? null;
        $sppStatus   = $spp['status'] ?? 'belum';
        $sppColors   = ['lunas' => 'green', 'cicilan' => 'yellow', 'nunggak' => 'red', 'belum' => 'slate'];
        $sppLabels   = ['lunas' => 'Lunas', 'cicilan' => 'Cicilan', 'nunggak' => 'Nunggak', 'belum' => 'Belum Bayar'];
        $sppColor    = $sppColors[$sppStatus] ?? 'slate';
        $sppLabel    = $sppLabels[$sppStatus] ?? 'Belum Bayar';
        ?>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6 overflow-hidden">
            <!-- Header Santri -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-5">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white font-bold text-xl">
                        <?= strtoupper(substr($child['name'], 0, 1)) ?>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-lg"><?= esc($child['name']) ?></h4>
                        <div class="flex items-center gap-3 mt-1 text-blue-100 text-sm">
                            <span>NISN: <?= esc($child['nisn']) ?></span>
                            <span>&bull;</span>
                            <span><?= $child['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
                            <span>&bull;</span>
                            <span><?= esc($child['class_name'] ?? '-') ?></span>
                        </div>
                        <?php if (!empty($child['address'])) : ?>
                            <p class="text-blue-100 text-xs mt-1">
                                <i class="inline-block">📍</i> <?= esc($child['address']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-0 border-b border-slate-100">
                <!-- Hadir -->
                <div class="p-4 text-center border-r border-slate-100">
                    <p class="text-2xl font-bold text-green-600"><?= $att['Hadir'] ?></p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Hadir</p>
                </div>
                <!-- Sakit -->
                <div class="p-4 text-center border-r border-slate-100">
                    <p class="text-2xl font-bold text-blue-600"><?= $att['Sakit'] ?></p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Sakit</p>
                </div>
                <!-- Izin -->
                <div class="p-4 text-center border-r border-slate-100">
                    <p class="text-2xl font-bold text-yellow-600"><?= $att['Izin'] ?></p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Izin</p>
                </div>
                <!-- Alfa -->
                <div class="p-4 text-center">
                    <p class="text-2xl font-bold text-red-600"><?= $att['Alpa'] ?></p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Alfa</p>
                </div>
            </div>

            <!-- Progress Kehadiran + SPP Status -->
            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center gap-4 border-b border-slate-100">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-slate-500 font-medium">Persentase Kehadiran</span>
                        <span class="text-xs font-bold <?= $pct >= 75 ? 'text-green-600' : ($pct >= 50 ? 'text-yellow-600' : 'text-red-600') ?>"><?= $pct ?>%</span>
                    </div>
                    <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all <?= $pct >= 75 ? 'bg-green-500' : ($pct >= 50 ? 'bg-yellow-500' : 'bg-red-500') ?>"
                             style="width: <?= $pct ?>%"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1"><?= $att['total'] ?> total pertemuan tercatat</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-xs text-slate-400">Status SPP</p>
                        <span class="inline-block px-3 py-1 bg-<?= $sppColor ?>-100 text-<?= $sppColor ?>-700 rounded-full text-xs font-semibold">
                            <?= $sppLabel ?>
                        </span>
                    </div>
                    <a href="<?= base_url('wali/spp') ?>"
                       class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- Nilai Terbaru -->
            <?php if (!empty($child['latest_grades'])) : ?>
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Nilai Terbaru</p>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                        <?php foreach ($child['latest_grades'] as $g) : ?>
                            <div class="bg-slate-50 rounded-xl p-3 text-center">
                                <p class="text-lg font-bold <?= $g['score_numeric'] >= 85 ? 'text-green-600' : ($g['score_numeric'] >= 70 ? 'text-blue-600' : 'text-red-600') ?>">
                                    <?= $g['score_numeric'] ?>
                                </p>
                                <p class="text-[10px] text-slate-400 leading-tight mt-1"><?= esc($g['category']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex gap-3">
                <a href="<?= base_url('wali/raport/detail/' . $child['id']) ?>"
                   class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                    Lihat Raport
                </a>
                <a href="<?= base_url('wali/spp') ?>"
                   class="flex items-center gap-2 border border-slate-200 text-slate-600 hover:bg-white px-4 py-2 rounded-xl text-sm font-medium transition-all">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    Pembayaran SPP
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Pengumuman Terbaru -->
<?php if (!empty($announcements)) : ?>
    <div class="mt-4">
        <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2">
            <i data-lucide="megaphone" class="w-4 h-4 text-blue-500"></i>
            Pengumuman Terbaru
        </h4>
        <div class="space-y-3">
            <?php foreach ($announcements as $ann) : ?>
                <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
                    <p class="font-semibold text-slate-700 text-sm"><?= esc($ann['title']) ?></p>
                    <p class="text-slate-500 text-xs mt-1 line-clamp-2"><?= esc($ann['content']) ?></p>
                    <p class="text-slate-400 text-[10px] mt-2"><?= date('d M Y', strtotime($ann['created_at'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
