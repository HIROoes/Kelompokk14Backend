<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Mahasiswa</title>
  <link rel="stylesheet" href="../asset/style.css">
</head>
<body>
  <header>
    <h1>Mari Mahasiswa Wirausaha</h1>
    <nav>
      <div class="hamburger" onclick="toggleMenu()">☰</div>
      <ul id="menu" class="hidden">
        <li><a href="../index.php">Home</a></li>
        <li><a href="profile.php">Profil</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="profile-container">
    <h2>Data Profil</h2>
    <div class="profile-card">
      <p><strong>Nama:</strong> <?= $_SESSION['name'] ?></p>
      <p><strong>Role:</strong> <?= $_SESSION['role'] ?></p>
      <p><strong>Kontak:</strong> <?= $_SESSION['contact'] ?></p>
    </div>
  </main>

  <footer>
    <p>&copy; 2026 ITB STIKOM Bali</p>
  </footer>

  <script>
    function toggleMenu(){
      document.getElementById("menu").classList.toggle("hidden");
    }
  </script>
</body>
</html>
