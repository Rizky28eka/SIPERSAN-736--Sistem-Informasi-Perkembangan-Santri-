<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <a href="<?= base_url('kepala/santri') ?>" class="text-sm text-slate-500 hover:text-blue-600 flex items-center gap-1 mb-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
    </a>
    <h3 class="text-xl font-bold text-slate-800">Tambah Santri Baru</h3>
    <p class="text-slate-500 text-sm mt-1">Isi formulir sesuai Kartu Data Santri TKA/TPA</p>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-4xl">
    <form action="<?= base_url('kepala/santri/store') ?>" method="post" class="space-y-8">
        <?= csrf_field() ?>

        <!-- ══ SEKSI 1: Identitas Santri ════════════════════════════════════ -->
        <div>
            <div class="flex items-center gap-2 mb-4">
                <div class="w-1 h-5 bg-blue-500 rounded-full"></div>
                <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Identitas Santri</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="<?= old('name') ?>" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700"
                           placeholder="Nama lengkap santri">
                </div>

                <!-- Nama Panggilan -->
                <div>
                    <label for="nickname" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Panggilan</label>
                    <input type="text" name="nickname" id="nickname" value="<?= old('nickname') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700"
                           placeholder="Nama yang biasa dipanggil">
                </div>

                <!-- NIS -->
                <div>
                    <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-1.5">No. Induk Santri (NIS)</label>
                    <input type="text" name="nisn" id="nisn" value="<?= old('nisn') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700"
                           placeholder="Contoh: 0434">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <div class="flex gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="gender" value="L" <?= old('gender') == 'L' ? 'checked' : '' ?> class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="gender" value="P" <?= old('gender') == 'P' ? 'checked' : '' ?> class="w-4 h-4 text-blue-600">
                            <span class="text-sm text-slate-700">Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="birth_place" class="block text-sm font-semibold text-slate-700 mb-1.5">Tempat Lahir</label>
                    <input type="text" name="birth_place" id="birth_place" value="<?= old('birth_place') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700"
                           placeholder="Kota tempat lahir">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="birth_date" class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" value="<?= old('birth_date') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700">
                </div>

                <!-- Anak ke- -->
                <div>
                    <label for="child_order" class="block text-sm font-semibold text-slate-700 mb-1.5">Anak ke-</label>
                    <input type="number" name="child_order" id="child_order" min="1" max="20" value="<?= old('child_order') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700"
                           placeholder="1">
                </div>

                <!-- Status Anak -->
                <div>
                    <label for="child_status" class="block text-sm font-semibold text-slate-700 mb-1.5">Status Anak</label>
                    <select name="child_status" id="child_status"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700 bg-white">
                        <?php
                        $statusOptions = ['Anak Kandung', 'Anak Tiri', 'Anak Asuh', 'Keponakan', 'Cucu'];
                        foreach ($statusOptions as $opt) :
                        ?>
                            <option value="<?= $opt ?>" <?= old('child_status') === $opt ? 'selected' : '' ?>>
                                <?= $opt ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Agama -->
                <div>
                    <label for="agama" class="block text-sm font-semibold text-slate-700 mb-1.5">Agama</label>
                    <input type="text" name="agama" id="agama" value="<?= old('agama', 'Islam') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700"
                           placeholder="Islam">
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Santri</label>
                    <input type="text" name="address" id="address" value="<?= old('address') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700"
                           placeholder="Alamat lengkap santri">
                </div>
            </div>
        </div>

        <!-- ══ SEKSI 2: Masuk / Keluar Unit TKA/TPA ══════════════════════ -->
        <div>
            <div class="flex items-center gap-2 mb-4">
                <div class="w-1 h-5 bg-green-500 rounded-full"></div>
                <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Masuk / Keluar Unit TKA/TPA</h4>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label for="enter_tka_a" class="block text-xs font-semibold text-slate-600 mb-1.5">Masuk TKA/TPA Paket A</label>
                    <input type="date" name="enter_tka_a" id="enter_tka_a" value="<?= old('enter_tka_a') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all text-slate-700 text-sm">
                </div>
                <div>
                    <label for="enter_tka_b" class="block text-xs font-semibold text-slate-600 mb-1.5">Masuk TKA/TPA Paket B</label>
                    <input type="date" name="enter_tka_b" id="enter_tka_b" value="<?= old('enter_tka_b') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition-all text-slate-700 text-sm">
                </div>
                <div>
                    <label for="exit_tka_a" class="block text-xs font-semibold text-slate-600 mb-1.5">Keluar/Pindah Paket A</label>
                    <input type="date" name="exit_tka_a" id="exit_tka_a" value="<?= old('exit_tka_a') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100 outline-none transition-all text-slate-700 text-sm">
                </div>
                <div>
                    <label for="exit_tka_b" class="block text-xs font-semibold text-slate-600 mb-1.5">Keluar/Pindah Paket B</label>
                    <input type="date" name="exit_tka_b" id="exit_tka_b" value="<?= old('exit_tka_b') ?>"
                           class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100 outline-none transition-all text-slate-700 text-sm">
                </div>
            </div>
        </div>

        <!-- ══ SEKSI 3: Data Orang Tua/Wali ═══════════════════════════════ -->
        <div>
            <div class="flex items-center gap-2 mb-4">
                <div class="w-1 h-5 bg-purple-500 rounded-full"></div>
                <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Data Orang Tua / Wali</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Wali (akun) -->
                <div>
                    <label for="wali_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Orang Tua / Wali (Akun)</label>
                    <select name="wali_id" id="wali_id"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700 bg-white">
                        <option value="">-- Pilih Wali --</option>
                        <?php foreach ($walis as $wali) : ?>
                            <option value="<?= $wali['id'] ?>" <?= old('wali_id') == $wali['id'] ? 'selected' : '' ?>>
                                <?= esc($wali['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Pendidikan Tertinggi -->
                <div>
                    <label for="parent_education" class="block text-sm font-semibold text-slate-700 mb-1.5">Pendidikan Tertinggi (Ortu)</label>
                    <select name="parent_education" id="parent_education"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700 bg-white">
                        <option value="">-- Pilih --</option>
                        <?php
                        $educations = ['Tidak Sekolah', 'SD/MI', 'SMP/MTs', 'SMA/SMK/MA', 'D1/D2/D3', 'S1/D4', 'S2', 'S3'];
                        foreach ($educations as $edu) :
                        ?>
                            <option value="<?= $edu ?>" <?= old('parent_education') === $edu ? 'selected' : '' ?>>
                                <?= $edu ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label for="parent_occupation" class="block text-sm font-semibold text-slate-700 mb-1.5">Pekerjaan Orang Tua</label>
                    <input type="text" name="parent_occupation" id="parent_occupation" value="<?= old('parent_occupation') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700"
                           placeholder="Contoh: Pedagang, PNS, Petani...">
                </div>

                <!-- Kelas -->
                <div>
                    <label for="class_id" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="class_id" id="class_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all text-slate-700 bg-white">
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($classes as $class) : ?>
                            <option value="<?= $class['id'] ?>" <?= old('class_id') == $class['id'] ? 'selected' : '' ?>>
                                <?= esc($class['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="pt-4 border-t border-slate-100 flex gap-3">
            <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-200">
                Simpan Data Santri
            </button>
            <a href="<?= base_url('kepala/santri') ?>"
               class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-all font-medium">
                Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
