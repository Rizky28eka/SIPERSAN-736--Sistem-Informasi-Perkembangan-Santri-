<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Daftar Santri</h3>
        <p class="text-sm text-slate-400 mt-1">Total <?= count($santris) ?> santri terdaftar</p>
    </div>
    <div class="flex items-center gap-3">
        <!-- Search Form -->
        <form action="<?= base_url('kepala/santri') ?>" method="get" class="flex items-center" id="searchForm">
            <div class="relative">
                <input type="text" name="keyword" id="searchInput" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama/NISN/kelas..." 
                    class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none w-48 sm:w-64 transition-all">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
            </div>
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('kepala/santri') ?>" class="ml-2 p-2 text-slate-400 hover:text-red-500 transition-all" title="Bersihkan Pencarian">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                </a>
            <?php endif; ?>
        </form>
        <!-- Tombol Export CSV -->
        <a href="<?= base_url('kepala/santri/export') ?>"
           class="flex items-center gap-2 border border-green-300 bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-xl text-sm font-medium transition-all">
            <i data-lucide="download" class="w-4 h-4"></i>
            <span class="hidden md:inline">Export</span>
        </a>
        <!-- Tombol Tambah -->
        <a href="<?= base_url('kepala/santri/create') ?>"
           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition-all text-sm font-medium">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span class="hidden md:inline">Tambah Santri</span>
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
        <table class="w-full text-left" id="santriTable">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                    <th class="px-6 py-4 font-semibold">Nama Santri</th>
                    <th class="px-6 py-4 font-semibold">NISN</th>
                    <th class="px-6 py-4 font-semibold">Kelas</th>
                    <th class="px-6 py-4 font-semibold">Wali Santri</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="santriBody">
                <?php if (empty($santris)) : ?>
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-500 italic text-sm">Belum ada data santri.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($santris as $index => $s) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">
                                        <?= substr($s['name'], 0, 1) ?>
                                    </div>
                                    <span class="font-medium text-slate-700"><?= $s['name'] ?></span>
                                    <?php if ($s['gender'] == 'L') : ?>
                                        <span class="text-[10px] bg-blue-50 text-blue-500 px-2 py-0.5 rounded-full font-bold">L</span>
                                    <?php else : ?>
                                        <span class="text-[10px] bg-pink-50 text-pink-500 px-2 py-0.5 rounded-full font-bold">P</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600"><?= $s['nisn'] ?></td>
                            <td class="px-6 py-4 text-sm text-slate-600"><?= $s['class_name'] ?? '<span class="text-red-400">?</span>' ?></td>
                            <td class="px-6 py-4 text-sm text-slate-600"><?= $s['wali_name'] ?? '<span class="text-red-400">?</span>' ?></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-1">
                                    <!-- Detail -->
                                    <a href="<?= base_url('kepala/santri/detail/' . $s['id']) ?>"
                                       class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Detail">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <!-- Cetak Raport -->
                                    <a href="<?= base_url('kepala/santri/print/' . $s['id']) ?>" target="_blank"
                                       class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-all" title="Cetak Raport">
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                    </a>
                                    <!-- Edit -->
                                    <a href="<?= base_url('kepala/santri/edit/' . $s['id']) ?>"
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                                    </a>
                                    <!-- Hapus -->
                                    <form action="<?= base_url('kepala/santri/delete/' . $s['id']) ?>" method="post"
                                          class="inline" onsubmit="return confirm('Hapus data santri ini?')">
                                        <?= csrf_field() ?>
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
        const rows = document.querySelectorAll('#santriBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            // Kita ambil text dari seluruh kolom di baris tersebut
            const text = row.innerText.toLowerCase();
            if (text.includes(keyword)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update teks jumlah santri
        const countText = document.querySelector('p.text-sm.text-slate-400');
        if (countText) {
            countText.innerText = 'Menampilkan ' + visibleCount + ' santri';
        }
        
        // Tampilkan pesan jika tidak ada hasil
        let emptyRow = document.getElementById('emptySearchRow');
        if (visibleCount === 0) {
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.id = 'emptySearchRow';
                emptyRow.innerHTML = `<td colspan="6" class="px-6 py-10 text-center text-slate-500 italic text-sm">Tidak ada santri yang cocok dengan pencarian "${this.value}".</td>`;
                document.getElementById('santriBody').appendChild(emptyRow);
            }
        } else if (emptyRow) {
            emptyRow.remove();
        }
    });

    // Opsional: Tetap izinkan Enter untuk search server-side (sebagai backup)
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        // Hapus baris kosong buatan JS sebelum submit
        const emptyRow = document.getElementById('emptySearchRow');
        if (emptyRow) emptyRow.remove();
    });
</script>
<?= $this->endSection() ?>
