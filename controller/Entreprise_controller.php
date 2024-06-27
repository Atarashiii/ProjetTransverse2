<?php
include '../config/config.php';
include_once '../model/Entreprise_model.php';

class Entreprise_controller {
    private $ObjEntrepriseModel;

    public function __construct($conn) {
        $this->ObjEntrepriseModel = new Entreprise_model($conn);
    }

    public function EntrepriseIndex() {
        
        $appversion['app_version'] = APP_VERSION;
        include '../view/createEntreprise.php';
    }
    
    public function createEntreprise() {
        // Vérifier si le formulaire a été soumis en utilisant $_POST
        if (!empty($_POST)) {
            // Récupérer les données du formulaire
            $nom = isset($_POST['nom_entreprise']) ? $_POST['nom_entreprise'] : '';
            $commentaire = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';

            $result = $this->ObjEntrepriseModel->create($nom, $commentaire);

            if ($result === true) {
                header("Location: index.php?success=1");
                exit();
            } else {
                echo $result;
            }
        } else {
            echo "Formulaire non soumis.";
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>