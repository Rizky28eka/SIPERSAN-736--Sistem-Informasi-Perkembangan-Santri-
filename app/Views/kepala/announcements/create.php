<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex items-center space-x-3 mb-6">
    <a href="<?= base_url('kepala/announcements') ?>" class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-500">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <h3 class="text-xl font-bold text-slate-800">Tambah Pengumuman Baru</h3>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 max-w-2xl mx-auto">
    <form action="<?= base_url('kepala/announcements/store') ?>" method="post" class="space-y-6">
        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-700">Judul Pengumuman</label>
            <input type="text" name="title" value="<?= old('title') ?>" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition-all" placeholder="Contoh: Libur Hari Raya">
            <?php if (isset(session('errors')['title'])) : ?>
                <p class="text-[10px] text-red-500 font-bold"><?= session('errors')['title'] ?></p>
            <?php endif; ?>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-700">Target Audiens</label>
            <select name="target_role" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                <option value="all" <?= old('target_role') == 'all' ? 'selected' : '' ?>>Semua (Publik)</option>
                <option value="guru" <?= old('target_role') == 'guru' ? 'selected' : '' ?>>Khusus Pengajar/Guru</option>
                <option value="wali" <?= old('target_role') == 'wali' ? 'selected' : '' ?>>Khusus Wali Santri</option>
            </select>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-bold text-slate-700">Isi Pengumuman</label>
            <textarea name="content" rows="6" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition-all" placeholder="Tuliskan isi pengumuman di sini..."><?= old('content') ?></textarea>
            <?php if (isset(session('errors')['content'])) : ?>
                <p class="text-[10px] text-red-500 font-bold"><?= session('errors')['content'] ?></p>
            <?php endif; ?>
        </div>

        <div class="pt-4 flex space-x-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-100">
                Terbitkan Pengumuman
            </button>
            <a href="<?= base_url('kepala/announcements') ?>" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 px-8 rounded-xl transition-all">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
