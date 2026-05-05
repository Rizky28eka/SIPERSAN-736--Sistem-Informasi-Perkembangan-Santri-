<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Data Wali Santri</h3>
        <p class="text-sm text-slate-500 mt-1">Kelola akun orang tua atau wali santri.</p>
    </div>
    <a href="<?= base_url('kepala/wali/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl transition-all shadow-lg shadow-blue-100 flex items-center space-x-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Wali</span>
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl mb-6 text-sm">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider font-bold">
                <th class="px-6 py-4">Nama</th>
                <th class="px-6 py-4">Username</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            <?php foreach ($walis as $w) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold">
                                <?= substr($w['name'], 0, 1) ?>
                            </div>
                            <span class="font-medium text-slate-700"><?= $w['name'] ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500"><?= $w['username'] ?></td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="<?= base_url('kepala/wali/detail/' . $w['id']) ?>" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="<?= base_url('kepala/wali/edit/' . $w['id']) ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </a>
                            <form action="<?= base_url('kepala/wali/delete/' . $w['id']) ?>" method="post" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
