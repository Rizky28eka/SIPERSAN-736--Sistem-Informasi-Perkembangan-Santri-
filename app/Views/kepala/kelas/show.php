<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-3">
        <a href="<?= base_url('kepala/kelas') ?>" class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-500">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Detail Kelas: <?= $class['name'] ?></h3>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('kepala/kelas/edit/' . $class['id']) ?>" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl hover:bg-blue-100 transition-all text-sm font-medium flex items-center space-x-2">
            <i data-lucide="edit-2" class="w-4 h-4"></i>
            <span>Edit Kelas</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Class Info Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Kelas</h5>
            
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Nama Kelas</label>
                    <p class="text-lg font-bold text-slate-800"><?= $class['name'] ?></p>
                </div>
                
                <div class="pt-4 border-t border-slate-50">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Wali Kelas</label>
                    <div class="flex items-center space-x-3 bg-slate-50 p-3 rounded-xl">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            <?= substr($class['teacher_name'] ?? '?', 0, 1) ?>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-700"><?= $class['teacher_name'] ?? 'Belum ditentukan' ?></p>
                            <p class="text-[10px] text-slate-400">@<?= $class['teacher_username'] ?? '-' ?></p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-50">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Total Santri</span>
                        <span class="font-bold text-slate-800"><?= count($santris) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions or Summary -->
        <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-100">
            <h6 class="text-xs font-bold opacity-70 uppercase tracking-widest mb-4">Ringkasan Kehadiran</h6>
            <div class="text-3xl font-bold mb-1">94%</div>
            <p class="text-[10px] opacity-80 leading-relaxed">Rata-rata kehadiran seluruh santri di kelas ini pada bulan ini.</p>
        </div>
    </div>

    <!-- Student List Table -->
    <div class="lg:col-span-3 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                <h5 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                    <i data-lucide="users" class="w-4 h-4 text-blue-500"></i>
                    <span>Daftar Santri di Kelas Ini</span>
                </h5>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= count($santris) ?> Santri</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-6 py-3 w-16 text-center">No</th>
                            <th class="px-6 py-3">Nama Santri</th>
                            <th class="px-6 py-3">NISN</th>
                            <th class="px-6 py-3">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($santris)) : ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic">Belum ada santri yang terdaftar di kelas ini.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($santris as $index => $s) : ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 text-center text-slate-500"><?= $index + 1 ?></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold text-[10px]">
                                                <?= substr($s['name'], 0, 1) ?>
                                            </div>
                                            <span class="font-medium text-slate-700"><?= $s['name'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600"><?= $s['nisn'] ?></td>
                                    <td class="px-6 py-4">
                                        <?php if ($s['gender'] == 'L') : ?>
                                            <span class="text-[10px] bg-blue-50 text-blue-500 px-2 py-0.5 rounded-full font-bold">LAKI-LAKI</span>
                                        <?php else : ?>
                                            <span class="text-[10px] bg-pink-50 text-pink-500 px-2 py-0.5 rounded-full font-bold">PEREMPUAN</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?= base_url('kepala/santri/detail/' . $s['id']) ?>" class="text-indigo-600 hover:underline text-xs font-medium">Detail Santri</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
