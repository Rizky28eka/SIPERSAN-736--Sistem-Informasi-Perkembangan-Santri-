<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Absensi Santri</h3>
        <p class="text-sm text-slate-500 mt-1">Pilih kelas untuk melakukan input absensi harian.</p>
    </div>
</div>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($classes)) : ?>
        <div class="col-span-full bg-white rounded-2xl border border-slate-100 p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="door-closed" class="w-8 h-8 text-slate-300"></i>
            </div>
            <h4 class="text-slate-600 font-medium">Anda belum mengampu kelas</h4>
            <p class="text-slate-400 text-sm mt-1">Silakan hubungi Kepala Yayasan untuk penugasan kelas.</p>
        </div>
    <?php else : ?>
        <?php foreach ($classes as $c) : ?>
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all group">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-4 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-lg mb-1"><?= $c['name'] ?></h4>
                <p class="text-slate-400 text-xs mb-6 uppercase tracking-wider font-bold">Wali Kelas: <?= session()->get('name') ?></p>
                
                <div class="flex gap-2 mt-auto">
                    <a href="<?= base_url('guru/absensi/input/' . $c['id']) ?>"
                       class="flex-1 bg-slate-50 hover:bg-blue-600 hover:text-white text-slate-600 font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i>
                        Input
                    </a>
                    <a href="<?= base_url('guru/absensi/rekap/' . $c['id']) ?>"
                       class="flex-1 bg-slate-50 hover:bg-green-600 hover:text-white text-slate-600 font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                        Rekap
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
