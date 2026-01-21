<?php
session_start();
require "../config/database.php";
require "../models/User.php";

$userModel = new User($conn);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $userModel->findByUsername($username);

    if ($user && $password === $user['password']) {
        $_SESSION['uid']     = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['contact'] = $user['contact'];

        header("Location: ../index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Mari Mahasiswa Wirausaha</title>
  <link rel="stylesheet" href="../asset/style.css">
</head>
<body>
  <header>
    <h1>Marketplace Mahasiswa</h1>
    <nav>
      <div class="hamburger" onclick="toggleMenu()">☰</div>
      <ul id="menu" class="hidden">
        <li><a href="../index.php">Home</a></li>
        <?php if(isset($_SESSION['uid'])): ?>
          <li><a href="../user/profile.php">Profil</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main class="login-container">
    <h2>Login</h2>
    <?php if($error): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <?php if(isset($_GET['registered'])): ?>
      <p class="success">Registrasi berhasil! Silakan login.</p>
    <?php endif; ?>
    <form method="POST">
      <label>Username</label>
      <input type="text" name="username" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <button type="submit">Login</button>
    </form>

    <p class="register-link">Belum punya akun? <a href="register.php">Register</a></p>
  </main>

  <script>
    function toggleMenu(){
      document.getElementById("menu").classList.toggle("hidden");
    }
  </script>
</body>
</html>
