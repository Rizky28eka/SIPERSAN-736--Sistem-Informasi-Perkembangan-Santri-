<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Catatan Perkembangan Santri</h3>
        <p class="text-slate-500 text-sm mt-1">Isi catatan kepribadian, ekskul, dan catatan wali kelas</p>
    </div>
</div>

<?php if (empty($santris)) : ?>
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
        <i data-lucide="users" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
        <p class="text-slate-500">Belum ada santri di kelas Anda.</p>
    </div>
<?php else : ?>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600">Santri</th>
                    <th class="text-left px-6 py-4 font-semibold text-slate-600">Kelas</th>
                    <th class="text-left px-6 py-4 font-semibold text-slate-600">Status Catatan</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($santris as $s) : ?>
                    <?php $hasDev = !empty($s['development']); ?>
                    <tr class="hover:bg-slate-50 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                    <?= strtoupper(substr($s['name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700"><?= esc($s['name']) ?></p>
                                    <p class="text-xs text-slate-400">NISN: <?= esc($s['nisn']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600"><?= esc($s['class_name']) ?></td>
                        <td class="px-6 py-4">
                            <?php if ($hasDev) : ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                                    Sudah diisi
                                </span>
                            <?php else : ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    Belum diisi
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?= base_url('guru/perkembangan/form/' . $s['id']) ?>"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition-all">
                                <i data-lucide="<?= $hasDev ? 'pencil' : 'plus' ?>" class="w-3.5 h-3.5"></i>
                                <?= $hasDev ? 'Edit' : 'Isi Catatan' ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
