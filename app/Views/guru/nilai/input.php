<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 flex flex-col md:flex-row md:items-end justify-between space-y-4 md:space-y-0">
    <div>
        <a href="<?= base_url('guru/nilai') ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center space-x-1 mb-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Kelas</span>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Penilaian: <?= $class['name'] ?></h3>
        <p class="text-sm text-slate-500 mt-1">Tahun Ajaran: <?= $activeYear['year'] ?> - <?= $activeYear['semester'] ?></p>
    </div>
    
    <div class="flex items-center space-x-4 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
        <form action="" method="get" class="flex items-center space-x-2">
            <select name="category" onchange="this.form.submit()" 
                    class="bg-slate-50 border-none rounded-xl px-4 py-2 text-sm text-slate-600 outline-none focus:ring-2 focus:ring-blue-100 transition-all font-medium">
                <?php foreach ($categories as $cat) : ?>
                    <option value="<?= $cat ?>" <?= $category == $cat ? 'selected' : '' ?>><?= $cat ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl mb-6 text-sm flex items-center space-x-2">
        <i data-lucide="check-circle" class="w-4 h-4"></i>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<form action="<?= base_url('guru/nilai/store') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
    <input type="hidden" name="category" value="<?= $category ?>">
    <input type="hidden" name="academic_year_id" value="<?= $activeYear['id'] ?>">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4 w-1/4">Nama Santri</th>
                        <th class="px-6 py-4 w-20 text-center">Angka</th>
                        <th class="px-6 py-4 w-20 text-center">Huruf</th>
                        <th class="px-6 py-4">Catatan / Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($santris)) : ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic text-sm">Belum ada santri di kelas ini.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($santris as $index => $s) : 
                            $scoreNumeric = $gradeMap[$s['id']]['score_numeric'] ?? '';
                            $scoreLetter = $gradeMap[$s['id']]['score_letter'] ?? '';
                            $note = $gradeMap[$s['id']]['notes'] ?? '';
                        ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-slate-700"><?= $s['name'] ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="number" name="grades[<?= $s['id'] ?>][score_numeric]" value="<?= $scoreNumeric ?>" min="0" max="100" placeholder="0"
                                           class="w-full bg-slate-50 border-none rounded-lg px-3 py-2 text-sm text-slate-600 outline-none focus:ring-2 focus:ring-blue-100 transition-all text-center font-bold">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <select name="grades[<?= $s['id'] ?>][score_letter]" 
                                            class="bg-slate-50 border-none rounded-lg px-2 py-2 text-sm text-slate-600 outline-none focus:ring-2 focus:ring-blue-100 transition-all font-bold">
                                        <option value="-" <?= $scoreLetter == '-' ? 'selected' : '' ?>>-</option>
                                        <option value="A" <?= $scoreLetter == 'A' ? 'selected' : '' ?>>A</option>
                                        <option value="B" <?= $scoreLetter == 'B' ? 'selected' : '' ?>>B</option>
                                        <option value="C" <?= $scoreLetter == 'C' ? 'selected' : '' ?>>C</option>
                                        <option value="D" <?= $scoreLetter == 'D' ? 'selected' : '' ?>>D</option>
                                        <option value="E" <?= $scoreLetter == 'E' ? 'selected' : '' ?>>E</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4">
                                    <textarea name="grades[<?= $s['id'] ?>][notes]" rows="1" placeholder="Catatan perkembangan..." 
                                              class="w-full bg-slate-50 border-none rounded-lg px-3 py-2 text-xs text-slate-600 outline-none focus:ring-2 focus:ring-blue-100 transition-all resize-none"><?= $note ?></textarea>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-slate-50/50 border-t border-slate-50 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-xl transition-all shadow-lg shadow-blue-100 flex items-center space-x-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Nilai</span>
            </button>
        </div>
    </div>
</form>
<?= $this->endSection() ?>
