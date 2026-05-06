<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Master Biaya SPP</h1>
            <p class="text-slate-500">Kelola tarif SPP bulanan untuk setiap kelas.</p>
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
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-16 text-center">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Kelas</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Wali Kelas</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tarif SPP</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($classes)) : ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Belum ada data kelas.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($classes as $index => $class) : ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800"><?= $class['name'] ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-600"><?= $class['teacher_name'] ?? '-' ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-blue-600">Rp <?= number_format($class['spp_price'], 0, ',', '.') ?></div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button onclick="openEditModal(<?= $class['id'] ?>, '<?= $class['name'] ?>', <?= (int)$class['spp_price'] ?>)" 
                                        class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Ubah Tarif">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Price Modal -->
<div id="priceModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl animate-in zoom-in duration-200">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-800">Update Tarif SPP</h2>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <form action="<?= base_url('kepala/master-spp/update') ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="class_id" id="modal_class_id">
            
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kelas</label>
                <input type="text" id="modal_class_name" readonly class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-600 font-medium focus:ring-0">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tarif SPP (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                    <input type="number" name="spp_price" id="modal_spp_price" required 
                        class="w-full border-slate-200 rounded-xl pl-12 pr-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-lg text-blue-600" 
                        placeholder="0">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-blue-100 mt-4">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, price) {
        document.getElementById('modal_class_id').value = id;
        document.getElementById('modal_class_name').value = name;
        document.getElementById('modal_spp_price').value = price;
        document.getElementById('priceModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('priceModal').classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>
