<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIPERSAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="key" class="w-8 h-8 text-blue-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Lupa Password?</h1>
            <p class="text-slate-500 mt-2 text-sm">Masukkan email terdaftar Anda. Kami akan mengirimkan link untuk reset password.</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-start gap-2">
                <i data-lucide="check-circle" class="w-4 h-4 mt-0.5 flex-shrink-0"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="<?= base_url('auth/forgot-password/send') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                       placeholder="nama@email.com"
                       value="<?= old('email') ?>">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-200 focus:ring-4 focus:ring-blue-100">
                Kirim Link Reset Password
            </button>
        </form>

        <!-- Back to Login -->
        <div class="mt-6 text-center">
            <a href="<?= base_url('/auth') ?>" class="text-sm text-blue-600 hover:underline font-medium flex items-center justify-center gap-1">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke halaman login
            </a>
        </div>

        <div class="mt-8 text-center text-sm text-slate-400">
            &copy; <?= date('Y') ?> SIPERSAN - Sistem Informasi Perkembangan Santri
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
