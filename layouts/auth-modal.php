<div id="guruAuthModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50 px-4">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-sm sm:max-w-md transform scale-95 transition-all duration-300 ease-out">

    <!-- Header Modal -->
    <div class="relative mb-6 border-b border-gray-300 dark:border-gray-600 pb-2">
      <h2 id="modalTitle" class="text-xl sm:text-2xl font-bold text-center text-gray-800 dark:text-white">
        Login Guru
      </h2>
      <button onclick="closeGuruModal()"
        class="absolute top-0 right-0 text-gray-500 hover:text-red-500 text-xl px-2 py-1 transition"
        aria-label="Tutup Modal">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>

    <!-- Form Login -->
    <form id="loginForm" method="POST" action="layouts/login_guru.php" class="space-y-4">
      <div>
        <label class="block text-sm mb-1">Username</label>
        <input type="text" name="username" required placeholder="Masukkan Username"
          class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary" />
      </div>
      <div>
        <label class="block text-sm mb-1">Password</label>
        <div class="relative">
          <input type="password" name="password" id="loginPassword" required placeholder="Masukan Password"
            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
          <button type="button" onclick="togglePassword('loginPassword', this)"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>
      <div class="text-center">
        <button type="submit"
          class="bg-primary hover:bg-blue-800 text-white px-6 py-2 rounded-lg font-semibold transition">
          <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </button>
      </div>
      <p class="text-sm text-center mt-2 text-gray-600 dark:text-gray-400">
        Belum punya akun?
        <button type="button" onclick="showRegister()" class="text-primary hover:underline">
          Daftar di sini
        </button>
      </p>
      <p class="text-sm text-center mt-4">
        <a href="./reset_password.php" class="text-blue-600 hover:underline" target="_blank">Lupa Password?</a>
      </p>
    </form>

    <!-- Form Register -->
    <form id="registerForm" method="POST" action="layouts/register_guru.php" class="space-y-4 hidden">
      <div>
        <label class="block text-sm mb-1">Username</label>
        <input type="text" name="username" required placeholder="Masukkan username"
          class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
      </div>
      <div>
        <label class="block text-sm mb-1">Password</label>
        <div class="relative">
          <input type="password" name="password" id="registerPassword" required placeholder="Masukkan password"
            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
          <button type="button" onclick="togglePassword('registerPassword', this)"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>
      <div>
        <label class="block text-sm mb-1">Konfirmasi Password</label>
        <div class="relative">
          <input type="password" name="password_confirmation" id="confirmPassword" required placeholder="Ulangi password"
            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
          <button type="button" onclick="togglePassword('confirmPassword', this)"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>
      <div class="text-center">
        <button type="submit"
          class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
          <i class="bi bi-person-plus-fill me-1"></i> Register
        </button>
      </div>
      <p class="text-sm text-center mt-2 text-gray-600 dark:text-gray-400">
        Sudah punya akun?
        <button type="button" onclick="showLogin()" class="text-primary hover:underline">
          Login di sini
        </button>
      </p>
    </form>
  </div>
</div>

<!-- Modal Script -->
<script>
  function openGuruModal() {
    document.getElementById('guruAuthModal').classList.remove('hidden');
    showLogin(); // Default tampilan: login
  }

  function closeGuruModal() {
    document.getElementById('guruAuthModal').classList.add('hidden');
  }

  function showLogin() {
    document.getElementById('loginForm').classList.remove('hidden');
    document.getElementById('registerForm').classList.add('hidden');
    document.getElementById('modalTitle').innerText = 'Login Guru';
  }

  function showRegister() {
    document.getElementById('loginForm').classList.add('hidden');
    document.getElementById('registerForm').classList.remove('hidden');
    document.getElementById('modalTitle').innerText = 'Register Guru';
  }

  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
    } else {
      input.type = "password";
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
    }
  }
</script>