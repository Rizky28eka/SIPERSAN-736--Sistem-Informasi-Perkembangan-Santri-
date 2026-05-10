<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="<?= base_url('guru/absensi') ?>" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h3 class="text-xl font-bold text-slate-800"><?= esc($title) ?></h3>
            <p class="text-slate-500 text-sm mt-1">
                Tahun Ajaran: <?= esc($activeYear['year']) ?> &bull; Semester <?= esc($activeYear['semester']) ?>
            </p>
        </div>
    </div>
    <button onclick="window.print()"
            class="flex items-center gap-2 border border-slate-200 text-slate-600 hover:bg-slate-50 px-4 py-2 rounded-xl text-sm font-medium transition-all">
        <i data-lucide="printer" class="w-4 h-4"></i>
        Cetak
    </button>
</div>

<!-- Summary Cards -->
<?php
$totalHadir = array_sum(array_column(array_column($rekap, 'summary'), 'Hadir'));
$totalSakit = array_sum(array_column(array_column($rekap, 'summary'), 'Sakit'));
$totalIzin  = array_sum(array_column(array_column($rekap, 'summary'), 'Izin'));
$totalAlpa  = array_sum(array_column(array_column($rekap, 'summary'), 'Alpa'));
$totalAll   = $totalHadir + $totalSakit + $totalIzin + $totalAlpa;
?>
<div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
    <?php
    $summaryCards = [
        ['label' => 'Total Hadir',  'value' => $totalHadir, 'color' => 'green',  'icon' => 'check-circle'],
        ['label' => 'Total Sakit',  'value' => $totalSakit, 'color' => 'blue',   'icon' => 'thermometer'],
        ['label' => 'Total Izin',   'value' => $totalIzin,  'color' => 'yellow', 'icon' => 'clock'],
        ['label' => 'Total Alfa',   'value' => $totalAlpa,  'color' => 'red',    'icon' => 'x-circle'],
        ['label' => 'Total Hari',   'value' => $totalAll,   'color' => 'slate',  'icon' => 'calendar'],
    ];
    foreach ($summaryCards as $card) : ?>
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="<?= $card['icon'] ?>" class="w-4 h-4 text-<?= $card['color'] ?>-500"></i>
                <span class="text-xs text-slate-500 font-medium"><?= $card['label'] ?></span>
            </div>
            <p class="text-2xl font-bold text-slate-800"><?= $card['value'] ?></p>
        </div>
    <?php endforeach; ?>
</div>

<!-- Tabel Rekap Per Santri -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h4 class="font-semibold text-slate-700">Detail Rekapitulasi Per Santri</h4>
        <span class="text-sm text-slate-400"><?= count($rekap) ?> santri</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Santri</th>
                    <th class="text-center px-4 py-3 font-semibold text-green-600">Hadir</th>
                    <th class="text-center px-4 py-3 font-semibold text-blue-600">Sakit</th>
                    <th class="text-center px-4 py-3 font-semibold text-yellow-600">Izin</th>
                    <th class="text-center px-4 py-3 font-semibold text-red-600">Alfa</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-600">Total</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-600">% Hadir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($rekap as $i => $r) :
                    $s   = $r['summary'];
                    $pct = $s['total'] > 0 ? round(($s['Hadir'] / $s['total']) * 100) : 0;
                    $pctColor = $pct >= 75 ? 'green' : ($pct >= 50 ? 'yellow' : 'red');
                ?>
                    <tr class="hover:bg-slate-50 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                    <?= $i + 1 ?>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700"><?= esc($r['santri']['name']) ?></p>
                                    <p class="text-xs text-slate-400">NISN: <?= esc($r['santri']['nisn']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block px-2.5 py-1 bg-green-100 text-green-700 rounded-lg font-semibold text-xs"><?= $s['Hadir'] ?></span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg font-semibold text-xs"><?= $s['Sakit'] ?></span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-lg font-semibold text-xs"><?= $s['Izin'] ?></span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block px-2.5 py-1 bg-red-100 text-red-700 rounded-lg font-semibold text-xs"><?= $s['Alpa'] ?></span>
                        </td>
                        <td class="px-4 py-4 text-center font-bold text-slate-700"><?= $s['total'] ?></td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden max-w-[60px]">
                                    <div class="h-full bg-<?= $pctColor ?>-500 rounded-full" style="width: <?= $pct ?>%"></div>
                                </div>
                                <span class="text-xs font-semibold text-<?= $pctColor ?>-600"><?= $pct ?>%</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
