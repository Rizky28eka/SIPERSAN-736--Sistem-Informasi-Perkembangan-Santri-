<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center gap-3">
    <a href="<?= base_url('guru/tahfidz/input') ?>" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <div>
        <h3 class="text-xl font-bold text-slate-800"><?= esc($title) ?></h3>
        <p class="text-slate-500 text-sm mt-1">Tahun Ajaran: <strong><?= esc($activeYear['year']) ?> Sem. <?= esc($activeYear['semester']) ?></strong></p>
    </div>
</div>

<?php if (empty($allItems)) : ?>
    <div class="bg-amber-50 border border-amber-200 text-amber-700 px-5 py-4 rounded-xl text-sm">
        <strong>Perhatian:</strong> Belum ada master data tahfidz. <a href="<?= base_url('guru/tahfidz/create') ?>" class="underline font-semibold">Tambah item dahulu</a>.
    </div>
<?php elseif (empty($santris)) : ?>
    <div class="bg-slate-50 border border-slate-200 text-slate-500 px-5 py-4 rounded-xl text-sm">
        Belum ada santri di kelas ini.
    </div>
<?php else : ?>
    <form action="<?= base_url('guru/tahfidz/input/store') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
        <input type="hidden" name="academic_year_id" value="<?= $activeYear['id'] ?>">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="text-left px-5 py-4 font-semibold text-slate-600 w-8">No</th>
                            <th class="text-left px-5 py-4 font-semibold text-slate-600 min-w-[160px]">Nama Santri</th>
                            <?php foreach ($allItems as $item) : ?>
                                <th class="px-3 py-4 font-semibold text-slate-600 text-center min-w-[100px]">
                                    <div class="text-xs"><?= esc($item['name']) ?></div>
                                    <div class="text-[10px] text-slate-400 font-normal capitalize"><?= $item['type'] ?></div>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($santris as $idx => $santri) : ?>
                            <tr class="hover:bg-slate-50 transition-all">
                                <td class="px-5 py-4 text-slate-400 text-xs"><?= $idx + 1 ?></td>
                                <td class="px-5 py-4">
                                    <div class="font-medium text-slate-700"><?= esc($santri['name']) ?></div>
                                    <div class="text-xs text-slate-400">NISN: <?= esc($santri['nisn']) ?></div>
                                </td>
                                <?php foreach ($allItems as $item) : ?>
                                    <?php
                                    $currentStatus = $gradeMap[$santri['id']][$item['id']]['status'] ?? 'tidak_hafal';
                                    $isHafal = $currentStatus === 'hafal';
                                    ?>
                                    <td class="px-3 py-4 text-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox"
                                                   name="hafalan[<?= $santri['id'] ?>][<?= $item['id'] ?>]"
                                                   value="hafal"
                                                   <?= $isHafal ? 'checked' : '' ?>
                                                   class="sr-only peer">
                                            <div class="w-10 h-6 bg-slate-200 peer-focus:ring-2 peer-focus:ring-green-300 rounded-full peer peer-checked:bg-green-500 transition-all
                                                        after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                                                        peer-checked:after:translate-x-full"></div>
                                        </label>
                                        <div class="text-[10px] mt-1 <?= $isHafal ? 'text-green-600 font-semibold' : 'text-slate-400' ?>">
                                            <?= $isHafal ? 'Hafal' : 'Belum' ?>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5 flex gap-3">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                Simpan Semua Hafalan
            </button>
            <a href="<?= base_url('guru/tahfidz/input') ?>"
               class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-all font-medium">
                Kembali
            </a>
        </div>
    </form>
<?php endif; ?>

<script>
    // Update label teks saat toggle berubah
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        cb.addEventListener('change', function() {
            const label = this.closest('td').querySelector('div');
            if (this.checked) {
                label.textContent = 'Hafal';
                label.className = 'text-[10px] mt-1 text-green-600 font-semibold';
            } else {
                label.textContent = 'Belum';
                label.className = 'text-[10px] mt-1 text-slate-400';
            }
        });
    });
</script>

<?= $this->endSection() ?>
