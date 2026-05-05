<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-bold text-slate-800">Rekap Nilai Santri</h3>
    <div class="flex space-x-3">
        <form action="" method="get" class="flex space-x-2">
            <select name="class_id" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-600 outline-none focus:ring-2 focus:ring-blue-100 transition-all">
                <option value="">Semua Kelas</option>
                <?php foreach ($classes as $c) : ?>
                    <option value="<?= $c['id'] ?>" <?= $selected_class == $c['id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                    <th class="px-6 py-4 font-semibold">Nama Santri</th>
                    <th class="px-6 py-4 font-semibold">Kelas</th>
                    <th class="px-6 py-4 font-semibold">Status Penilaian</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if (empty($santris)) : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic text-sm">Belum ada data santri untuk ditampilkan.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($santris as $index => $s) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-700"><?= $s['name'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600"><?= $s['class_name'] ?? '-' ?></td>
                            <td class="px-6 py-4">
                                <!-- Placeholder for status -->
                                <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Belum Direkap</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="<?= base_url('kepala/santri/detail/' . $s['id']) ?>" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all inline-flex items-center space-x-1">
                                    <i data-lucide="eye" class="w-3 h-3"></i>
                                    <span>Lihat Detail</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
