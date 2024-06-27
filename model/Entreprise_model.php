<?php
include '../config/config.php';

class Entreprise_model {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllEntreprise() {
        $sql = "SELECT * FROM entreprise";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>