<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 flex flex-col md:flex-row md:items-end justify-between space-y-4 md:space-y-0">
    <div>
        <a href="<?= base_url('guru/nilai/input/' . $class['id']) ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center space-x-1 mb-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Santri</span>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Evaluasi Raport: <?= esc($santri['name']) ?></h3>
        <p class="text-sm text-slate-500 mt-1">Kelas: <?= esc($class['name']) ?> | Tahun Ajaran: <?= esc($activeYear['year']) ?> - <?= esc($activeYear['semester']) ?></p>
    </div>
</div>

<form action="<?= base_url('guru/nilai/store-evaluasi') ?>" method="post" autocomplete="off">
    <?= csrf_field() ?>
    <input type="hidden" name="santri_id" value="<?= $santri['id'] ?>">
    <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
    <input type="hidden" name="academic_year_id" value="<?= $activeYear['id'] ?>">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-800 text-white">
                        <th class="px-6 py-4 font-bold w-1/2">ASPEK PENILAIAN</th>
                        <th class="px-6 py-4 font-bold w-1/2">NILAI / KETERANGAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    
                    <!-- A. NILAI AKADEMIK -->
                    <tr class="bg-slate-100">
                        <td colspan="2" class="px-6 py-3 font-bold text-slate-700 uppercase tracking-wider">A. Nilai Akademik & Al-Qur'an</td>
                    </tr>
                    <?php foreach ($categories as $cat) : 
                        $scoreNumeric = isset($gradeMap[$cat]) ? $gradeMap[$cat]['score_numeric'] : '';
                        $scoreLetter  = isset($gradeMap[$cat]) ? $gradeMap[$cat]['score_letter'] : '-';
                        $isMuatanLokal = in_array($cat, ['Hafalan Hadits/Mahfuzhat', 'Bahasa Arab', 'Bahasa Inggris']);
                    ?>
                        <?php if ($cat === 'Hafalan Hadits/Mahfuzhat') : ?>
                            <tr class="bg-slate-50">
                                <td colspan="2" class="px-6 py-2 text-xs font-bold text-slate-500 italic">MUATAN LOKAL</td>
                            </tr>
                        <?php endif; ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3 text-slate-700 <?= $isMuatanLokal ? 'pl-10' : '' ?>">
                                <?= esc($cat) ?>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <input type="text" inputmode="numeric" pattern="[0-9]*"
                                           name="grades[<?= esc($cat) ?>][score_numeric]" 
                                           value="<?= $scoreNumeric ?>" 
                                           data-saved-value="<?= $scoreNumeric ?>"
                                           placeholder="Angka (0-100)"
                                           data-cat-id="<?= md5($cat) ?>"
                                           onclick="this.select()"
                                           oninput="validateAndFill(this)"
                                           class="score-input w-32 bg-white border border-slate-200 rounded-lg px-3 py-2 text-center font-bold text-slate-800 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-all">
                                    
                                    <span id="letter-<?= md5($cat) ?>" class="inline-block min-w-[40px] px-3 py-2 text-center rounded-lg font-bold <?= getLeterBadgeClass($scoreLetter) ?>">
                                        <?= $scoreLetter ?: '-' ?>
                                    </span>
                                    <input type="hidden" name="grades[<?= esc($cat) ?>][score_letter]" id="letter-input-<?= md5($cat) ?>" value="<?= $scoreLetter ?: '-' ?>">
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- B. EKSTRAKURIKULER -->
                    <tr class="bg-slate-100">
                        <td colspan="2" class="px-6 py-3 font-bold text-slate-700 uppercase tracking-wider">B. Kegiatan Ekstrakurikuler</td>
                    </tr>
                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3">
                                <input type="text" name="ekskul_<?= $i ?>" value="<?= esc($development["ekskul_{$i}"] ?? '') ?>" placeholder="Nama Ekstrakurikuler <?= $i ?>" class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all">
                            </td>
                            <td class="px-6 py-3">
                                <select name="ekskul_<?= $i ?>_nilai" class="w-full max-w-[200px] bg-white border border-slate-200 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all">
                                    <option value="">- Pilih Nilai -</option>
                                    <option value="B" <?= ($development["ekskul_{$i}_nilai"] ?? '') === 'B' ? 'selected' : '' ?>>Baik (B)</option>
                                    <option value="C" <?= ($development["ekskul_{$i}_nilai"] ?? '') === 'C' ? 'selected' : '' ?>>Cukup (C)</option>
                                    <option value="K" <?= ($development["ekskul_{$i}_nilai"] ?? '') === 'K' ? 'selected' : '' ?>>Kurang (K)</option>
                                </select>
                            </td>
                        </tr>
                    <?php endfor; ?>

                    <!-- C. KEPRIBADIAN -->
                    <tr class="bg-slate-100">
                        <td colspan="2" class="px-6 py-3 font-bold text-slate-700 uppercase tracking-wider">C. Kepribadian</td>
                    </tr>
                    <?php
                    $kepItems = [
                        'disiplin' => 'Kedisiplinan',
                        'jujur' => 'Kejujuran',
                        'kerja_sama' => 'Kerjasama',
                        'rajin' => 'Kerajinan',
                        'kemampuan_berfikir' => 'Kemampuan Berfikir'
                    ];
                    foreach ($kepItems as $field => $label) :
                        $val = $development[$field] ?? '';
                    ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3 text-slate-700"><?= $label ?></td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-6">
                                    <label class="flex items-center gap-2 cursor-pointer text-emerald-700 font-medium">
                                        <input type="radio" name="<?= $field ?>" value="B" <?= $val === 'B' ? 'checked' : '' ?> class="w-4 h-4 text-emerald-600 focus:ring-emerald-500"> Baik
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer text-blue-700 font-medium">
                                        <input type="radio" name="<?= $field ?>" value="C" <?= $val === 'C' ? 'checked' : '' ?> class="w-4 h-4 text-blue-600 focus:ring-blue-500"> Cukup
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer text-red-700 font-medium">
                                        <input type="radio" name="<?= $field ?>" value="K" <?= $val === 'K' ? 'checked' : '' ?> class="w-4 h-4 text-red-600 focus:ring-red-500"> Kurang
                                    </label>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- D. KETIDAKHADIRAN -->
                    <tr class="bg-slate-100">
                        <td colspan="2" class="px-6 py-3 font-bold text-slate-700 uppercase tracking-wider">D. Ketidakhadiran</td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 text-slate-700">Sakit</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <input type="number" name="sakit_hari" value="<?= esc($development['sakit_hari'] ?? '0') ?>" min="0" class="w-24 bg-white border border-slate-200 rounded-lg px-3 py-2 text-center outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all">
                                <span class="text-slate-500">Hari</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 text-slate-700">Izin</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <input type="number" name="izin_hari" value="<?= esc($development['izin_hari'] ?? '0') ?>" min="0" class="w-24 bg-white border border-slate-200 rounded-lg px-3 py-2 text-center outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all">
                                <span class="text-slate-500">Hari</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 text-slate-700">Tanpa Keterangan (Alfa)</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <input type="number" name="tanpa_keterangan_hari" value="<?= esc($development['tanpa_keterangan_hari'] ?? '0') ?>" min="0" class="w-24 bg-white border border-slate-200 rounded-lg px-3 py-2 text-center outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all">
                                <span class="text-slate-500">Hari</span>
                            </div>
                        </td>
                    </tr>

                    <!-- E. CATATAN WALI KELAS -->
                    <tr class="bg-slate-100">
                        <td colspan="2" class="px-6 py-3 font-bold text-slate-700 uppercase tracking-wider">E. Catatan Wali Kelas</td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td colspan="2" class="px-6 py-4">
                            <textarea name="teacher_notes" rows="3" placeholder="Tuliskan pesan penyemangat atau catatan perkembangan untuk orang tua santri..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-all resize-y"><?= esc($development['teacher_notes'] ?? '') ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="<?= base_url('guru/nilai/input/' . $class['id']) ?>" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-medium transition-all">Batal</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-100 flex items-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i>
            Simpan Evaluasi Raport
        </button>
    </div>
</form>

<script>
function validateAndFill(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    var val = parseInt(input.value);
    if (!isNaN(val) && val > 100) {
        input.value = '100';
        val = 100;
    }

    var catId = input.getAttribute('data-cat-id');
    var letterSpan = document.getElementById('letter-' + catId);
    var letterInput = document.getElementById('letter-input-' + catId);
    var letter = '-';
    var badgeClass = 'bg-slate-100 text-slate-400';

    if (!isNaN(val) && input.value !== '') {
        if (val >= 90) { letter = 'A'; badgeClass = 'bg-emerald-100 text-emerald-700'; }
        else if (val >= 80) { letter = 'B'; badgeClass = 'bg-blue-100 text-blue-700'; }
        else if (val >= 70) { letter = 'C'; badgeClass = 'bg-amber-100 text-amber-700'; }
        else if (val >= 60) { letter = 'D'; badgeClass = 'bg-orange-100 text-orange-700'; }
        else { letter = 'E'; badgeClass = 'bg-red-100 text-red-700'; }
    }

    if(letterSpan && letterInput) {
        letterSpan.textContent = letter;
        letterSpan.className = 'inline-block min-w-[40px] px-3 py-2 text-center rounded-lg font-bold ' + badgeClass;
        letterInput.value = letter;
    }
}

function restoreAllValues() {
    document.querySelectorAll('.score-input').forEach(function(input) {
        var savedValue = input.getAttribute('data-saved-value');
        input.value = savedValue;
        if (savedValue !== '') {
            validateAndFill(input);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    restoreAllValues();
    setTimeout(restoreAllValues, 50);
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
