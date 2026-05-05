<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-bold text-slate-800">Manajemen Pengumuman</h3>
    <a href="<?= base_url('kepala/announcements/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition-all flex items-center space-x-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Pengumuman</span>
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 border border-emerald-100 flex items-center space-x-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <p class="text-sm font-medium"><?= session()->getFlashdata('success') ?></p>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 gap-4">
    <?php if (empty($announcements)) : ?>
        <div class="bg-white rounded-2xl p-10 text-center border border-slate-100">
            <i data-lucide="megaphone" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
            <p class="text-slate-500 italic">Belum ada pengumuman yang diterbitkan.</p>
        </div>
    <?php else : ?>
        <?php foreach ($announcements as $a) : ?>
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all group">
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <h4 class="text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors"><?= $a['title'] ?></h4>
                            <?php 
                            $badgeClass = 'bg-slate-100 text-slate-600';
                            if($a['target_role'] == 'guru') $badgeClass = 'bg-indigo-50 text-indigo-600';
                            if($a['target_role'] == 'wali') $badgeClass = 'bg-emerald-50 text-emerald-600';
                            ?>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase <?= $badgeClass ?>">
                                <?= $a['target_role'] == 'all' ? 'Publik' : $a['target_role'] ?>
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 flex items-center space-x-2">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            <span><?= date('d M Y, H:i', strtotime($a['created_at'])) ?></span>
                        </p>
                    </div>
                    <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="<?= base_url('kepala/announcements/edit/' . $a['id']) ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                        </a>
                        <form action="<?= base_url('kepala/announcements/delete/' . $a['id']) ?>" method="post" class="inline" onsubmit="return confirm('Hapus pengumuman ini?')">
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mt-4 text-slate-600 text-sm leading-relaxed border-t border-slate-50 pt-4">
                    <?= nl2br($a['content']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
