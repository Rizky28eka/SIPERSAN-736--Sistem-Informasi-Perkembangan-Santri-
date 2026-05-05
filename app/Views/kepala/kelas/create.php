<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 max-w-2xl mx-auto">
    <a href="<?= base_url('kepala/kelas') ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center space-x-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Daftar</span>
    </a>
    <h3 class="text-xl font-bold text-slate-800">Tambah Kelas Baru</h3>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 max-w-2xl mx-auto">
    <form action="<?= base_url('kepala/kelas/store') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Kelas</label>
                <input type="text" name="name" id="name" value="<?= old('name') ?>" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600"
                    placeholder="Contoh: Paket A, Paket B, dll">
                <?php if (isset(session('errors')['name'])) : ?>
                    <p class="text-xs text-red-500 mt-1"><?= session('errors')['name'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="teacher_id" class="block text-sm font-semibold text-slate-700 mb-2">Wali Kelas / Guru Pengajar</label>
                <select name="teacher_id" id="teacher_id" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600 appearance-none bg-white">
                    <option value="">-- Pilih Guru --</option>
                    <?php foreach ($teachers as $teacher) : ?>
                        <option value="<?= $teacher['id'] ?>" <?= old('teacher_id') == $teacher['id'] ? 'selected' : '' ?>><?= $teacher['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset(session('errors')['teacher_id'])) : ?>
                    <p class="text-xs text-red-500 mt-1"><?= session('errors')['teacher_id'] ?></p>
                <?php endif; ?>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                    Simpan Data Kelas
                </button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
