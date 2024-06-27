<?php
include_once '../config/config.php';
include_once '../model/Entreprise_model.php';
include_once '../model/Grille_model.php';

class Entreprise_controller {
    private $ObjEntrepriseModel;
    private $ObjGrilleModel;

    public function __construct($conn) {
        $this->ObjEntrepriseModel = new Entreprise_model($conn);
        $this->ObjGrilleModel = new Grille_model($conn);
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

            $result = $this->ObjEntrepriseModel->createEntreprise($nom, $commentaire);

            if ($result === true) {
                // Récupérer l'ID de l'entreprise nouvellement créée
                $entreprise_id = $this->ObjEntrepriseModel->getLastInsertedId();

                $result_grille = $this->ObjGrilleModel->createGrilleForEntreprise($entreprise_id);

                if ($result_grille === true) {
                    // Redirection après insertion réussie
                    header("Location: index.php?action=EntrepriseIndex");
                    exit();
                } else {
                    echo $result_grille;
                }
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