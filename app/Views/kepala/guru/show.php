<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-3">
        <a href="<?= base_url('kepala/guru') ?>" class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-500">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h3 class="text-xl font-bold text-slate-800">Profil Pengajar</h3>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('kepala/guru/edit/' . $guru['id']) ?>" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl hover:bg-blue-100 transition-all text-sm font-medium flex items-center space-x-2">
            <i data-lucide="edit-2" class="w-4 h-4"></i>
            <span>Edit Profil</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Guru Profile -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center">
            <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-3xl mx-auto mb-4 border-4 border-white shadow-lg shadow-indigo-100">
                <?= substr($guru['name'], 0, 1) ?>
            </div>
            <h4 class="text-lg font-bold text-slate-800"><?= $guru['name'] ?></h4>
            <p class="text-slate-500 text-sm mb-4">@<?= $guru['username'] ?></p>
            
            <div class="flex justify-center mb-6">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-semibold uppercase tracking-wider">
                    Pengajar / Guru
                </span>
            </div>

            <div class="space-y-4 text-left border-t border-slate-50 pt-6">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Email</label>
                    <p class="text-sm text-slate-700 font-medium"><?= $guru['email'] ?? '-' ?></p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Status Kepegawaian</label>
                    <p class="text-sm text-emerald-600 font-bold">Aktif</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Tanggal Bergabung</label>
                    <p class="text-sm text-slate-600"><?= date('d F Y', strtotime($guru['created_at'])) ?></p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h5 class="text-sm font-bold text-slate-800 mb-4 flex items-center space-x-2">
                <i data-lucide="bar-chart-3" class="w-4 h-4 text-indigo-600"></i>
                <span>Ringkasan Kinerja</span>
            </h5>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                    <span class="text-xs text-slate-500">Total Kelas Diampu</span>
                    <span class="text-sm font-bold text-slate-800"><?= count($classes) ?></span>
                </div>
                <?php 
                $totalSantri = array_sum(array_column($classes, 'total_santri'));
                ?>
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                    <span class="text-xs text-slate-500">Total Santri Diajar</span>
                    <span class="text-sm font-bold text-slate-800"><?= $totalSantri ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Classes Managed -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50">
                <h5 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                    <i data-lucide="layers" class="w-4 h-4 text-indigo-500"></i>
                    <span>Daftar Kelas yang Diampu</span>
                </h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-6 py-3">Nama Kelas</th>
                            <th class="px-6 py-3 text-center">Jumlah Santri</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($classes)) : ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 italic">Belum ada kelas yang ditugaskan kepada pengajar ini.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($classes as $c) : ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-700"><?= $c['name'] ?></td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-600"><?= $c['total_santri'] ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-md text-[10px] font-bold uppercase">Aktif</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?= base_url('kepala/kelas/edit/' . $c['id']) ?>" class="text-indigo-600 hover:underline text-xs font-medium">Kelola Kelas</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Activity Feed (Placeholder) -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h5 class="text-sm font-bold text-slate-800 mb-4 flex items-center space-x-2">
                <i data-lucide="history" class="w-4 h-4 text-slate-400"></i>
                <span>Aktivitas Terbaru</span>
            </h5>
            <div class="space-y-4">
                <div class="flex space-x-3">
                    <div class="w-2 bg-emerald-400 rounded-full"></div>
                    <div>
                        <p class="text-xs font-medium text-slate-700">Berhasil menginput nilai bulanan untuk Kelas Tahfidz A</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">2 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <div class="w-2 bg-blue-400 rounded-full"></div>
                    <div>
                        <p class="text-xs font-medium text-slate-700">Melakukan absensi harian untuk Kelas Bahasa Arab 1</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Hari ini, 08:30</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
