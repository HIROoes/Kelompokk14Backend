<?php
class User {
    private $conn;
    public function __construct($db){
        $this->conn = $db;
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
