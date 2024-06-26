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

    public function createEntreprise($nom, $commentaire) {
        $nom_entreprise = $this->conn->real_escape_string($nom);
        $commentaire = $this->conn->real_escape_string($commentaire);
        
        $sql = "INSERT INTO entreprise (entreprise_libelle, entreprise_commentaire) VALUES ('$nom_entreprise', '$commentaire')";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return "Erreur: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function getLastInsertedId() {
        return $this->conn->insert_id;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>