<?php
session_start();
require "../config/database.php";
require "../models/User.php";

$userModel = new User($conn);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim      = $_POST['nim'] ?? '';
    $jurusan  = $_POST['jurusan'] ?? '';
    $name     = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $contact  = $_POST['contact'] ?? '';
    $role     = "mahasiswa"; 

    $existing = $userModel->findByUsername($username);
    if ($existing) {
        $error = "Username sudah digunakan!";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO users (nim, jurusan, username, password, role, name, contact, created_at) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssss", $nim, $jurusan, $username, $password, $role, $name, $contact);
        if ($stmt->execute()) {
            header("Location: login.php?registered=1");
            exit;
        } else {
            $error = "Terjadi kesalahan saat registrasi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Marketplace Mahasiswa</title>
  <link rel="stylesheet" href="../asset/style.css">
</head>
<body>
  <header>
    <h1>Marketplace Mahasiswa</h1>
    <nav>
      <div class="hamburger" onclick="toggleMenu()">☰</div>
      <ul id="menu" class="hidden">
        <li><a href="../index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      </ul>
    </nav>
  </header>

  <main class="login-container">
    <h2>Register</h2>
    <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
    <label>Nama Lengkap</label>
        <input type="text" name="username" required> 
    <label>Username</label>
        <input type="text" name="name" required>    
    <label>NIM</label>
        <input type="text" name="nim" required>
    <label>Jurusan</label>
        <input type="text" name="jurusan" required>
    <label>Password</label>
        <input type="password" name="password" required>
    <label>Kontak</label>
        <input type="text" name="contact" required>
    <button type="submit">Register</button>
    </form>
  </main>

  <script>
    function toggleMenu(){
      document.getElementById("menu").classList.toggle("hidden");
    }
  </script>
</body>
</html>
