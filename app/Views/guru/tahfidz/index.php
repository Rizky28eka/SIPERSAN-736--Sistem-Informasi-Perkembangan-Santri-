<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Master Data Tahfidz</h3>
        <p class="text-slate-500 text-sm mt-1">Kelola daftar surah, hadits, dan materi hafalan lainnya</p>
    </div>
    <div class="flex gap-2">
        <a href="<?= base_url('guru/tahfidz/input') ?>"
           class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-medium transition-all shadow-lg shadow-green-200 text-sm">
            <i data-lucide="check-square" class="w-4 h-4"></i>
            Input Hafalan Santri
        </a>
        <a href="<?= base_url('guru/tahfidz/create') ?>"
           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-all shadow-lg shadow-blue-200 text-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Item
        </a>
    </div>
</div>

<!-- Tabs per Tipe -->
<?php $types = ['surah' => ['label' => 'Surah Pendek', 'icon' => 'book-open', 'color' => 'blue'],
                'hadits' => ['label' => 'Hadits', 'icon' => 'scroll-text', 'color' => 'purple'],
                'lainnya' => ['label' => 'Lainnya', 'icon' => 'star', 'color' => 'orange']]; ?>

<div class="grid grid-cols-1 gap-6">
    <?php foreach ($types as $typeKey => $typeInfo) : ?>
        <?php $typeItems = array_filter($items ?? [], fn($i) => $i['type'] === $typeKey); ?>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-<?= $typeInfo['color'] ?>-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="<?= $typeInfo['icon'] ?>" class="w-5 h-5 text-<?= $typeInfo['color'] ?>-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-700"><?= $typeInfo['label'] ?></h4>
                        <p class="text-xs text-slate-400"><?= count($typeItems) ?> item</p>
                    </div>
                </div>
            </div>

            <?php if (empty($typeItems)) : ?>
                <div class="py-10 text-center text-slate-400">
                    <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                    <p class="text-sm">Belum ada data. <a href="<?= base_url('guru/tahfidz/create') ?>" class="text-blue-600 hover:underline">Tambah sekarang</a></p>
                </div>
            <?php else : ?>
                <div class="divide-y divide-slate-50">
                    <?php foreach ($typeItems as $item) : ?>
                        <div class="flex items-center justify-between px-6 py-3 hover:bg-slate-50 transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 bg-<?= $typeInfo['color'] ?>-50 text-<?= $typeInfo['color'] ?>-600 rounded-full text-xs flex items-center justify-center font-semibold">
                                    <?= $item['sort_order'] ?: '—' ?>
                                </span>
                                <span class="text-slate-700 font-medium"><?= esc($item['name']) ?></span>
                            </div>
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                <a href="<?= base_url('guru/tahfidz/edit/' . $item['id']) ?>"
                                   class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="<?= base_url('guru/tahfidz/delete/' . $item['id']) ?>" method="post"
                                      onsubmit="return confirm('Hapus item ini?')">
                                    <?= csrf_field() ?>
                                    <button class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
