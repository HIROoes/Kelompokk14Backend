<?php
class Product {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Ambil semua produk
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM products ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Cari produk berdasarkan ID
    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Tambah produk baru
    public function addProduct($name, $description, $price, $owner, $contact, $image_path) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, owner, contact, image_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisss", $name, $description, $price, $owner, $contact, $image_path);
        return $stmt->execute();
    }

    // Update produk
    public function updateProduct($id, $name, $description, $price, $image_path) {
        $stmt = $this->conn->prepare("UPDATE products SET name=?, description=?, price=?, image_path=? WHERE id=?");
        $stmt->bind_param("ssisi", $name, $description, $price, $image_path, $id);
        return $stmt->execute();
    }

    // Hapus produk
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
}
