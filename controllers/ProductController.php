<?php
class Product {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Ambil semua produk + join ke tabel users untuk ambil nama owner
    public function getAll() {
        $sql = "SELECT p.id, p.name, p.description, p.price, 
                       p.owner, u.name AS owner_name, 
                       p.contact, p.image_path, p.category, p.status, p.created_at
                FROM products p
                LEFT JOIN users u ON p.owner = u.nim
                ORDER BY p.id DESC";
        $result = $this->conn->query($sql);
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
        $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, owner, contact, image_path, status, created_at) 
                                      VALUES (?, ?, ?, ?, ?, ?, 'active', NOW())");
        $stmt->bind_param("ssisss", $name, $description, $price, $owner, $contact, $image_path);
        return $stmt->execute();
    }

    // Update produk
    public function updateProduct($id, $name, $description, $price, $image_path) {
        $stmt = $this->conn->prepare("UPDATE products SET name=?, description=?, price=?, image_path=?, updated_at=NOW() WHERE id=?");
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
