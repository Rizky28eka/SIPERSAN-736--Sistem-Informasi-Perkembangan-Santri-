<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIPERSAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 0.5px, transparent 0.5px), radial-gradient(#cbd5e1 0.5px, #f8fafc 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }
    </style>
</head>
<body class="bg-pattern min-h-screen flex items-center justify-center p-6">
    <div class="max-w-5xl w-full grid grid-cols-1 lg:grid-cols-2 bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/10 overflow-hidden border border-slate-100">
        
        <!-- Sisi Kiri: Visual -->
        <div class="hidden lg:flex flex-col justify-between p-12 bg-gradient-to-br from-blue-700 to-indigo-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-600 mix-blend-multiply opacity-20"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-400/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight uppercase">Sipersan</span>
                </div>
                
                <h2 class="text-4xl font-extrabold leading-tight mb-6">
                    Membimbing Masa Depan,<br>
                    <span class="text-blue-200">Mencatat Kebaikan.</span>
                </h2>
                <p class="text-blue-100/80 text-lg leading-relaxed max-w-sm">
                    Platform terpadu untuk memantau perkembangan akademik dan akhlak santri secara real-time.
                </p>
            </div>

            <div class="relative z-10 bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-3xl">
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full border-2 border-blue-600 bg-slate-200"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-blue-600 bg-slate-300"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-blue-600 bg-slate-400"></div>
                    </div>
                    <p class="text-sm font-medium text-blue-50 italic">
                        "Terima kasih SIPERSAN, laporan harian ananda sangat membantu kami di rumah."
                    </p>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form -->
        <div class="p-8 lg:p-16 flex flex-col justify-center">
            <div class="mb-10">
                <h1 class="text-3xl font-black text-slate-800 mb-2">Selamat Datang</h1>
                <p class="text-slate-500 font-medium">Silakan masuk ke akun Anda</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-8 flex items-center gap-3 animate-pulse">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <p class="text-sm font-bold"><?= session()->getFlashdata('error') ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>
                
                <div class="space-y-2">
                    <label for="login" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Username / Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <input type="text" name="login" id="login" required
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none text-slate-700 font-bold"
                            placeholder="username anda">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-end px-1">
                        <label for="password" class="text-xs font-black text-slate-400 uppercase tracking-widest">Password</label>
                        <a href="<?= base_url('auth/forgot-password') ?>" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">Lupa Password?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-12 pr-12 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none text-slate-700 font-bold"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <i id="eyeIcon" data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl transition-all shadow-xl shadow-blue-500/30 flex items-center justify-center gap-3 active:scale-[0.98]">
                        Masuk Sekarang
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </form>

            <div class="mt-12 pt-8 border-t border-slate-100 text-center">
                <p class="text-slate-400 text-sm font-medium">
                    &copy; <?= date('Y') ?> <span class="font-bold text-slate-600">SIPERSAN</span> v2.0
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>
