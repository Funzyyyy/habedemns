<?php
session_start(); // Memulai sesi agar bisa menggunakan $_SESSION untuk menyimpan data login

// Jika form dikirim (login ditekan)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Mengecek apakah yang login adalah dosen wali
    if (isset($_POST['tipe_login']) && $_POST['tipe_login'] === 'wali') {
        
        // Login untuk Dosen Wali
        $dosen = $_POST['dosen_wali']; // Mengambil nama dosen dari select input
        $password = $_POST['password']; // Mengambil password dari input

        // Cek password (masih hardcoded sebagai 'dosen')
        if ($password === "dosen") {
            $_SESSION['dosen_wali'] = $dosen; // Simpan nama dosen ke dalam session
            header("Location: dashboard_dosen.php"); // Redirect ke halaman dashboard dosen wali
            exit(); // Hentikan eksekusi script
        } else {
            $error = "Password dosen wali salah!"; // Tampilkan pesan error jika password salah
        }

    } else {
        // Login untuk Admin
        $user = $_POST['username']; // Ambil username dari input
        $pass = $_POST['password']; // Ambil password dari input

        // Cek apakah username dan password admin cocok
        if ($user === "admin" && $pass === "admin") {
            $_SESSION['username'] = $user; // Simpan username ke session
            header("Location: dashboard.php"); // Redirect ke dashboard admin
            exit(); // Hentikan eksekusi script
        } else {
            $error = "Username atau password admin salah!"; // Tampilkan error jika gagal login
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id"> <!-- Bahasa dokumen: Indonesia -->
<head>
    <meta charset="UTF-8"> <!-- Encoding karakter -->
    <title>Halaman Login</title> <!-- Judul tab di browser -->

    <style>
        /* Gaya tampilan halaman login */
        body {
            font-family: Calibri, sans-serif;
            background-color: #fff;
        }
        .container {
            text-align: center;
            margin-top: 80px;
        }
        .login-box {
            border: 1px solid #000;
            width: 320px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 0 10px #00000066;
            text-align: left;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="password"],
        select {
            width: 95%;
            padding: 5px;
        }
        input[type="submit"] {
            margin-top: 15px;
            padding: 5px 15px;
        }
        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
        .toggle {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            margin-bottom: 10px;
            display: inline-block;
        }
        .hidden {
            display: none; /* Menyembunyikan elemen (dipakai pada form wali) */
        }
    </style>

    <script>
        // Fungsi untuk berpindah antar form login (admin <-> wali)
        function toggleLoginMode() {
            const adminForm = document.getElementById('admin-form'); // Form admin
            const waliForm = document.getElementById('wali-form');   // Form dosen wali
            const toggleText = document.getElementById('toggleText'); // Teks untuk toggle

            // Cek form yang sedang tampil, lalu tukar
            if (adminForm.style.display === 'none') {
                adminForm.style.display = 'block';
                waliForm.style.display = 'none';
                toggleText.textContent = 'Login Dosen Wali';
            } else {
                adminForm.style.display = 'none';
                waliForm.style.display = 'block';
                toggleText.textContent = 'Login Admin';
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Selamat Datang</h1>
    <h2>Aplikasi Bimbingan Dosen Wali<br>Prodi Teknik Elektronika</h2>

    <!-- Teks toggle antar form -->
    <span class="toggle" id="toggleText" onclick="toggleLoginMode()">Login Dosen Wali</span>

    <div class="login-box">

        <!-- FORM LOGIN ADMIN -->
        <form method="post" id="admin-form">
            <fieldset>
                <legend><strong>Login Admin</strong></legend>
                <input type="hidden" name="tipe_login" value="admin"> <!-- Tandai sebagai login admin -->
                <label>Username :</label>
                <input type="text" name="username" required> <!-- Input username -->
                <label>Password :</label>
                <input type="password" name="password" required> <!-- Input password -->
                <input type="submit" value="Log In"> <!-- Tombol login -->
            </fieldset>
        </form>

        <!-- FORM LOGIN DOSEN WALI -->
        <form method="post" id="wali-form" class="hidden"> <!-- Awalnya disembunyikan -->
            <fieldset>
                <legend><strong>Login Dosen Wali</strong></legend>
                <input type="hidden" name="tipe_login" value="wali"> <!-- Tandai sebagai login wali -->
                <label>Pilih Nama Dosen Wali :</label>
                <select name="dosen_wali" required> <!-- Dropdown pilih nama dosen -->
                    <option value="">-- Pilih Dosen Wali --</option>
                    <option>Andi Sri Irtawaty, S.T., M.Eng</option>
                    <option>Ihsan, S.Kom., M.T.</option>
                    <option>Nurwahidah Jamal, S.T., M.T.</option>
                    <option>Zulkarnain, S.Pd, M.Pd</option>
                </select>
                <label>Password :</label>
                <input type="password" name="password" required> <!-- Input password wali -->
                <input type="submit" value="Log In"> <!-- Tombol login wali -->
            </fieldset>
        </form>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

    </div>
</div>
</body>
</html>
