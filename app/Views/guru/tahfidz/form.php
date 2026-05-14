<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center gap-3">
    <a href="<?= base_url('guru/tahfidz') ?>" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <div>
        <h3 class="text-xl font-bold text-slate-800"><?= esc($title) ?></h3>
        <p class="text-slate-500 text-sm mt-1"><?= $item ? 'Perbarui data item hafalan' : 'Tambah surah, hadits, atau materi baru' ?></p>
    </div>
</div>

<div class="max-w-lg">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= $item ? base_url('guru/tahfidz/update/' . $item['id']) : base_url('guru/tahfidz/store') ?>"
              method="post" class="space-y-5">
            <?= csrf_field() ?>

            <!-- Tipe -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tipe</label>
                <div class="grid grid-cols-3 gap-3">
                    <?php
                    $typeOptions = [
                        'surah'   => ['label' => 'Surah Pendek', 'icon' => 'book-open'],
                        'hadits'  => ['label' => 'Hadits',       'icon' => 'scroll-text'],
                        'lainnya' => ['label' => 'Lainnya',      'icon' => 'star'],
                    ];
                    $selectedType = old('type', $item['type'] ?? 'surah');
                    foreach ($typeOptions as $val => $opt) :
                        $checked = $selectedType === $val ? 'checked' : '';
                    ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="<?= $val ?>" <?= $checked ?> class="sr-only peer">
                            <div class="flex flex-col items-center gap-2 p-3 border-2 border-slate-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-blue-300">
                                <i data-lucide="<?= $opt['icon'] ?>" class="w-5 h-5 text-slate-400 peer-checked:text-blue-600"></i>
                                <span class="text-xs font-medium text-slate-600"><?= $opt['label'] ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Item</label>
                <input type="text" name="name" id="name" required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                       placeholder="Contoh: An-Nas, Al-Falaq, Hadits Niat..."
                       value="<?= esc(old('name', $item['name'] ?? '')) ?>">
            </div>

            <!-- Konten / Isi Materi -->
            <div>
                <label for="content" class="block text-sm font-medium text-slate-700 mb-2">Isi Materi / Tulisan Arab <span class="text-slate-400 font-normal">(opsional)</span></label>
                <textarea name="content" id="content" rows="4" dir="rtl"
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none text-right font-serif text-lg"
                          placeholder="Masukkan teks Arab atau isi materi..."><?= esc(old('content', $item['content'] ?? '')) ?></textarea>
                <p class="text-[10px] text-slate-400 mt-1 italic">Gunakan keyboard Arab jika diperlukan. Teks akan ditampilkan dari kanan (RTL).</p>
            </div>

            <!-- Urutan -->
            <div>
                <label for="sort_order" class="block text-sm font-medium text-slate-700 mb-2">Urutan <span class="text-slate-400 font-normal">(opsional)</span></label>
                <input type="number" name="sort_order" id="sort_order" min="0"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                       placeholder="0"
                       value="<?= esc(old('sort_order', $item['sort_order'] ?? 0)) ?>">
                <p class="text-xs text-slate-400 mt-1">Angka lebih kecil muncul di atas. Biarkan 0 jika tidak penting.</p>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                    <?= $item ? 'Perbarui Item' : 'Simpan Item' ?>
                </button>
                <a href="<?= base_url('guru/tahfidz') ?>"
                   class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-all font-medium text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
