<?php
session_start();
require "../config/database.php";
require "../models/Product.php";

if (!isset($_SESSION['uid'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] === 'admin') {
    die("Admin tidak bisa menambah produk!");
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price       = $_POST['price'] ?? 0;
    $owner       = $_SESSION['name'];
    $contact     = $_SESSION['contact'];

    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_path = $fileName;
        } else {
            $error = "Gagal upload foto.";
        }
    }

    if (!$error) {
        // ✅ Tambahkan kolom user_id ke query
        $stmt = $conn->prepare("INSERT INTO products 
            (name, description, price, owner, contact, image_path, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssisssi",
            $name,
            $description,
            $price,
            $owner,
            $contact,
            $image_path,
            $_SESSION['uid']   // ambil user_id dari session
        );

        if ($stmt->execute()) {
            $success = "Produk berhasil ditambahkan!";
        } else {
            $error = "Terjadi kesalahan saat menambah produk.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk</title>
  <link rel="stylesheet" href="../asset/style.css">
</head>
<body>
  <header>
    <h1>Tambah Produk</h1>
    <nav>
      <div class="hamburger" onclick="toggleMenu()">☰</div>
      <ul id="menu" class="hidden">
        <li><a href="../index.php">Home</a></li>
        <li><a href="profile.php">Profil</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="card">
    <h2>Form Tambah Produk</h2>
    <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <?php if($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
      <label>Nama Produk</label>
      <input type="text" name="name" required>
      <label>Deskripsi</label>
      <textarea name="description" required></textarea>
      <label>Harga</label>
      <input type="number" name="price" required>
      <label>Foto Produk</label>
      <input type="file" name="image" accept="image/*">
      <button type="submit">Tambah Produk</button>
    </form>
  </main>

  <script>
    function toggleMenu(){
      document.getElementById("menu").classList.toggle("hidden");
    }
  </script>
</body>
</html>
