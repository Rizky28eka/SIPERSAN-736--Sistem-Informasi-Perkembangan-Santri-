<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="<?= base_url('guru/perkembangan') ?>" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800"><?= esc($class['name']) ?></h1>
            <p class="text-slate-500 text-sm mt-1">Pilih santri untuk melihat atau menambah catatan harian.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Santri</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($santris as $s) : ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800"><?= esc($s['name']) ?></div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">NISN: <?= esc($s['nisn']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="<?= base_url('guru/perkembangan/detail/' . $s['id']) ?>" 
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-blue-100">
                                    Catat Harian
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
