<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-bold text-slate-800">Daftar Guru</h3>
    <a href="<?= base_url('kepala/guru/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition-all flex items-center space-x-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Guru</span>
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
                    <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                    <th class="px-6 py-4 font-semibold">Username</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if (empty($gurus)) : ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500 italic text-sm">Belum ada data guru.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($gurus as $index => $guru) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center text-sm text-slate-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">
                                        <?= substr($guru['name'], 0, 1) ?>
                                    </div>
                                    <span class="font-medium text-slate-700"><?= $guru['name'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600"><?= $guru['username'] ?></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="<?= base_url('kepala/guru/detail/' . $guru['id']) ?>" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Detail">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="<?= base_url('kepala/guru/edit/' . $guru['id']) ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                                    </a>
                                    <form action="<?= base_url('kepala/guru/delete/' . $guru['id']) ?>" method="post" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
