<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Rekap Pembayaran SPP</h1>
            <p class="text-slate-500">Daftar seluruh tagihan dan status pembayaran santri.</p>
        </div>
        <div class="flex items-center space-x-3">
            <form action="<?= base_url('kepala/spp') ?>" method="get" class="flex items-center" id="searchForm">
                <div class="relative">
                    <input type="text" name="keyword" id="searchInput" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama/NISN/kelas..." 
                        class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none w-48 sm:w-64 transition-all">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                </div>
                <?php if (!empty($keyword)): ?>
                    <a href="<?= base_url('kepala/spp') ?>" class="ml-2 p-2 text-slate-400 hover:text-red-500 transition-all" title="Bersihkan Pencarian">
                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                    </a>
                <?php endif; ?>
            </form>
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition-all flex items-center space-x-2">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak Rekap</span>
            </button>
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
            <table class="w-full text-left border-collapse" id="sppTable">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Santri</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nominal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="sppBody">
                    <?php if (empty($payments)) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">Data tidak ditemukan.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($payments as $p) : ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800"><?= $p['santri_name'] ?></div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider"><?= $p['class_name'] ?> • NISN: <?= $p['nisn'] ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-700">
                                    <?= date('F', mktime(0, 0, 0, $p['month'], 10)) ?> <?= $p['year'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium <?= ($p['status'] !== 'lunas' && strtotime($p['due_date']) < time()) ? 'text-red-500' : 'text-slate-500' ?>">
                                        <?= date('d M Y', strtotime($p['due_date'])) ?>
                                    </div>
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
                                    <div class="text-xs font-bold text-slate-700">Tagihan: Rp <?= number_format($p['amount'], 0, ',', '.') ?></div>
                                    <div class="text-xs font-bold text-blue-600">Bayar: Rp <?= number_format($p['total_paid'], 0, ',', '.') ?></div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <?php if ($p['status'] !== 'lunas') : ?>
                                        <button onclick="openCashModal(<?= $p['id'] ?>, '<?= $p['santri_name'] ?>', <?= $p['amount'] - $p['total_paid'] ?>)" 
                                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-emerald-100">
                                            Terima Tunai
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

<!-- Cash Payment Modal -->
<div id="cashModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl animate-in zoom-in duration-200">
        <div class="p-8 border-b border-slate-50 text-center">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="banknote" class="w-8 h-8"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Terima Bayar Tunai</h2>
            <p class="text-slate-500 text-sm">Input jumlah uang tunai yang diterima.</p>
        </div>
        <form action="<?= base_url('kepala/spp/pay-cash') ?>" method="post" class="p-8 space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="spp_id" id="modal_spp_id">
            
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Santri</label>
                <input type="text" id="modal_santri_name" readonly class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-slate-600 font-bold focus:ring-0">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Jumlah Diterima (Rp)</label>
                <div class="relative">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-xl font-black text-slate-300">Rp</span>
                    <input type="number" name="amount_paid" id="modal_amount_paid" required
                           class="w-full bg-slate-50 border-0 rounded-2xl pl-14 pr-5 py-4 focus:ring-4 focus:ring-emerald-500/10 transition-all text-2xl font-black text-emerald-600 outline-none"
                           placeholder="0">
                </div>
                <p id="modal_remaining" class="text-[10px] text-slate-400 mt-2 font-medium uppercase tracking-wider"></p>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeCashModal()" class="flex-1 px-6 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" class="flex-[2] bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl transition-all shadow-xl shadow-emerald-500/20 active:scale-95 duration-150">Simpan Pembayaran</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCashModal(id, name, remaining) {
        document.getElementById('modal_spp_id').value      = id;
        document.getElementById('modal_santri_name').value = name;
        document.getElementById('modal_amount_paid').value = remaining;
        document.getElementById('modal_remaining').innerText = 'Sisa Tagihan: Rp ' + Number(remaining).toLocaleString('id-ID');
        document.getElementById('cashModal').classList.remove('hidden');
    }

    function closeCashModal() {
        document.getElementById('cashModal').classList.add('hidden');
    }

    document.getElementById('cashModal').addEventListener('click', function(e) {
        if (e.target === this) closeCashModal();
    });

    // Live Search Script
    document.getElementById('searchInput').addEventListener('input', function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('#sppBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.id === 'emptySearchRow') return;
            const text = row.innerText.toLowerCase();
            if (text.includes(keyword)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        let emptyRow = document.getElementById('emptySearchRow');
        if (visibleCount === 0) {
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.id = 'emptySearchRow';
                emptyRow.innerHTML = `<td colspan="6" class="px-6 py-10 text-center text-slate-500 italic text-sm">Tidak ada data yang cocok dengan pencarian "${this.value}".</td>`;
                document.getElementById('sppBody').appendChild(emptyRow);
            }
        } else if (emptyRow) {
            emptyRow.remove();
        }
    });

    document.getElementById('searchForm').addEventListener('submit', function(e) {
        const emptyRow = document.getElementById('emptySearchRow');
        if (emptyRow) emptyRow.remove();
    });
</script>
</div>
<?= $this->endSection() ?>
