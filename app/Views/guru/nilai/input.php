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

<form action="<?= base_url('guru/nilai/store') ?>" method="post" autocomplete="off">
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
                        <th class="px-6 py-4 w-32 text-center">Angka</th>
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
                            $scoreNumeric = isset($gradeMap[$s['id']]) ? (int)$gradeMap[$s['id']]['score_numeric'] : '';
                            $scoreLetter = $gradeMap[$s['id']]['score_letter'] ?? '';
                            $note = $gradeMap[$s['id']]['notes'] ?? '';
                        ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-slate-700"><?= $s['name'] ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" 
                                           inputmode="numeric"
                                           pattern="[0-9]*"
                                           autocomplete="off"
                                           name="grades[<?= $s['id'] ?>][score_numeric]" 
                                           value="<?= $scoreNumeric ?>" 
                                           data-saved-value="<?= $scoreNumeric ?>"
                                           placeholder="0"
                                           data-santri-id="<?= $s['id'] ?>"
                                           onclick="this.select()"
                                           oninput="validateAndFill(this)"
                                           style="min-width: 80px;"
                                           class="score-input bg-white border border-slate-200 rounded-lg px-4 py-3 text-lg text-slate-800 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all text-center font-bold">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span id="letter-<?= $s['id'] ?>" class="inline-block min-w-[36px] px-3 py-2 rounded-lg text-sm font-bold <?= getLeterBadgeClass($scoreLetter) ?>">
                                        <?= $scoreLetter ?: '-' ?>
                                    </span>
                                    <input type="hidden" name="grades[<?= $s['id'] ?>][score_letter]" id="letter-input-<?= $s['id'] ?>" value="<?= $scoreLetter ?: '-' ?>">
                                </td>
                                <td class="px-6 py-4">
                                    <textarea name="grades[<?= $s['id'] ?>][notes]" rows="1" placeholder="Catatan perkembangan..." 
                                              class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-xs text-slate-600 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all resize-none"><?= $note ?></textarea>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs text-slate-400">
                <i data-lucide="info" class="w-3 h-3 inline"></i>
                Ketik angka 0-100, nilai huruf otomatis terisi (A ≥ 90, B ≥ 80, C ≥ 70, D ≥ 60, E &lt; 60)
            </p>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-xl transition-all shadow-lg shadow-blue-100 flex items-center space-x-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Nilai</span>
            </button>
        </div>
    </div>
</form>

<script>
function validateAndFill(input) {
    // Only allow digits
    input.value = input.value.replace(/[^0-9]/g, '');
    
    // Limit to 100
    var val = parseInt(input.value);
    if (!isNaN(val) && val > 100) {
        input.value = '100';
        val = 100;
    }

    var santriId = input.getAttribute('data-santri-id');
    var letterSpan = document.getElementById('letter-' + santriId);
    var letterInput = document.getElementById('letter-input-' + santriId);
    var letter = '-';
    var badgeClass = 'bg-slate-100 text-slate-400';

    if (!isNaN(val) && input.value !== '') {
        if (val >= 90) { letter = 'A'; badgeClass = 'bg-emerald-100 text-emerald-700'; }
        else if (val >= 80) { letter = 'B'; badgeClass = 'bg-blue-100 text-blue-700'; }
        else if (val >= 70) { letter = 'C'; badgeClass = 'bg-amber-100 text-amber-700'; }
        else if (val >= 60) { letter = 'D'; badgeClass = 'bg-orange-100 text-orange-700'; }
        else { letter = 'E'; badgeClass = 'bg-red-100 text-red-700'; }
    }

    letterSpan.textContent = letter;
    letterSpan.className = 'inline-block min-w-[36px] px-3 py-2 rounded-lg text-sm font-bold ' + badgeClass;
    letterInput.value = letter;
}

// Force restore saved values (defeats browser autocomplete)
function restoreAllValues() {
    document.querySelectorAll('.score-input').forEach(function(input) {
        var savedValue = input.getAttribute('data-saved-value');
        input.value = savedValue;
        if (savedValue !== '') {
            validateAndFill(input);
        }
    });
}

// Run multiple times to ensure browser autocomplete is overridden
document.addEventListener('DOMContentLoaded', function() {
    restoreAllValues();
    setTimeout(restoreAllValues, 50);
    setTimeout(restoreAllValues, 200);
    setTimeout(restoreAllValues, 500);
});
</script>

<?php
function getLeterBadgeClass($letter) {
    switch($letter) {
        case 'A': return 'bg-emerald-100 text-emerald-700';
        case 'B': return 'bg-blue-100 text-blue-700';
        case 'C': return 'bg-amber-100 text-amber-700';
        case 'D': return 'bg-orange-100 text-orange-700';
        case 'E': return 'bg-red-100 text-red-700';
        default:  return 'bg-slate-100 text-slate-400';
    }
}
?>
<?= $this->endSection() ?>
