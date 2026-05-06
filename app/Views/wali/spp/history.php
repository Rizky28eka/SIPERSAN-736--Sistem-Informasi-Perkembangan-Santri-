<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="<?= base_url('wali/spp') ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center space-x-1 mb-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali ke Pembayaran</span>
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Pembayaran</h1>
            <p class="text-slate-500">Daftar lengkap seluruh transaksi pembayaran SPP yang telah dilakukan.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-16 text-center">No</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Santri</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Periode Tagihan</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Waktu Pembayaran</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Jumlah Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($history)) : ?>
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400 italic">
                                <div class="flex flex-col items-center space-y-2">
                                    <i data-lucide="inbox" class="w-10 h-10 opacity-20"></i>
                                    <span>Belum ada riwayat transaksi.</span>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($history as $index => $h) : ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-4 text-center text-sm text-slate-400 font-medium"><?= $index + 1 ?></td>
                                <td class="px-8 py-4">
                                    <div class="font-bold text-slate-800"><?= $h['santri_name'] ?></div>
                                </td>
                                <td class="px-8 py-4">
                                    <div class="text-sm font-semibold text-slate-700">
                                        <?= date('F Y', mktime(0, 0, 0, $h['month'], 10, $h['year'])) ?>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <div class="text-sm text-slate-600 font-medium">
                                        <?= date('d M Y', strtotime($h['payment_date'])) ?>
                                    </div>
                                    <div class="text-[10px] text-slate-400">
                                        <?= date('H:i', strtotime($h['payment_date'])) ?> WIB
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <div class="text-lg font-black text-emerald-600">
                                        Rp <?= number_format($h['amount_paid'], 0, ',', '.') ?>
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
