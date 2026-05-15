<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Daftar Santri</h3>
        <p class="text-sm text-slate-400 mt-1">Menampilkan seluruh santri di kelas yang Anda ampu.</p>
    </div>
    <div class="flex items-center gap-3">
        <!-- Search Form -->
        <form action="<?= base_url('guru/santri') ?>" method="get" class="flex items-center" id="searchForm">
            <div class="relative">
                <input type="text" name="keyword" id="searchInput" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama/NISN..." 
                    class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none w-48 sm:w-64 transition-all">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
            </div>
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('guru/santri') ?>" class="ml-2 p-2 text-slate-400 hover:text-red-500 transition-all" title="Bersihkan Pencarian">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left" id="santriTable">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                    <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                    <th class="px-6 py-4 font-semibold">NISN</th>
                    <th class="px-6 py-4 font-semibold">Kelas</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="santriBody">
                <?php if (empty($santri)) : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic text-sm">Belum ada data santri.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($santri as $index => $s) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">
                                        <?= substr($s['name'], 0, 1) ?>
                                    </div>
                                    <span class="font-medium text-slate-700"><?= $s['name'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 font-mono"><?= $s['nisn'] ?></td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-bold uppercase"><?= $s['class_name'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="<?= base_url('guru/nilai/input/' . $s['class_id']) ?>" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Input Nilai">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <a href="<?= base_url('guru/absensi/input/' . $s['class_id']) ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Input Absensi">
                                        <i data-lucide="calendar-check" class="w-4 h-4"></i>
                                    </a>
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
                emptyRow.innerHTML = `<td colspan="5" class="px-6 py-10 text-center text-slate-500 italic text-sm">Tidak ada santri yang cocok dengan pencarian "${this.value}".</td>`;
                document.getElementById('santriBody').appendChild(emptyRow);
            }
        } else if (emptyRow) {
            emptyRow.remove();
        }
    });
</script>
<?= $this->endSection() ?>
