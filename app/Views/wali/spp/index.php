<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Pembayaran SPP</h1>
            <p class="text-slate-500">Monitor dan bayar tagihan SPP bulanan anak Anda.</p>
        </div>
        <div>
            <a href="<?= base_url('wali/spp/history') ?>" 
                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold rounded-2xl transition-all flex items-center space-x-2 shadow-sm">
                <i data-lucide="history" class="w-5 h-5 text-blue-500"></i>
                <span>Riwayat Pembayaran</span>
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl flex items-center space-x-3">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="text-sm font-medium"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Santri</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tagihan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Terbayar</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($payments)) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">Belum ada data tagihan.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($payments as $p) : ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800"><?= $p['santri_name'] ?></div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider"><?= $p['class_name'] ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-slate-700"><?= date('F', mktime(0, 0, 0, $p['month'], 10)) ?> <?= $p['year'] ?></div>
                                    <div class="text-[10px] <?= (strtotime($p['due_date']) < time() && $p['status'] !== 'lunas') ? 'text-red-500' : 'text-slate-400' ?> font-medium">Jatuh Tempo: <?= date('d M Y', strtotime($p['due_date'])) ?></div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($p['status'] === 'lunas') : ?>
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-emerald-200">Lunas</span>
                                    <?php elseif ($p['status'] === 'nunggak') : ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-red-200">Nunggak</span>
                                    <?php elseif ($p['status'] === 'cicilan') : ?>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-blue-200">Cicilan</span>
                                    <?php else : ?>
                                        <span class="px-3 py-1 bg-amber-100 text-amber-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-amber-200">Belum Bayar</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-700">Rp <?= number_format($p['amount'], 0, ',', '.') ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-blue-600">Rp <?= number_format($p['total_paid'], 0, ',', '.') ?></div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <?php if ($p['status'] !== 'lunas') : ?>
                                        <button onclick="openPaymentModal(<?= $p['id'] ?>, '<?= $p['santri_name'] ?>', <?= $p['amount'] - $p['total_paid'] ?>)" 
                                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-blue-100">
                                            Bayar
                                        </button>
                                    <?php else : ?>
                                        <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest italic">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl animate-in zoom-in duration-200">
        <div class="p-8 border-b border-slate-50">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-800">Konfirmasi Bayar</h2>
                <button onclick="closePaymentModal()" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 hover:text-slate-600 flex items-center justify-center">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
        <form action="<?= base_url('wali/spp/pay') ?>" method="post" class="p-8 space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="spp_id" id="modal_spp_id">

            <!-- Nama Santri -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Santri</label>
                <input type="text" id="modal_santri_name" readonly
                       class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-slate-600 font-bold focus:ring-0">
            </div>

            <!-- Jumlah Bayar -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Jumlah Pembayaran (Rp)</label>
                <div class="relative">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-xl font-black text-slate-300">Rp</span>
                    <input type="number" name="amount_paid" id="modal_amount_paid" required
                           class="w-full bg-slate-50 border-0 rounded-2xl pl-14 pr-5 py-4 focus:ring-4 focus:ring-blue-500/10 transition-all text-2xl font-black text-blue-600 outline-none"
                           placeholder="0">
                </div>
                <p id="modal_remaining" class="text-[10px] text-slate-400 mt-2 font-medium uppercase tracking-wider"></p>
            </div>

            <!-- Metode Pembayaran -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Metode Pembayaran</label>
                <div class="grid grid-cols-3 gap-3">
                    <?php
                    $methods = [
                        'cash'     => ['icon' => '💵', 'label' => 'Tunai'],
                        'transfer' => ['icon' => '🏦', 'label' => 'Transfer'],
                        'qris'     => ['icon' => '📱', 'label' => 'QRIS'],
                    ];
                    foreach ($methods as $val => $m) :
                    ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="<?= $val ?>"
                                   <?= $val === 'cash' ? 'checked' : '' ?> class="sr-only peer">
                            <div class="flex flex-col items-center gap-1.5 p-3 border-2 border-slate-200 rounded-xl
                                        peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition-all cursor-pointer">
                                <span class="text-2xl"><?= $m['icon'] ?></span>
                                <span class="text-xs font-semibold text-slate-600"><?= $m['label'] ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Catatan -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                    Catatan <span class="font-normal text-slate-300">(opsional: nomor referensi transfer, dll)</span>
                </label>
                <input type="text" name="proof_note" id="modal_proof_note"
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                       placeholder="Contoh: Transfer via BCA No. Ref 123456">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95 duration-150">
                Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>

<script>
    function openPaymentModal(id, name, remaining) {
        document.getElementById('modal_spp_id').value      = id;
        document.getElementById('modal_santri_name').value = name;
        document.getElementById('modal_amount_paid').value = remaining;
        document.getElementById('modal_proof_note').value  = '';
        document.getElementById('modal_remaining').innerText =
            'Sisa Tagihan: Rp ' + Number(remaining).toLocaleString('id-ID');
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    // Tutup modal saat klik di luar
    document.getElementById('paymentModal').addEventListener('click', function(e) {
        if (e.target === this) closePaymentModal();
    });
</script>
<?= $this->endSection() ?>
