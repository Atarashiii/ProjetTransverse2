<?php
include '../config/config.php';

class Question_model {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getAllResponsesByQuestionId($question_id) {
        $sql = "SELECT reponse_id, reponse_libelle, reponse_valeur FROM reponse WHERE question_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $responses = [];
        while ($row = $result->fetch_assoc()) {
            $responses[] = $row;
        }

        return $responses;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>