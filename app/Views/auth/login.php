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
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                    placeholder="••••••••">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-200 focus:ring-4 focus:ring-blue-100">
                Masuk
            </button>

            <div class="text-center">
                <a href="<?= base_url('auth/forgot-password') ?>" class="text-sm text-blue-600 hover:underline font-medium">
                    Lupa Password?
                </a>
            </div>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
            &copy; <?= date('Y') ?> SIPERSAN - Sistem Informasi Perkembangan Santri
        </div>
    </div>
</body>
</html>
