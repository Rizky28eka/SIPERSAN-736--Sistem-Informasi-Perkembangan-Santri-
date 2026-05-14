<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Catatan Perkembangan Harian</h1>
        <p class="text-slate-500">Pilih kelas untuk mulai mencatat perkembangan santri hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($classes as $c) : ?>
            <a href="<?= base_url('guru/perkembangan/list/' . $c['id']) ?>" 
               class="group bg-white p-6 rounded-3xl border border-slate-200 hover:border-blue-500 hover:shadow-xl hover:shadow-blue-500/10 transition-all">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i data-lucide="door-open" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800"><?= esc($c['name']) ?></h3>
                <p class="text-slate-500 text-sm mt-1">Mulai input catatan harian →</p>
            </a>
        <?php endforeach; ?>

        <?php if (empty($classes)) : ?>
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-300">
                <i data-lucide="info" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                <p class="text-slate-400 font-medium">Anda belum ditugaskan ke kelas manapun.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
