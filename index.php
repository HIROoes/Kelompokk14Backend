<?php
session_start();
include 'config/database.php';
include 'models/Product.php';

$productModel = new Product($conn);
$products = $productModel->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Marketplace Mahasiswa ITB STIKOM Bali</title>
  
  <link rel="stylesheet" href="asset/style.css">
</head>
<body>
  <header>
    <h1>Mari Mahasiswa Wirausaha</h1>
    <nav>
      <div class="hamburger" onclick="toggleMenu()">☰</div>
      <ul id="menu" class="hidden">
        <li><a href="index.php">Home</a></li>
        <?php if(isset($_SESSION['uid'])): ?>
          <li><a href="user/profile.php">Profil</a></li>
          <?php if($_SESSION['role'] !== 'admin'): ?>
            <li><a href="user/addProduct.php">Tambah Produk</a></li>
          <?php endif; ?>
          <li><a href="auth/logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="auth/login.php">Login</a></li>
          <li><a href="auth/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main>
    <?php if(isset($_SESSION['name'])): ?>
      <div class="welcome-container">
        <h2>Selamat datang, <?= htmlspecialchars($_SESSION['name']) ?>!</h2>
      </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['uid']) && $_SESSION['role'] !== 'admin'): ?>
      <div style="text-align:center; margin:20px;">
        <a href="user/addProduct.php" class="btn">+ Tambah Produk</a>
      </div>
    <?php endif; ?>
    <div class="product-grid">
      <?php foreach($products as $p): ?>
        <div class="product-card">
          <a href="user/productDetail.php?id=<?= $p['id'] ?>" style="text-decoration:none; color:inherit;">
            <img src="uploads/<?= $p['image_path'] ?:'logo.jpg'  ?>" alt="<?= htmlspecialchars($p['name']) ?>">
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            <p><?= htmlspecialchars($p['description']) ?></p>
            <p class="price">Rp <?= number_format($p['price'],0,',','.') ?></p>
            <p class="owner">Oleh: <?= $p['owner_name'] ?? $p['owner'] ?></p>
            <p class="contact">Kontak: <?= $p['contact'] ?? '-' ?></p>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </main>
<div class="product-card">
  <a href="user/productDetail.php?id=<?= $p['id'] ?>" style="text-decoration:none; color:inherit;">
    <img src="uploads/<?= $p['image_path'] ?: 'default.jpg' ?>" alt="<?= htmlspecialchars($p['name']) ?>">
    <h3><?= htmlspecialchars($p['name']) ?></h3>
    <p><?= htmlspecialchars($p['description']) ?></p>
    <p class="price">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
    <p class="owner">Oleh: <?= $p['owner_name'] ?? $p['owner'] ?></p>
    <p class="contact">Kontak: <?= $p['contact'] ?? '-' ?></p>
  </a>

  <?php if(isset($_SESSION['uid']) && $_SESSION['uid'] == $p['user_id']): ?>
    <a href="user/editProduct.php?id=<?= $p['id'] ?>" class="btn">Edit Produk</a>
  <?php endif; ?>
</div>

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
