<?php
session_start();
include '../config/database.php';
include '../models/Product.php';

$productModel = new Product($conn);
$id = $_GET['id'] ?? null;
if (!$id) {
    die("Produk tidak ditemukan!");
}
$product = $productModel->findById($id);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Produk - <?= htmlspecialchars($product['name']) ?></title>
  <link rel="stylesheet" href="../asset/style.css">
</head>
<body>
  <main class="detail-container">
    <img src="../uploads/<?= !empty($product['image_path']) ? $product['image_path'] : 'logo.jpg' ?>" 
     alt="<?= htmlspecialchars($product['name']) ?>">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p class="price">Rp <?= number_format($product['price'],0,',','.') ?></p>
    <p>Oleh: <?= $product['owner_name'] ?? $product['owner'] ?></p>
    <p>Kontak: <?= $product['contact'] ?? '-' ?></p>
    <p>Kategori: <?= $product['category'] ?? '-' ?></p>
  <a href="../index.php" class="back-link">← Kembali ke Marketplace</a>
  </main>
</body>
</html>

