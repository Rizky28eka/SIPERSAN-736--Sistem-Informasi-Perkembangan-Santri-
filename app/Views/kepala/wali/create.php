<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 max-w-2xl mx-auto">
    <a href="<?= base_url('kepala/wali') ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center space-x-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Daftar</span>
    </a>
    <h3 class="text-xl font-bold text-slate-800">Tambah Data Wali Santri</h3>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 max-w-2xl mx-auto">
    <form action="<?= base_url('kepala/wali/store') ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>
        
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="<?= old('name') ?>" 
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600"
                placeholder="Masukkan nama lengkap wali">
            <?php if (isset(session('errors')['name'])) : ?>
                <p class="text-xs text-red-500 mt-1"><?= session('errors')['name'] ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
            <input type="text" name="username" id="username" value="<?= old('username') ?>" 
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600"
                placeholder="Username untuk login">
            <?php if (isset(session('errors')['username'])) : ?>
                <p class="text-xs text-red-500 mt-1"><?= session('errors')['username'] ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <input type="password" name="password" id="password" 
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600"
                placeholder="Minimal 6 karakter">
            <?php if (isset(session('errors')['password'])) : ?>
                <p class="text-xs text-red-500 mt-1"><?= session('errors')['password'] ?></p>
            <?php endif; ?>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                Simpan Data Wali
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
