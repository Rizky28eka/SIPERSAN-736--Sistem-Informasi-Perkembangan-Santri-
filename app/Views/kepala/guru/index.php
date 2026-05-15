<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Daftar Guru</h3>
        <p class="text-sm text-slate-400 mt-1">Total <?= count($gurus) ?> guru terdaftar</p>
    </div>
    <div class="flex items-center gap-3">
        <!-- Search Form -->
        <form action="<?= base_url('kepala/guru') ?>" method="get" class="flex items-center" id="searchForm">
            <div class="relative">
                <input type="text" name="keyword" id="searchInput" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama/username..." 
                    class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none w-48 sm:w-64 transition-all">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
            </div>
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('kepala/guru') ?>" class="ml-2 p-2 text-slate-400 hover:text-red-500 transition-all" title="Bersihkan Pencarian">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                </a>
            <?php endif; ?>
        </form>
        <a href="<?= base_url('kepala/guru/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition-all flex items-center gap-2 text-sm font-medium">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span class="hidden md:inline">Tambah Guru</span>
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 border border-emerald-100 flex items-center space-x-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <p class="text-sm font-medium"><?= session()->getFlashdata('success') ?></p>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left" id="guruTable">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                    <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                    <th class="px-6 py-4 font-semibold">Username</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="guruBody">
                <?php if (empty($gurus)) : ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500 italic text-sm">Belum ada data guru.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($gurus as $index => $guru) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">
                                        <?= substr($guru['name'], 0, 1) ?>
                                    </div>
                                    <span class="font-medium text-slate-700"><?= $guru['name'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600"><?= $guru['username'] ?></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="<?= base_url('kepala/guru/detail/' . $guru['id']) ?>" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Detail">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="<?= base_url('kepala/guru/edit/' . $guru['id']) ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                                    </a>
                                    <form action="<?= base_url('kepala/guru/delete/' . $guru['id']) ?>" method="post" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('#guruBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(keyword)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const countText = document.querySelector('p.text-sm.text-slate-400');
        if (countText) {
            countText.innerText = 'Menampilkan ' + visibleCount + ' guru';
        }
        
        let emptyRow = document.getElementById('emptySearchRow');
        if (visibleCount === 0) {
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.id = 'emptySearchRow';
                emptyRow.innerHTML = `<td colspan="4" class="px-6 py-10 text-center text-slate-500 italic text-sm">Tidak ada guru yang cocok dengan pencarian "${this.value}".</td>`;
                document.getElementById('guruBody').appendChild(emptyRow);
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
<?= $this->endSection() ?>
