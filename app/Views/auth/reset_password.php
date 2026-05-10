<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIPERSAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="lock" class="w-8 h-8 text-green-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Buat Password Baru</h1>
            <p class="text-slate-500 mt-2 text-sm">
                Untuk akun: <strong class="text-slate-700"><?= esc($email) ?></strong>
            </p>
        </div>

        <!-- Flash / Validation Error -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="<?= base_url('auth/reset-password/process') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>">

            <!-- Password Baru -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required minlength="8"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none pr-12"
                           placeholder="Minimal 8 karakter">
                    <button type="button" onclick="togglePass('password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <i data-lucide="eye" class="w-5 h-5" id="eye-password"></i>
                    </button>
                </div>
                <!-- Strength indicator -->
                <div class="mt-2 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div id="strength-bar" class="h-full w-0 transition-all duration-300 rounded-full bg-red-400"></div>
                </div>
                <p id="strength-text" class="text-xs text-slate-400 mt-1"></p>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirm" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirm" id="password_confirm" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none pr-12"
                           placeholder="Ulangi password baru">
                    <button type="button" onclick="togglePass('password_confirm')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <i data-lucide="eye" class="w-5 h-5" id="eye-password_confirm"></i>
                    </button>
                </div>
                <p id="match-msg" class="text-xs mt-1"></p>
            </div>

            <button type="submit" id="submit-btn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-200 focus:ring-4 focus:ring-blue-100">
                Simpan Password Baru
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
            &copy; <?= date('Y') ?> SIPERSAN - Sistem Informasi Perkembangan Santri
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Toggle show/hide password
        function togglePass(fieldId) {
            const input = document.getElementById(fieldId);
            const icon  = document.getElementById('eye-' + fieldId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const val     = this.value;
            const bar     = document.getElementById('strength-bar');
            const text    = document.getElementById('strength-text');
            let strength  = 0;
            if (val.length >= 8)  strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const levels = [
                { pct: '25%', color: 'bg-red-400',    label: 'Lemah' },
                { pct: '50%', color: 'bg-orange-400',  label: 'Cukup' },
                { pct: '75%', color: 'bg-yellow-400',  label: 'Baik' },
                { pct: '100%',color: 'bg-green-500',   label: 'Kuat' },
            ];
            if (val.length === 0) { bar.style.width = '0'; text.textContent = ''; return; }
            const lvl  = levels[Math.min(strength - 1, 3)] || levels[0];
            bar.style.width = lvl.pct;
            bar.className   = `h-full transition-all duration-300 rounded-full ${lvl.color}`;
            text.textContent = 'Kekuatan password: ' + lvl.label;
        });

        // Confirm password match
        document.getElementById('password_confirm').addEventListener('input', function() {
            const pass  = document.getElementById('password').value;
            const msg   = document.getElementById('match-msg');
            if (this.value === '') { msg.textContent = ''; return; }
            if (this.value === pass) {
                msg.textContent = '✓ Password cocok';
                msg.className   = 'text-xs mt-1 text-green-600';
            } else {
                msg.textContent = '✗ Password tidak cocok';
                msg.className   = 'text-xs mt-1 text-red-500';
            }
        });
    </script>
</body>
</html>
