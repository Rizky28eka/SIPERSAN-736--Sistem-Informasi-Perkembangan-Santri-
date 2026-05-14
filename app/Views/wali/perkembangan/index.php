<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Catatan Perkembangan Harian</h1>
        <p class="text-slate-500">Pantau perkembangan ananda setiap hari melalui catatan dari guru.</p>
    </div>

    <?php if (empty($history)) : ?>
        <div class="bg-white p-20 rounded-3xl border border-dashed border-slate-200 text-center">
            <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="calendar-x-2" class="w-10 h-10"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Belum Ada Catatan</h3>
            <p class="text-slate-500 mt-2">Guru belum menginput catatan harian untuk ananda.</p>
        </div>
    <?php else : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($history as $h) : ?>
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center font-black text-xl">
                                <?= substr($h['santri_name'], 0, 1) ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800"><?= esc($h['santri_name']) ?></h4>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider"><?= date('d F Y', strtotime($h['date'])) ?></p>
                            </div>
                        </div>
                        <?php if ($h['status'] === 'need_attention') : ?>
                            <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-red-100">Perhatian</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="bg-slate-50/50 rounded-2xl p-5">
                        <div class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-2"><?= esc($h['subject']) ?></div>
                        <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap"><?= esc($h['note']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
