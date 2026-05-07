<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPERSAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">SIPERSAN</h1>
            <p class="text-slate-500 mt-2">Sistem Informasi Perkembangan Santri</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/login') ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>
            <div>
                <label for="login" class="block text-sm font-medium text-slate-700 mb-2">Username or Email</label>
                <input type="text" name="login" id="login" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                    placeholder="Enter your username or email">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none pr-12"
                        placeholder="••••••••">
                    <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.483 8.65 7.41 5.8 12 5.8s8.517 2.85 9.964 6.522a1.012 1.012 0 0 1 0 .644C20.517 15.35 16.59 18.2 12 18.2s-8.517-2.85-9.964-6.522Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-200 focus:ring-4 focus:ring-blue-100">
                Sign In
            </button>
        </form>

        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');
            const eyeOffIcon = document.querySelector('#eyeOffIcon');

            togglePassword.addEventListener('click', () => {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                eyeIcon.classList.toggle('hidden');
                eyeOffIcon.classList.toggle('hidden');
            });
        </script>

        <div class="mt-8 text-center text-sm text-slate-400">
            &copy; <?= date('Y') ?> SIPERSAN - Sistem Informasi Perkembangan Santri
        </div>
    </div>
</body>
</html>
