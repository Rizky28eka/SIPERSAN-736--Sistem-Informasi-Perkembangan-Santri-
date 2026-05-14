<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - SIPERSAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Pusher JS untuk notifikasi realtime -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        /* Animasi badge notifikasi */
        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
        .badge-pulse { animation: pulse-badge 2s ease-in-out infinite; }
        /* Sidebar active indicator */
        .nav-active {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #2563eb;
            font-weight: 600;
            border-left: 3px solid #2563eb;
        }
        .nav-active i { color: #2563eb; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">

        <!-- ═══ SIDEBAR ═══════════════════════════════════════════════════════ -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col sticky top-0 h-screen shadow-sm">
            <!-- Logo -->
            <div class="p-6 border-b border-slate-100">
                <h1 class="text-xl font-bold text-blue-600 tracking-tight">SIPERSAN</h1>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold mt-1">Management System</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <?php $role = session()->get('role'); ?>

                <!-- Dashboard (semua role) -->
                <?php
                $isDashboard = url_is($role . '/dashboard');
                $dashClass   = $isDashboard ? 'nav-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700';
                ?>
                <a href="<?= base_url($role . '/dashboard') ?>"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?= $dashClass ?>">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>

                <!-- ══ MENU KEPALA ══════════════════════════════════════════ -->
                <?php if ($role === 'kepala') : ?>
                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Master Data</div>

                    <?php
                    $links = [
                        ['url' => 'kepala/santri',      'icon' => 'users',       'label' => 'Data Santri'],
                        ['url' => 'kepala/guru',        'icon' => 'user-cog',    'label' => 'Data Guru'],
                        ['url' => 'kepala/kelas',       'icon' => 'door-open',   'label' => 'Data Kelas'],
                        ['url' => 'kepala/wali',        'icon' => 'contact-2',   'label' => 'Data Wali'],
                        ['url' => 'kepala/master-spp',  'icon' => 'settings-2',  'label' => 'Master SPP'],
                    ];
                    foreach ($links as $link) :
                        $isActive = url_is($link['url']) || url_is($link['url'] . '/*');
                        $cls = $isActive ? 'nav-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700';
                    ?>
                        <a href="<?= base_url($link['url']) ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?= $cls ?>">
                            <i data-lucide="<?= $link['icon'] ?>" class="w-5 h-5"></i>
                            <span><?= $link['label'] ?></span>
                        </a>
                    <?php endforeach; ?>

                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Laporan</div>

                    <?php
                    $laporanLinks = [
                        ['url' => 'kepala/nilai',  'icon' => 'file-text',  'label' => 'Rekap Nilai'],
                        ['url' => 'kepala/spp',    'icon' => 'credit-card','label' => 'Rekap SPP'],
                    ];
                    foreach ($laporanLinks as $link) :
                        $isActive = url_is($link['url']);
                        $cls = $isActive ? 'nav-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700';
                    ?>
                        <a href="<?= base_url($link['url']) ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?= $cls ?>">
                            <i data-lucide="<?= $link['icon'] ?>" class="w-5 h-5"></i>
                            <span><?= $link['label'] ?></span>
                        </a>
                    <?php endforeach; ?>

                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sistem</div>
                    <?php
                    $annActive = url_is('kepala/announcements') || url_is('kepala/announcements/*');
                    $annCls    = $annActive ? 'nav-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700';
                    ?>
                    <a href="<?= base_url('kepala/announcements') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?= $annCls ?>">
                        <i data-lucide="megaphone" class="w-5 h-5"></i>
                        <span>Kelola Pengumuman</span>
                    </a>
                <?php endif; ?>

                <!-- ══ MENU GURU ════════════════════════════════════════════ -->
                <?php if ($role === 'guru') : ?>
                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Penilaian</div>

                    <?php
                    $guruLinks = [
                        ['url' => 'guru/input-nilai',    'match' => ['guru/input-nilai', 'guru/nilai/*'], 'icon' => 'edit-3',         'label' => 'Evaluasi Raport'],
                        ['url' => 'guru/perkembangan',   'match' => ['guru/perkembangan', 'guru/perkembangan/*'], 'icon' => 'line-chart', 'label' => 'Catatan Harian'],
                        ['url' => 'guru/absensi',        'match' => ['guru/absensi', 'guru/absensi/*'],   'icon' => 'calendar-check', 'label' => 'Absensi'],
                        ['url' => 'guru/tahfidz',        'match' => ['guru/tahfidz', 'guru/tahfidz/*'],   'icon' => 'book-marked',    'label' => 'Tahfidz'],
                    ];
                    foreach ($guruLinks as $link) :
                        $isActive = false;
                        foreach ($link['match'] as $m) { if (url_is($m)) { $isActive = true; break; } }
                        $cls = $isActive ? 'nav-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700';
                    ?>
                        <a href="<?= base_url($link['url']) ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?= $cls ?>">
                            <i data-lucide="<?= $link['icon'] ?>" class="w-5 h-5"></i>
                            <span><?= $link['label'] ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- ══ MENU WALI ════════════════════════════════════════════ -->
                <?php if ($role === 'wali') : ?>
                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Info Anak</div>

                    <?php
                    $waliLinks = [
                        ['url' => 'wali/raport', 'match' => ['wali/raport', 'wali/raport/*'], 'icon' => 'book-open',  'label' => 'Lihat Raport'],
                        ['url' => 'wali/perkembangan', 'match' => ['wali/perkembangan', 'wali/perkembangan/*'], 'icon' => 'line-chart', 'label' => 'Catatan Harian'],
                        ['url' => 'wali/spp',    'match' => ['wali/spp', 'wali/spp/*'],       'icon' => 'credit-card','label' => 'Pembayaran SPP'],
                    ];
                    foreach ($waliLinks as $link) :
                        $isActive = false;
                        foreach ($link['match'] as $m) { if (url_is($m)) { $isActive = true; break; } }
                        $cls = $isActive ? 'nav-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700';
                    ?>
                        <a href="<?= base_url($link['url']) ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?= $cls ?>">
                            <i data-lucide="<?= $link['icon'] ?>" class="w-5 h-5"></i>
                            <span><?= $link['label'] ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if ($role !== 'kepala') : ?>
                    <!-- ══ PENGUMUMAN (guru & wali) ════════════════════════════ -->
                    <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Informasi</div>
                    <?php
                    $annGlobalActive = url_is('announcements');
                    $annGlobalCls    = $annGlobalActive ? 'nav-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700';
                    ?>
                    <a href="<?= base_url('announcements') ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?= $annGlobalCls ?>">
                        <i data-lucide="megaphone" class="w-5 h-5"></i>
                        <span>Pengumuman</span>
                    </a>
                <?php endif; ?>

            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-slate-100">
                <a href="<?= base_url('auth/logout') ?>"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </div>
        </aside>

        <!-- ═══ MAIN CONTENT ══════════════════════════════════════════════════ -->
        <main class="flex-1 flex flex-col min-w-0">

            <!-- Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-10 shadow-sm">
                <!-- Judul halaman -->
                <div>
                    <h2 class="text-lg font-semibold text-slate-700"><?= $title ?? 'Dashboard' ?></h2>
                </div>

                <!-- Kanan header: notifikasi + user info -->
                <div class="flex items-center space-x-4">

                    <!-- Bell Notifikasi -->
                    <div class="relative" id="notif-wrapper">
                        <button id="notif-btn"
                                onclick="toggleNotifPanel()"
                                class="relative p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all focus:outline-none">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <!-- Badge counter -->
                            <span id="notif-badge"
                                  class="badge-pulse absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 hidden">
                                0
                            </span>
                        </button>

                        <!-- Dropdown Notifikasi -->
                        <div id="notif-panel"
                             class="hidden absolute right-0 top-12 w-80 bg-white rounded-2xl shadow-xl shadow-slate-200/80 border border-slate-100 z-50 overflow-hidden">
                            <div class="flex items-center justify-between p-4 border-b border-slate-100">
                                <span class="font-semibold text-slate-700">Notifikasi</span>
                                <button onclick="markAllRead()"
                                        class="text-xs text-blue-600 hover:underline font-medium">
                                    Tandai semua dibaca
                                </button>
                            </div>
                            <div id="notif-list" class="max-h-64 overflow-y-auto p-2">
                                <p class="text-sm text-slate-400 text-center py-4">Memuat notifikasi...</p>
                            </div>
                            <div class="p-3 border-t border-slate-100 text-center">
                                <a href="<?= base_url('announcements') ?>" class="text-sm text-blue-600 hover:underline font-medium">
                                    Lihat semua pengumuman →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-slate-700 leading-none"><?= esc(session()->get('name')) ?></p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mt-1 font-bold"><?= esc(session()->get('role')) ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center text-blue-600 font-bold text-sm">
                        <?= esc(strtoupper(substr(session()->get('name'), 0, 1))) ?>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="mx-8 mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="mx-8 mt-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <div class="p-8 flex-1">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <script>
        // ── Lucide Icons ──────────────────────────────────────────────────────
        lucide.createIcons();

        // ── Notifikasi System ─────────────────────────────────────────────────
        const pusherKey     = '<?= getenv('PUSHER_APP_KEY') ?>';
        const pusherCluster = '<?= getenv('PUSHER_APP_CLUSTER') ?: 'ap1' ?>';

        // Init Pusher jika key tersedia
        if (pusherKey && pusherKey !== 'your_app_key') {
            const pusher  = new Pusher(pusherKey, { cluster: pusherCluster });
            const channel = pusher.subscribe('announcements');

            // Event saat ada pengumuman baru
            channel.bind('new-announcement', function(data) {
                fetchNotifCount();
                showToast('Pengumuman Baru', data.title || 'Ada pengumuman baru!');
            });
        }

        // Fetch jumlah notifikasi belum dibaca dari server
        function fetchNotifCount() {
            fetch('<?= base_url('api/notifications/count') ?>')
                .then(r => r.json())
                .then(data => {
                    const badge = document.getElementById('notif-badge');
                    if (data.count > 0) {
                        badge.textContent = data.count > 99 ? '99+' : data.count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                })
                .catch(() => {});
        }

        // Tandai semua sudah dibaca
        function markAllRead() {
            fetch('<?= base_url('api/notifications/mark-read') ?>', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json' },
                body: JSON.stringify({ '<?= csrf_token() ?>': '<?= csrf_hash() ?>' })
            })
            .then(() => {
                fetchNotifCount();
                document.getElementById('notif-badge').classList.add('hidden');
            });
        }

        // Toggle panel notifikasi
        function toggleNotifPanel() {
            const panel = document.getElementById('notif-panel');
            panel.classList.toggle('hidden');
        }

        // Tutup panel jika klik di luar
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('notif-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                document.getElementById('notif-panel').classList.add('hidden');
            }
        });

        // Toast notification
        function showToast(title, message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-6 right-6 bg-blue-600 text-white px-5 py-4 rounded-2xl shadow-2xl z-50 max-w-xs transition-all';
            toast.innerHTML = `
                <div class="font-semibold text-sm">${title}</div>
                <div class="text-xs opacity-90 mt-1">${message}</div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 4000);
        }

        // ── Password Visibility Toggle ──────────────────────────────────────────
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<i data-lucide="eye-off" class="w-4 h-4"></i>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<i data-lucide="eye" class="w-4 h-4"></i>';
            }
            lucide.createIcons();
        }

        // Jalankan polling pertama kali saat halaman dimuat
        fetchNotifCount();

        // Polling setiap 60 detik sebagai fallback
        setInterval(fetchNotifCount, 60000);
    </script>
</body>
</html>
