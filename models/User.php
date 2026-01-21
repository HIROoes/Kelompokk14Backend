<?php
class User {
    private $conn;
    public function __construct($db){
        $this->conn = $db;
    }

    public function getAll(){
        $sql = "SELECT id, username, role FROM users";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getById($id){
        $sql = "SELECT id, username, role FROM users WHERE id=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function create($username, $password, $role){
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $username, $hashed, $role);
        return mysqli_stmt_execute($stmt);
    }

    public function update($id, $username, $role){
        $sql = "UPDATE users SET username=?, role=? WHERE id=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $username, $role, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function updatePassword($id, $password){
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password=? WHERE id=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $hashed, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function delete($id){
        $sql = "DELETE FROM users WHERE id=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

    public function findByUsername($username){
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }
}
?>
