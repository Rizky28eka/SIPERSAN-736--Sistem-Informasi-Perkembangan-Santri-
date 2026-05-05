<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-3">
        <a href="<?= base_url('kepala/wali') ?>" class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-500">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Profil Wali Santri</h3>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('kepala/wali/edit/' . $wali['id']) ?>" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl hover:bg-blue-100 transition-all text-sm font-medium flex items-center space-x-2">
            <i data-lucide="edit-2" class="w-4 h-4"></i>
            <span>Edit Profil</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Wali Profile -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-bold text-3xl mx-auto mb-4 border-4 border-white shadow-lg shadow-emerald-100">
                <?= substr($wali['name'], 0, 1) ?>
            </div>
            <h4 class="text-lg font-bold text-slate-800"><?= $wali['name'] ?></h4>
            <p class="text-slate-500 text-sm mb-4">@<?= $wali['username'] ?></p>
            
            <div class="flex justify-center mb-6">
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold uppercase tracking-wider">
                    Wali Santri / Orang Tua
                </span>
            </div>

            <div class="space-y-4 text-left border-t border-slate-50 pt-6">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Email</label>
                    <p class="text-sm text-slate-700 font-medium"><?= $wali['email'] ?? '-' ?></p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Total Anak</label>
                    <p class="text-sm text-slate-800 font-bold"><?= count($children) ?> Santri</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Status Akun</label>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Terverifikasi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Children List -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                <h5 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                    <i data-lucide="users" class="w-4 h-4 text-emerald-500"></i>
                    <span>Daftar Santri (Anak)</span>
                </h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-6 py-3">Nama Santri</th>
                            <th class="px-6 py-3">NISN</th>
                            <th class="px-6 py-3">Kelas</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($children)) : ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 italic">Belum ada santri yang terhubung dengan wali ini.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($children as $s) : ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-700">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold text-[10px]">
                                                <?= substr($s['name'], 0, 1) ?>
                                            </div>
                                            <span><?= $s['name'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600"><?= $s['nisn'] ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?= $s['class_name'] ?? '-' ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?= base_url('kepala/santri/detail/' . $s['id']) ?>" class="text-emerald-600 hover:underline text-xs font-medium">Lihat Perkembangan</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Communication Note -->
        <div class="bg-slate-50 rounded-2xl p-6 border border-dashed border-slate-200 text-center">
            <i data-lucide="message-square" class="w-8 h-8 text-slate-300 mx-auto mb-3"></i>
            <h6 class="text-sm font-bold text-slate-600">Hubungi Wali Santri</h6>
            <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto italic">Gunakan email yang terdaftar untuk koordinasi terkait perkembangan atau administrasi santri.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
