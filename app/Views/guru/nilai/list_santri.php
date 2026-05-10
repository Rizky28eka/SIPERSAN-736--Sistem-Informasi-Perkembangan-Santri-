<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 flex flex-col md:flex-row md:items-end justify-between space-y-4 md:space-y-0">
    <div>
        <a href="<?= base_url('guru/nilai') ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center space-x-1 mb-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Kelas</span>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Daftar Santri: <?= esc($class['name']) ?></h3>
        <p class="text-sm text-slate-500 mt-1">Tahun Ajaran: <?= esc($activeYear['year']) ?> - <?= esc($activeYear['semester']) ?></p>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl mb-6 text-sm flex items-center space-x-2">
        <i data-lucide="check-circle" class="w-4 h-4"></i>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider font-bold">
                    <th class="px-6 py-4 text-center w-16">No</th>
                    <th class="px-6 py-4">Nama Santri</th>
                    <th class="px-6 py-4 text-center">Status Evaluasi</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if (empty($santris)) : ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500 italic text-sm">Belum ada santri di kelas ini.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($santris as $index => $s) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">
                                        <?= strtoupper(substr($s['name'], 0, 1)) ?>
                                    </div>
                                    <span class="font-medium text-slate-700"><?= esc($s['name']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if ($s['is_filled']) : ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i>
                                        Sudah Dievaluasi
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                        Belum Lengkap
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="<?= base_url('guru/nilai/evaluasi/' . $s['id']) ?>" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    Isi Evaluasi
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
