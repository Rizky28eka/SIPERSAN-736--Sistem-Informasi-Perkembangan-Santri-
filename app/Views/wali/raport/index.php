<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Raport Santri</h3>
    <p class="text-slate-500">Pilih nama ananda untuk melihat laporan perkembangan lengkap.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($children as $child) : ?>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 hover:border-blue-300 transition-all group">
            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                <i data-lucide="user" class="w-8 h-8"></i>
            </div>
            <h4 class="text-xl font-bold text-slate-800 mb-1"><?= $child['name'] ?></h4>
            <p class="text-xs text-slate-500 mb-6 uppercase tracking-widest">NISN: <?= $child['nisn'] ?></p>
            
            <a href="<?= base_url('wali/raport/detail/' . $child['id']) ?>" class="block w-full text-center bg-slate-800 text-white font-bold py-3 rounded-lg hover:bg-slate-900 transition-colors">
                Lihat Detail Raport
            </a>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>
