<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center gap-3">
    <a href="<?= base_url('guru/perkembangan') ?>" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <div>
        <h3 class="text-xl font-bold text-slate-800"><?= esc($title) ?></h3>
        <p class="text-slate-500 text-sm mt-1">
            Kelas: <?= esc($class['name']) ?> &bull; TA: <?= esc($activeYear['year']) ?> Sem. <?= esc($activeYear['semester']) ?>
        </p>
    </div>
</div>

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

        <!-- Info Santri -->
        <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-50 to-slate-50 rounded-xl mb-6 border border-blue-100">
            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
                <?= strtoupper(substr($santri['name'], 0, 1)) ?>
            </div>
            <div>
                <p class="font-bold text-slate-800"><?= esc($santri['name']) ?></p>
                <?php if (!empty($santri['nickname'])) : ?>
                    <p class="text-xs text-slate-500">Panggilan: <?= esc($santri['nickname']) ?></p>
                <?php endif; ?>
                <p class="text-xs text-slate-400">NIS: <?= esc($santri['nisn']) ?> &bull; <?= $santri['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
            </div>
        </div>

        <form action="<?= base_url('guru/perkembangan/save') ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="santri_id" value="<?= $santri['id'] ?>">
            <input type="hidden" name="academic_year_id" value="<?= $activeYear['id'] ?>">

            <!-- ══ KEGIATAN EKSTRA KURIKULUM ══════════════════════════════ -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-1 h-5 bg-purple-500 rounded-full"></div>
                    <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Kegiatan Ekstra Kurikulum</h4>
                </div>
                <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-100">
                                <th class="text-left px-4 py-2 font-semibold text-slate-600 w-8">No</th>
                                <th class="text-left px-4 py-2 font-semibold text-slate-600">Kegiatan / Nama Ekskul</th>
                                <th class="text-center px-4 py-2 font-semibold text-slate-600 w-28">Nilai (B/C/K)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php for ($i = 1; $i <= 3; $i++) :
                                $ekskulKey = "ekskul_{$i}";
                                $nilaiKey  = "ekskul_{$i}_nilai";
                            ?>
                                <tr>
                                    <td class="px-4 py-2 text-slate-400"><?= $i ?></td>
                                    <td class="px-4 py-2">
                                        <input type="text" name="<?= $ekskulKey ?>"
                                               class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-purple-400 focus:border-transparent outline-none"
                                               placeholder="Nama kegiatan ekstrakurikuler..."
                                               value="<?= esc($development[$ekskulKey] ?? '') ?>">
                                    </td>
                                    <td class="px-4 py-2">
                                        <select name="<?= $nilaiKey ?>"
                                                class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-bold focus:ring-2 focus:ring-purple-400 outline-none text-center">
                                            <option value="">-</option>
                                            <?php foreach (['B' => 'B (Baik)', 'C' => 'C (Cukup)', 'K' => 'K (Kurang)'] as $val => $label) : ?>
                                                <option value="<?= $val ?>"
                                                        <?= ($development[$nilaiKey] ?? '') === $val ? 'selected' : '' ?>>
                                                    <?= $label ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <p class="text-xs text-slate-400 mt-1.5">B = Baik &nbsp;|&nbsp; C = Cukup &nbsp;|&nbsp; K = Kurang</p>
            </div>

            <!-- ══ KEPRIBADIAN ════════════════════════════════════════════ -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-1 h-5 bg-blue-500 rounded-full"></div>
                    <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Kepribadian</h4>
                </div>
                <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-100">
                                <th class="text-left px-4 py-2 font-semibold text-slate-600 w-8">No</th>
                                <th class="text-left px-4 py-2 font-semibold text-slate-600">Aspek Kepribadian</th>
                                <th class="text-center px-3 py-2 font-semibold text-slate-600 w-20">B</th>
                                <th class="text-center px-3 py-2 font-semibold text-slate-600 w-20">C</th>
                                <th class="text-center px-3 py-2 font-semibold text-slate-600 w-20">K</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php
                            $kepribadian = [
                                'disiplin'           => '1. Kedisiplinan',
                                'jujur'              => '2. Kejujuran',
                                'kerja_sama'         => '3. Kerjasama',
                                'rajin'              => '4. Kerajinan',
                                'kemampuan_berfikir' => '5. Kemampuan Berfikir/Akal',
                            ];
                            foreach ($kepribadian as $field => $label) :
                                $current = $development[$field] ?? null;
                            ?>
                                <tr class="hover:bg-white transition-all">
                                    <td class="px-4 py-3 text-slate-400"></td>
                                    <td class="px-4 py-3 font-medium text-slate-700"><?= $label ?></td>
                                    <?php foreach (['B', 'C', 'K'] as $opt) : ?>
                                        <td class="px-3 py-3 text-center">
                                            <label class="cursor-pointer inline-flex items-center justify-center">
                                                <input type="radio"
                                                       name="<?= $field ?>"
                                                       value="<?= $opt ?>"
                                                       <?= $current === $opt ? 'checked' : '' ?>
                                                       class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-400">
                                            </label>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-slate-100 border-t border-slate-200">
                                <td colspan="2" class="px-4 py-2 text-xs text-slate-500 font-semibold">Keterangan:</td>
                                <td class="text-center py-2 text-xs font-bold text-green-700">Baik</td>
                                <td class="text-center py-2 text-xs font-bold text-amber-600">Cukup</td>
                                <td class="text-center py-2 text-xs font-bold text-red-600">Kurang</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- ══ KETIDAKHADIRAN ═════════════════════════════════════════ -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-1 h-5 bg-red-500 rounded-full"></div>
                    <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Ketidakhadiran</h4>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <?php
                    $absensi = [
                        'sakit_hari'             => ['label' => '1. Sakit',             'color' => 'blue'],
                        'izin_hari'              => ['label' => '2. Izin',              'color' => 'amber'],
                        'tanpa_keterangan_hari'  => ['label' => '3. Tanpa Keterangan', 'color' => 'red'],
                    ];
                    foreach ($absensi as $field => $info) :
                    ?>
                        <div class="bg-<?= $info['color'] ?>-50 border border-<?= $info['color'] ?>-200 rounded-xl p-3">
                            <label class="block text-xs font-semibold text-<?= $info['color'] ?>-700 mb-2"><?= $info['label'] ?></label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="<?= $field ?>" min="0" max="99"
                                       value="<?= (int) ($development[$field] ?? 0) ?>"
                                       class="w-full bg-white border border-<?= $info['color'] ?>-200 rounded-lg px-3 py-2 text-lg font-bold text-center focus:ring-2 focus:ring-<?= $info['color'] ?>-400 outline-none">
                                <span class="text-xs text-<?= $info['color'] ?>-500 font-medium">hari</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ══ CATATAN WALI KELAS ════════════════════════════════════ -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-1 h-5 bg-green-500 rounded-full"></div>
                    <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Catatan Untuk Orang Tua / Wali</h4>
                </div>
                <textarea name="teacher_notes" rows="4"
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all outline-none resize-none text-sm"
                          placeholder="Tuliskan catatan penting, saran, atau pesan dari wali kelas untuk orang tua/wali santri..."><?= esc($development['teacher_notes'] ?? '') ?></textarea>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                    <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                    Simpan Perkembangan
                </button>
                <?php if ($development) : ?>
                    <form action="<?= base_url('guru/perkembangan/delete/' . $development['id']) ?>"
                          method="post" onsubmit="return confirm('Hapus data perkembangan ini?')" class="inline">
                        <?= csrf_field() ?>
                        <button type="submit"
                                class="px-5 py-3 border border-red-200 text-red-500 rounded-xl hover:bg-red-50 transition-all">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                <?php endif; ?>
                <a href="<?= base_url('guru/perkembangan') ?>"
                   class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-all font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
