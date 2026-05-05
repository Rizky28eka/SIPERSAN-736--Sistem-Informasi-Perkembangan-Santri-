<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6 max-w-4xl mx-auto">
    <a href="<?= base_url('kepala/santri') ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center space-x-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Daftar</span>
    </a>
    <h3 class="text-xl font-bold text-slate-800">Edit Data Santri</h3>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 max-w-4xl mx-auto">
    <form action="<?= base_url('kepala/santri/update/' . $santri['id']) ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="<?= old('name', $santri['name']) ?>" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600"
                        placeholder="Masukkan nama lengkap santri">
                    <?php if (isset(session('errors')['name'])) : ?>
                        <p class="text-xs text-red-500 mt-1"><?= session('errors')['name'] ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-2">NISN</label>
                    <input type="text" name="nisn" id="nisn" value="<?= old('nisn', $santri['nisn']) ?>" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600"
                        placeholder="Nomor Induk Siswa Nasional">
                    <?php if (isset(session('errors')['nisn'])) : ?>
                        <p class="text-xs text-red-500 mt-1"><?= session('errors')['nisn'] ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="gender" class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="gender" value="L" <?= old('gender', $santri['gender']) == 'L' ? 'checked' : '' ?> class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-600">Laki-laki</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="gender" value="P" <?= old('gender', $santri['gender']) == 'P' ? 'checked' : '' ?> class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-600">Perempuan</span>
                        </label>
                    </div>
                    <?php if (isset(session('errors')['gender'])) : ?>
                        <p class="text-xs text-red-500 mt-1"><?= session('errors')['gender'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="class_id" class="block text-sm font-semibold text-slate-700 mb-2">Kelas</label>
                    <select name="class_id" id="class_id" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600 appearance-none bg-white">
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($classes as $class) : ?>
                            <option value="<?= $class['id'] ?>" <?= old('class_id', $santri['class_id']) == $class['id'] ? 'selected' : '' ?>><?= $class['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset(session('errors')['class_id'])) : ?>
                        <p class="text-xs text-red-500 mt-1"><?= session('errors')['class_id'] ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="wali_id" class="block text-sm font-semibold text-slate-700 mb-2">Orang Tua / Wali</label>
                    <select name="wali_id" id="wali_id" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600 appearance-none bg-white">
                        <option value="">-- Pilih Wali --</option>
                        <?php foreach ($walis as $wali) : ?>
                            <option value="<?= $wali['id'] ?>" <?= old('wali_id', $santri['wali_id']) == $wali['id'] ? 'selected' : '' ?>><?= $wali['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset(session('errors')['wali_id'])) : ?>
                        <p class="text-xs text-red-500 mt-1"><?= session('errors')['wali_id'] ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                    <textarea name="address" id="address" rows="1"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all text-slate-600"
                        placeholder="Alamat lengkap"><?= old('address', $santri['address']) ?></textarea>
                    <?php if (isset(session('errors')['address'])) : ?>
                        <p class="text-xs text-red-500 mt-1"><?= session('errors')['address'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-50 mt-8">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                Update Data Santri
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
