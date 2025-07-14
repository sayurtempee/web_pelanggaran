<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password Guru</title>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#205A3E',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center px-4 py-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-sm sm:max-w-md shadow-lg max-h-screen overflow-auto">

        <!-- Toggle Dark Mode -->
        <div class="flex items-center gap-2 mb-4">
            <i class="bi bi-brightness-high text-yellow-500 dark:hidden"></i>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="darkModeToggle" class="sr-only">
                <div
                    class="w-11 h-6 bg-gray-300 rounded-full dark:bg-gray-700 peer-checked:bg-primary peer peer-focus:ring-2 peer-focus:ring-primary transition-all"></div>
                <div
                    class="absolute left-1 top-1 bg-white dark:bg-gray-200 w-4 h-4 rounded-full transition-transform peer-checked:translate-x-full">
                </div>
            </label>
            <i class="bi bi-moon-stars text-white hidden dark:inline-block"></i>
        </div>

        <!-- Judul -->
        <h2 class="text-xl font-semibold text-center text-gray-800 dark:text-white mb-4">Reset Password</h2>

        <!-- Notifikasi -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-100 p-2 mb-3 rounded text-sm">
                <?= $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-100 p-2 mb-3 rounded text-sm">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="layouts/forgot-password.php" method="POST" class="space-y-4">
            <!-- Username -->
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Username</label>
                <input type="text" name="username" required placeholder="Masukkan username"
                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-primary" />
            </div>

            <!-- Password -->
            <div class="relative">
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Password Baru</label>
                <input type="password" name="password" id="password" required placeholder="Password baru"
                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg px-4 py-2 pr-10 focus:outline-none focus:ring-1 focus:ring-primary" />
                <button type="button" onclick="togglePassword('password')"
                    class="absolute top-[34px] right-3 text-gray-500 hover:text-gray-700 dark:hover:text-white"
                    aria-label="Tampilkan Password">
                    <i class="bi bi-eye" id="toggle-password"></i>
                </button>
            </div>

            <!-- Konfirmasi Password -->
            <div class="relative">
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirm" required placeholder="Ulangi password baru"
                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg px-4 py-2 pr-10 focus:outline-none focus:ring-1 focus:ring-primary" />
                <button type="button" onclick="togglePassword('password_confirm')"
                    class="absolute top-[34px] right-3 text-gray-500 hover:text-gray-700 dark:hover:text-white"
                    aria-label="Tampilkan Konfirmasi Password">
                    <i class="bi bi-eye" id="toggle-password_confirm"></i>
                </button>
            </div>

            <!-- Tombol Submit -->
            <button type="submit"
                class="w-full bg-primary hover:bg-green-700 text-white py-2 px-4 rounded-lg transition font-semibold">
                Reset
            </button>
        </form>

        <!-- Kembali -->
        <p class="text-sm text-center mt-4 text-gray-500 dark:text-gray-400">
            <a href="index.php" class="hover:underline">← Kembali ke Login</a>
        </p>
    </div>

    <!-- Script: Toggle Dark Mode -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('darkModeToggle');
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
                toggle.checked = true;
            }
            toggle.addEventListener('change', function() {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', this.checked ? 'dark' : 'light');
            });
        });
    </script>

    <!-- Script: Toggle Password Visibility -->
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById('toggle-' + id);
            const isPassword = input.type === "password";

            input.type = isPassword ? "text" : "password";
            icon.classList.toggle("bi-eye", !isPassword);
            icon.classList.toggle("bi-eye-slash", isPassword);
        }
    </script>
</body>

</html>