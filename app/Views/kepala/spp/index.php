<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Rekap Pembayaran SPP</h1>
            <p class="text-slate-500">Daftar seluruh tagihan dan status pembayaran santri.</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition-all flex items-center space-x-2">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Santri</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nominal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Terbayar</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($payments)) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">Belum ada data tagihan.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($payments as $p) : ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800"><?= $p['santri_name'] ?></div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider"><?= $p['class_name'] ?> • NISN: <?= $p['nisn'] ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-slate-700"><?= date('F', mktime(0, 0, 0, $p['month'], 10)) ?> <?= $p['year'] ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium <?= ($p['status'] !== 'lunas' && strtotime($p['due_date']) < time()) ? 'text-red-500' : 'text-slate-500' ?>">
                                        <?= date('d M Y', strtotime($p['due_date'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-700">Rp <?= number_format($p['amount'], 0, ',', '.') ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-blue-600">Rp <?= number_format($p['total_paid'], 0, ',', '.') ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <?php if ($p['status'] === 'lunas') : ?>
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Lunas</span>
                                        <?php elseif ($p['status'] === 'nunggak') : ?>
                                            <span class="px-3 py-1 bg-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Nunggak</span>
                                        <?php elseif ($p['status'] === 'cicilan') : ?>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Cicilan</span>
                                        <?php else : ?>
                                            <span class="px-3 py-1 bg-amber-100 text-amber-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Belum Bayar</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
