<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-bold text-slate-800">Pengumuman</h3>
    <?php if (session()->get('role') === 'kepala') : ?>
        <a href="<?= base_url('kepala/announcements/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-lg shadow-blue-100 flex items-center space-x-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Buat Pengumuman</span>
        </a>
    <?php endif; ?>
</div>

<div class="space-y-4">
    <?php if (empty($announcements)) : ?>
        <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="megaphone" class="w-8 h-8 text-slate-300"></i>
            </div>
            <h4 class="text-slate-600 font-medium">Belum ada pengumuman</h4>
            <p class="text-slate-400 text-sm mt-1">Semua pengumuman penting akan muncul di sini.</p>
        </div>
    <?php else : ?>
        <?php foreach ($announcements as $a) : ?>
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="font-bold text-slate-800 text-lg"><?= $a['title'] ?></h4>
                        <p class="text-xs text-slate-400 mt-1"><?= date('d M Y H:i', strtotime($a['created_at'])) ?></p>
                    </div>
                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider italic">Internal</span>
                </div>
                <div class="text-slate-600 text-sm leading-relaxed">
                    <?= nl2br($a['content']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
