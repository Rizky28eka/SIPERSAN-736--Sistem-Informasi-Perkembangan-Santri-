<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h3 class="text-xl font-bold text-slate-800">Input Hafalan Santri</h3>
    <p class="text-slate-500 text-sm mt-1">Pilih kelas untuk mengisi checklist hafalan santri</p>
</div>

<?php if (empty($classes)) : ?>
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
        <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
        <p class="text-slate-500">Belum ada kelas yang ditugaskan ke Anda.</p>
    </div>
<?php else : ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($classes as $class) : ?>
            <a href="<?= base_url('guru/tahfidz/input/' . $class['id']) ?>"
               class="bg-white rounded-2xl border border-slate-200 p-6 hover:border-blue-300 hover:shadow-md transition-all group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-200 transition-all">
                        <i data-lucide="book-marked" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700"><?= esc($class['name']) ?></p>
                        <p class="text-xs text-slate-400 mt-0.5">Klik untuk input hafalan</p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
