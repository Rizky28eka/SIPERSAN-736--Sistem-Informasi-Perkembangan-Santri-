<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - SIPERSAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col sticky top-0 h-screen">
            <div class="p-6 border-b border-slate-100">
                <h1 class="text-xl font-bold text-blue-600 tracking-tight">SIPERSAN</h1>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold mt-1">Management System</p>
            </div>
            
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <?php $role = session()->get('role'); ?>
                
                <a href="<?= base_url($role . '/dashboard') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?= url_is($role . '/dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' ?>">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>

                <?php if ($role === 'kepala') : ?>
                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Master Data</div>
                    <a href="<?= base_url('kepala/santri') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Data Santri</span>
                    </a>
                    <a href="<?= base_url('kepala/guru') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                        <i data-lucide="user-cog" class="w-5 h-5"></i>
                        <span>Data Guru</span>
                    </a>
                    <a href="<?= base_url('kepala/kelas') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                        <i data-lucide="door-open" class="w-5 h-5"></i>
                        <span>Data Kelas</span>
                    </a>
                    <a href="<?= base_url('kepala/wali') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                        <i data-lucide="contact-2" class="w-5 h-5"></i>
                        <span>Data Wali</span>
                    </a>
                    
                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Laporan</div>
                    <a href="<?= base_url('kepala/nilai') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                        <span>Rekap Nilai</span>
                    </a>
                <?php endif; ?>

                <?php if ($role === 'guru') : ?>
                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Penilaian</div>
                    <a href="<?= base_url('guru/input-nilai') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                        <span>Input Nilai</span>
                    </a>
                    <a href="<?= base_url('guru/absensi') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                        <i data-lucide="calendar-check" class="w-5 h-5"></i>
                        <span>Absensi</span>
                    </a>
                <?php endif; ?>

                <?php if ($role === 'wali') : ?>
                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Info Anak</div>
                    <a href="<?= base_url('wali/raport') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                        <span>Lihat Raport</span>
                    </a>
                <?php endif; ?>

                <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">System</div>
                <a href="<?= base_url('announcements') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                    <i data-lucide="megaphone" class="w-5 h-5"></i>
                    <span>Pengumuman</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <a href="<?= base_url('auth/logout') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-10">
                <h2 class="text-lg font-semibold text-slate-700"><?= $title ?? 'Dashboard' ?></h2>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-slate-700 leading-none"><?= session()->get('name') ?></p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mt-1 font-bold"><?= session()->get('role') ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center text-blue-600 font-bold">
                        <?= substr(session()->get('name'), 0, 1) ?>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
