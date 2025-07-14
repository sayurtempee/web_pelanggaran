<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Pelanggaran Siswa | SMK Negeri 71 Jakarta</title>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- SweetAlert2 -->
  <?php session_start(); ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Flatpickr CSS & JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

  <!-- FavIcon -->
  <link rel="icon" type="image/png" href="img/logo71.png">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#0070BB',
            secondary: '#3DB8F5'
          }
        }
      }
    }
  </script>
  <style>
    html.dark .ts-wrapper,
    html.dark .ts-control,
    html.dark .ts-dropdown,
    html.dark .ts-control input,
    html.dark .ts-dropdown .ts-dropdown-content {
      background-color: #1f2937 !important;
      color: #ffffff !important;
      border-color: #4b5563 !important;
    }

    html.dark .ts-dropdown .active {
      background-color: #374151 !important;
      color: #fff !important;
    }

    html.dark .item {
      background-color: #2563eb !important;
      color: white !important;
      border-radius: 0.375rem;
    }

    html.dark .ts-wrapper.single.input-active .ts-control {
      background-color: #1f2937 !important;
    }

    .ts-wrapper.multi .ts-control>input {
      display: none !important;
    }

    .ts-wrapper.multi .ts-control {
      padding: 0.5rem 0.75rem !important;
      min-height: 2.5rem;
      border: none;
      box-shadow: none;
      background: transparent;
    }

    .ts-wrapper.multi .ts-control::before {
      content: none !important;
    }

    .ts-wrapper.multi .ts-control input:focus {
      outline: none !important;
      box-shadow: none !important;
    }

    .ts-wrapper.plugin-remove_button .item {
      border: none !important;
      box-shadow: none !important;
    }

    @media (max-width: 640px) {

      .responsive-table td,
      .responsive-table th {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
      }

      .responsive-form {
        padding-left: 1rem;
        padding-right: 1rem;
      }

      .responsive-logo {
        height: auto;
        max-height: 120px;
      }
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
</head>

<body class="bg-gray-200 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen px-4 sm:px-6 lg:px-8 py-6">
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_start();
    $successMessage = 'Anda berhasil logout.';

    $_SESSION = [];
    session_destroy();

    session_start();
    $_SESSION['success'] = $successMessage;

    header("Location: index.php");
    exit;
  }
  ?>

  <!-- sweat alert -->
  <?php
  // Inisialisasi session jika belum
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  // Cek session success
  if (isset($_SESSION['success'])) {
    $alertType = 'success';
    $alertMessage = $_SESSION['success'];
    unset($_SESSION['success']);
  }

  // Cek session error
  elseif (isset($_SESSION['error'])) {
    $alertType = 'error';
    $alertMessage = $_SESSION['error'];
    unset($_SESSION['error']);
  }
  ?>

  <?php if (isset($alertType) && isset($alertMessage)): ?>
    <script>
      Swal.fire({
        toast: false, // tampil sebagai modal di tengah, bukan toast kecil
        icon: '<?= $alertType ?>',
        title: '<?= $alertMessage ?>',
        position: 'center',
        width: '85%',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        showClass: {
          popup: 'swal2-show animate__animated animate__fadeInDown'
        },
        hideClass: {
          popup: 'swal2-hide animate__animated animate__fadeOutUp'
        },
      });
    </script>
  <?php endif; ?>

  <!-- Floating Bubble Group -->
  <?php if (!isset($_SESSION['guru'])): ?>
    <div class="fixed bottom-4 right-4 z-50">
      <div id="floating-actions" class="flex flex-col items-end space-y-3 mb-3 opacity-0 invisible transition-all duration-300 transform translate-y-4">
        <button id="toggle-dark" class="w-12 h-12 rounded-full bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 shadow-lg flex items-center justify-center hover:scale-110 transition" title="Toggle Dark Mode">
          <i id="dark-icon" class="bi bi-moon-fill"></i>
        </button>
        <button onclick="openGuruModal()" class="w-12 h-12 rounded-full bg-blue-600 hover:bg-blue-700 text-white shadow-lg flex items-center justify-center hover:scale-110 transition" title="Login Guru">
          <i class="bi bi-person-fill-lock"></i>
        </button>
      </div>
      <button onclick="toggleFloatingActions()" class="w-14 h-14 rounded-full bg-primary hover:bg-blue-800 text-white shadow-xl flex items-center justify-center transition-all duration-300 focus:outline-none">
        <i id="toggle-menu-icon" class="bi bi-plus-lg text-xl"></i>
      </button>
    </div>
  <?php endif; ?>

  <!-- Modal login & register guru -->
  <?php include 'layouts/auth-modal.php'; ?>

  <!-- Form & Statistik -->
  <div class="max-w-6xl mx-auto grid gap-6 md:grid-cols-2 mt-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
      <?php if (isset($_SESSION['guru'])): ?>
        <form method="POST" class="text-right mb-4">
          <button type="submit" name="logout" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
      <?php endif; ?>

      <div class="flex flex-col items-center mb-6 px-4">
        <!-- Logo Sekolah -->
        <img src="img/logo71.png" alt="Logo SMKN 71 Jakarta"
          class="w-auto mb-6 transition-all duration-300
      <?php echo isset($_SESSION['guru']) ? 'h-40 sm:h-52 md:h-60' : 'h-32 sm:h-40 md:h-44'; ?>">

        <!-- Logo Jurusan -->
        <div class="flex gap-4 flex-wrap justify-center">
          <img src="img/rpl.png" alt="RPL"
            class="h-16 w-16 sm:h-20 sm:w-20 md:h-24 md:w-24 rounded object-contain transition-all duration-300">
          <img src="img/dkv.png" alt="DKV"
            class="h-16 w-16 sm:h-20 sm:w-20 md:h-24 md:w-24 rounded object-contain transition-all duration-300">
          <img src="img/anm.png" alt="Animasi"
            class="h-16 w-16 sm:h-20 sm:w-20 md:h-24 md:w-24 rounded object-contain transition-all duration-300">
        </div>
      </div>

      <?php if (!isset($_SESSION['guru'])): ?>
        <div class="text-center mb-6 sm:mb-8 px-4">
          <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-primary dark:text-white leading-snug sm:leading-normal">
            Form Pelanggaran Peserta Didik
            <br>
            <span class="block text-lg sm:text-2xl md:text-3xl font-bold text-[#005B99] dark:text-primary">
              SMK Negeri 71 Jakarta
            </span>
          </h1>
        </div>

        <form action="simpan.php" method="POST" class="space-y-5">
          <div>
            <label for="nama" class="block font-medium text-md text-gray-700 dark:text-gray-200">Nama Siswa</label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Usahakan menggunakan nama lengkap</p>
            <input type="text" id="nama" name="nama" required
              class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-lg px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"
              placeholder="Masukkan nama">
          </div>
          <div>
            <label for="kelas" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Kelas</label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Masukkan sesuai dengan kelasnya (contoh: XII RPL 2)</p>
            <select id="kelas" name="kelas" required
              class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-lg px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
              <option disabled selected>Pilih Kelas</option>

              <!-- Tingkatan X -->
              <option value="x_rpl_1">X RPL 1</option>
              <option value="x_rpl_2">X RPL 2</option>
              <option value="x_dkv_1">X DKV 1</option>
              <option value="x_dkv_2">X DKV 2</option>
              <option value="x_anm_1">X ANM 1</option>
              <option value="x_anm_2">X ANM 2</option>

              <!-- Tingkatan XI -->
              <option value="xi_rpl_1">XI RPL 1</option>
              <option value="xi_rpl_2">XI RPL 2</option>
              <option value="xi_dkv_1">XI DKV 1</option>
              <option value="xi_dkv_2">XI DKV 2</option>
              <option value="xi_anm_1">XI ANM 1</option>
              <option value="xi_anm_2">XI ANM 2</option>

              <!-- Tingkatan XII -->
              <option value="xii_rpl_1">XII RPL 1</option>
              <option value="xii_rpl_2">XII RPL 2</option>
              <option value="xii_dkv_1">XII DKV 1</option>
              <option value="xii_dkv_2">XII DKV 2</option>
              <option value="xii_anm_1">XII ANM 1</option>
              <option value="xii_anm_2">XII ANM 2</option>
            </select>
          </div>
          <div class="mt-4">
            <label for="jurusan" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Jurusan</label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Masukkan sesuai dengan jurusannya</p>
            <select id="jurusan" name="jurusan" required
              class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-lg px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
              <option disabled selected>Pilih Jurusan</option>
              <option value="rpl">Rekayasa Perangkat Lunak</option>
              <option value="dkv">Desain Komunikasi Visual</option>
              <option value="anm">Animasi</option>
            </select>
          </div>
          <div class="relative">
            <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
              Tanggal Pelanggaran
            </label>

            <input type="text" id="tanggal" name="tanggal" required
              class="w-full pl-4 pr-20 py-2 h-10 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">

            <!-- Tombol "Today" tengah vertikal -->
            <button type="button" onclick="setToday()"
              class="absolute right-1 top-1/2 -translate-y-1 h-8 w-18 px-3 text-xs font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
              title="Pilih tanggal hari ini">
              Today
            </button>
          </div>
          <div>
            <label for="pelanggaran" class="block font-medium text-md mb-1 text-gray-800 dark:text-gray-200">Melakukan Pelanggaran</label>
            <div class="relative">
              <div id="pelanggaran-placeholder"
                class="absolute left-3 top-2 text-gray-400 pointer-events-none select-none z-10">
                Pilih pelanggaran yang dilakukan...
              </div>

              <select id="pelanggaran" name="pelanggaran[]" multiple required
                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                <option value="Membolos">Bolos Sekolah</option>
                <option value="Tidak Menggunakan Almet">Tidak Menggunakan Almet</option>
                <option value="Terlambat">Datang Terlambat</option>
                <option value="Tidak Memakai Seragam">Tidak Memakai Seragam</option>
                <option value="Rambut Tidak Rapi">Rambut Tidak Rapi</option>
                <option value="Merokok">Merokok</option>
                <option value="Membawa Barang Terlarang">Membawa Barang Terlarang</option>
                <option value="Berkelahi / Tawuran">Berkelahi / Tawuran</option>
                <option value="Berkata Kasar">Berkata Kasar</option>
                <option value="Membuat Keributan di Kelas">Membuat Keributan di Kelas</option>
                <option value="Merusak Fasilitas Sekolah">Merusak Fasilitas Sekolah</option>
                <option value="Tidak Mengerjakan Tugas">Tidak Mengerjakan Tugas</option>
                <option value="Keluyuran Saat Jam Pelajaran">Keluyuran Saat Jam Pelajaran</option>
                <option value="Tidak Mengikuti Upacara">Tidak Mengikuti Upacara</option>
                <option value="Keluar Kelas Tanpa Izin">Keluar Kelas Tanpa Izin</option>
                <option value="Pacaran di Lingkungan Sekolah">Pacaran di Lingkungan Sekolah</option>
                <option value="Bullying / Menghina Teman">Bullying / Menghina Teman</option>
                <option value="Makan di Kelas Saat Pelajaran">Makan di Kelas Saat Pelajaran</option>
              </select>
            </div>
          </div>
          <div>
            <label for="keterangan" class="block font-medium text-md mb-1">Keterangan Tambahan</label>
            <input type="text" id="keterangan" name="keterangan" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-lg px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Masukkan keterangan jika ada">
          </div>
          <div class="text-center">
            <button type="submit" class="bg-primary hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
              Simpan Data
            </button>
          </div>
        </form>
      <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['guru'])): ?>
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
        <h3 class="text-xl font-semibold mb-4 text-center md:text-left">Statistik Pelanggaran</h3>
        <canvas id="pelanggaranChart" height="100"></canvas>
        <div class="mt-6 space-y-2">
          <a href="export_all.php" id="exportAll" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow transition duration-200">
            <i class="bi bi-download"></i> Unduh Semua Data
          </a>
          <a href="export_monthly.php" id="exportMonthly" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-xl shadow transition duration-200">
            <i class="bi bi-calendar-check"></i> Unduh Rekap Bulanan
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Tabel Data -->
  <div class="bg-white dark:bg-gray-800 mt-6 p-6 rounded-2xl shadow-md w-full max-w-6xl mx-auto">
    <h3 class="text-xl font-semibold mb-4 text-center md:text-left">Daftar Siswa Melakukan Pelanggaran</h3>

    <?php if (isset($_SESSION['guru'])): ?>
      <div class="w-full flex justify-center md:justify-start">
        <form action="delete.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua data?')">
          <button type="submit" class="mb-4 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
            <i class="bi bi-trash-fill"></i> Hapus Semua Data
          </button>
        </form>
      </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-600">
        <thead class="bg-primary dark:bg-blue-900 text-white">
          <tr>
            <th class="px-4 py-2 text-left">No</th>
            <th class="px-4 py-2 text-left">Nama</th>
            <th class="px-4 py-2 text-left">Kelas</th>
            <th class="px-4 py-2 text-left">Tanggal</th>
            <th class="px-4 py-2 text-left">Pelanggaran</th>
            <th class="px-4 py-2 text-left">Keterangan</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
          <?php
          include 'connection.php';

          // Array bulan Indonesia
          $bulanIndonesia = [
            1 => 'januari',
            2 => 'februari',
            3 => 'maret',
            4 => 'april',
            5 => 'mei',
            6 => 'juni',
            7 => 'juli',
            8 => 'agustus',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'desember'
          ];

          $data = $conn->query("SELECT * FROM pelanggaran ORDER BY tanggal DESC");
          $no = 1;

          if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
              // Format tanggal
              $tgl = strtotime($row['tanggal']);
              $tanggal = date('d', $tgl);
              $bulan = $bulanIndonesia[(int)date('m', $tgl)];
              $tahun = date('Y', $tgl);
              $tanggalFormat = "{$tanggal} {$bulan} {$tahun}";

              echo "<tr class='bg-white dark:bg-gray-900'>
                <td class='px-4 py-2'>{$no}</td>
                <td class='px-4 py-2'>{$row['nama']}</td>
                <td class='px-4 py-2'>" . str_replace('_', ' ', strtoupper($row['kelas'])) . "</td>
                <td class='px-4 py-2'>{$tanggalFormat}</td>
                <td class='px-4 py-2'><ul class='list-disc ml-4'>";
              $pelanggaranItems = explode(',', $row['pelanggaran']);
              foreach ($pelanggaranItems as $item) {
                echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
              }
              echo "</ul></td>
                <td class='px-4 py-2'>{$row['keterangan']}</td>
              </tr>";
              $no++;
            }
          } else {
            echo "<tr><td colspan='6' class='text-center text-gray-500 dark:text-gray-400 py-4'>Tidak ada data.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php
  $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
  $pelanggaranPerBulan = [];

  for ($i = 1; $i <= 12; $i++) {
    $query = $conn->query("SELECT COUNT(*) as total FROM pelanggaran WHERE MONTH(tanggal) = $i AND YEAR(tanggal) = YEAR(CURDATE())");
    $result = $query->fetch_assoc();
    $pelanggaranPerBulan[] = $result['total'];
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
  <script>
    const root = document.documentElement;
    const toggleBtn = document.getElementById('toggle-dark');
    const darkIcon = document.getElementById('dark-icon');
    const floatingActions = document.getElementById('floating-actions');
    const toggleMenuIcon = document.getElementById('toggle-menu-icon');

    // Atur dark mode saat pertama kali load
    if (localStorage.getItem('theme') === 'dark') {
      root.classList.add('dark');
      if (darkIcon) {
        darkIcon.classList.remove('bi-moon-fill');
        darkIcon.classList.add('bi-sun-fill');
      }
    }

    // Toggle dark mode
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        root.classList.toggle('dark');
        const isDark = root.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        if (darkIcon) {
          darkIcon.classList.toggle('bi-moon-fill', !isDark);
          darkIcon.classList.toggle('bi-sun-fill', isDark);
        }
      });
    }

    // Toggle bubble button group
    function toggleFloatingActions() {
      const isVisible = floatingActions.classList.contains('opacity-100');
      if (isVisible) {
        floatingActions.classList.remove('opacity-100', 'translate-y-0', 'visible');
        floatingActions.classList.add('opacity-0', 'translate-y-4', 'invisible');
        toggleMenuIcon.classList.remove('bi-x-lg');
        toggleMenuIcon.classList.add('bi-plus-lg');
      } else {
        floatingActions.classList.remove('opacity-0', 'translate-y-4', 'invisible');
        floatingActions.classList.add('opacity-100', 'translate-y-0', 'visible');
        toggleMenuIcon.classList.remove('bi-plus-lg');
        toggleMenuIcon.classList.add('bi-x-lg');
      }
    }

    // Modal Login/Register
    function openGuruModal() {
      document.getElementById('guruAuthModal').classList.remove('hidden');
      showLogin(); // default tampilkan form login
      toggleFloatingActions(); // otomatis tutup bubble
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

    // Inisialisasi Chart
    new Chart(document.getElementById('pelanggaranChart'), {
      type: 'bar',
      data: {
        labels: <?= json_encode($bulanLabels) ?>,
        datasets: [{
          label: 'Jumlah Pelanggaran',
          data: <?= json_encode($pelanggaranPerBulan) ?>,
          backgroundColor: 'rgba(59, 130, 246, 0.7)',
          borderRadius: 5
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });

    const pelanggaranSelect = new TomSelect('#pelanggaran', {
      plugins: ['remove_button'],
      persist: false,
      create: false,
      controlInput: false,
      search: false,
      onChange: () => {
        const hasValue = pelanggaranSelect.items.length > 0;
        const placeholder = document.getElementById('pelanggaran-placeholder');
        if (placeholder) {
          placeholder.style.display = hasValue ? 'none' : 'block';
        }
      }
    });

    // Saat awal halaman dimuat, cek apakah sudah ada isian
    document.addEventListener('DOMContentLoaded', () => {
      const hasValue = pelanggaranSelect.items.length > 0;
      const placeholder = document.getElementById('pelanggaran-placeholder');
      if (placeholder) {
        placeholder.style.display = hasValue ? 'none' : 'block';
      }
    });

    document.addEventListener("DOMContentLoaded", function() {
      let flatpickrInstanceTanggal = flatpickr("#tanggal", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        locale: flatpickr.l10ns.id
      });

      window.setToday = function() {
        const today = new Date();
        if (flatpickrInstanceTanggal) {
          flatpickrInstanceTanggal.setDate(today, true);
        }
      }
    });

    // sweat alert download
    document.addEventListener('DOMContentLoaded', function() {
      const exportAllBtn = document.getElementById('exportAll');
      const exportMonthlyBtn = document.getElementById('exportMonthly');

      if (exportAllBtn) {
        exportAllBtn.addEventListener('click', function(e) {
          e.preventDefault();
          Swal.fire({
            title: 'File sedang diunduh...',
            icon: 'info',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            didClose: () => {
              window.location.href = 'export_all.php';
            }
          });
        });
      }

      if (exportMonthlyBtn) {
        exportMonthlyBtn.addEventListener('click', function(e) {
          e.preventDefault();
          Swal.fire({
            title: 'File sedang diunduh...',
            icon: 'info',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            didClose: () => {
              window.location.href = 'export_monthly.php';
            }
          });
        });
      }
    });
  </script>

</body>

</html>