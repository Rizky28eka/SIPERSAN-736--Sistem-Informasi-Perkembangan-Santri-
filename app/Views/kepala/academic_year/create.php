<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 max-w-2xl mx-auto">
    <a href="<?= base_url('kepala/academic-year') ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center space-x-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Daftar</span>
    </a>
    <h3 class="text-xl font-bold text-slate-800">Tambah Tahun Ajaran Baru</h3>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 max-w-2xl mx-auto">
    <form action="<?= base_url('kepala/academic-year/store') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="space-y-6">
            <div>
                <label for="year" class="block text-sm font-semibold text-slate-700 mb-2">Tahun Ajaran</label>
                <input type="text" name="year" id="year" value="<?= old('year') ?>" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600"
                    placeholder="Contoh: 2025/2026">
                <?php if (isset(session('errors')['year'])) : ?>
                    <p class="text-xs text-red-500 mt-1"><?= session('errors')['year'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="semester" class="block text-sm font-semibold text-slate-700 mb-2">Semester</label>
                <select name="semester" id="semester" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600 appearance-none bg-white">
                    <option value="">-- Pilih Semester --</option>
                    <option value="ganjil" <?= old('semester') == 'ganjil' ? 'selected' : '' ?>>Ganjil</option>
                    <option value="genap" <?= old('semester') == 'genap' ? 'selected' : '' ?>>Genap</option>
                </select>
                <?php if (isset(session('errors')['semester'])) : ?>
                    <p class="text-xs text-red-500 mt-1"><?= session('errors')['semester'] ?></p>
                <?php endif; ?>
            </div>

            <div class="pt-4">
                <p class="text-xs text-slate-400 mb-4">* Tahun ajaran baru akan dibuat dengan status non-aktif. Silahkan aktifkan secara manual di daftar tahun ajaran.</p>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                    Simpan Tahun Ajaran
                </button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
