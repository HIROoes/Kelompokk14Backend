<?php
session_start();
require "../config/database.php";

if (!isset($_SESSION['uid'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Produk tidak ditemukan!");
}

// Ambil data produk
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['uid']);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Produk tidak ditemukan atau bukan milik Anda!");
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price       = $_POST['price'] ?? 0;
    $contact     = $_SESSION['contact'];

    $image_path = $product['image_path']; // default gambar lama
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
        $stmt = $conn->prepare("UPDATE products 
            SET name=?, description=?, price=?, contact=?, image_path=? 
            WHERE id=? AND user_id=?");
        $stmt->bind_param("ssissii", $name, $description, $price, $contact, $image_path, $id, $_SESSION['uid']);

        if ($stmt->execute()) {
            $success = "Produk berhasil diperbarui!";
            // Refresh data
            $product['name'] = $name;
            $product['description'] = $description;
            $product['price'] = $price;
            $product['contact'] = $contact;
            $product['image_path'] = $image_path;
        } else {
            $error = "Terjadi kesalahan saat update produk.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Produk</title>
  <link rel="stylesheet" href="../asset/style.css">
</head>
<body>
  <header>
    <h1>Edit Produk</h1>
    <nav>
      <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="profile.php">Profil</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="card">
    <h2>Form Edit Produk</h2>
    <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <?php if($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
      <label>Nama Produk</label>
      <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
      <label>Deskripsi</label>
      <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
      <label>Harga</label>
      <input type="number" name="price" value="<?= $product['price'] ?>" required>
      <label>Foto Produk</label>
      <input type="file" name="image" accept="image/*">
      <?php if($product['image_path']): ?>
        <p>Gambar saat ini:</p>
        <img src="../uploads/<?= $product['image_path'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width:150px;">
      <?php endif; ?>
      <button type="submit">Update Produk</button>
    </form>
  </main>
</body>
</html>
