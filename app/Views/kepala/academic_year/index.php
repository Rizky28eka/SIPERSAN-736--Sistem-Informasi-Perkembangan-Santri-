<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-bold text-slate-800">Manajemen Tahun Ajaran</h3>
    <a href="<?= base_url('kepala/academic-year/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition-all flex items-center space-x-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Tahun Ajaran</span>
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 border border-emerald-100 flex items-center space-x-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <p class="text-sm font-medium"><?= session()->getFlashdata('success') ?></p>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                    <th class="px-6 py-4 font-semibold">Tahun Ajaran</th>
                    <th class="px-6 py-4 font-semibold">Semester</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if (empty($years)) : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic text-sm">Belum ada data tahun ajaran.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($years as $index => $y) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-700"><?= $y['year'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 uppercase font-bold"><?= $y['semester'] ?></td>
                            <td class="px-6 py-4">
                                <?php if ($y['status'] == 'active') : ?>
                                    <span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Aktif</span>
                                <?php else : ?>
                                    <span class="bg-slate-100 text-slate-400 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <?php if ($y['status'] == 'inactive') : ?>
                                        <a href="<?= base_url('kepala/academic-year/activate/' . $y['id']) ?>" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center space-x-1" onclick="return confirm('Aktifkan tahun ajaran ini?')">
                                            <i data-lucide="power" class="w-3 h-3"></i>
                                            <span>Aktifkan</span>
                                        </a>
                                    <?php endif; ?>
                                    <form action="<?= base_url('kepala/academic-year/delete/' . $y['id']) ?>" method="post" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
<?= $this->endSection() ?>
