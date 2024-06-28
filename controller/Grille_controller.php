<?php
include_once '../config/config.php';
include_once '../model/Grille_model.php';
include_once '../model/Question_model.php';
include_once '../model/Entreprise_model.php';

class Grille_controller {
    private $ObjGrilleModel;
    private $ObjQuestionModel;
    private $ObjEntrepriseModel;

    public function __construct($conn) {
        $this->ObjEntrepriseModel = new Entreprise_model($conn);
        $this->ObjGrilleModel = new Grille_model($conn);
        $this->ObjQuestionModel = new Question_model($conn);
    }

    public function GrilleIndex() {
        $value = isset($_GET['id']) ? $_GET['id'] : die('ID de grille non spécifié.');
        list($grille_id, $entreprise_id) = explode('-', $value);

        $data = $this->ObjGrilleModel->getEvaluationData($grille_id, $entreprise_id);
        
        $totaux_par_axe = [];
        foreach ($data as $row) {
            if (!isset($totaux_par_axe[$row["axe_libelle"]])) {
                $totaux_par_axe[$row["axe_libelle"]] = 0;
            }
            $totaux_par_axe[$row["axe_libelle"]] += $row["reponse_valeur"];
        }

        $diviseurs = [
            "Axe Compétence" => 9,
            "Axe Réactivité" => 11,
            "Axe Numérique" => 20,
        ];

        $moyennes_par_axe = [];
        foreach ($totaux_par_axe as $axe => $total) {
            if (isset($diviseurs[$axe])) {
                $moyennes_par_axe[$axe] = ($total / $diviseurs[$axe]) * 2.5;
            } else {
                $moyennes_par_axe[$axe] = null;
            }
        }

        $appversion['app_version'] = APP_VERSION;
        include '../view/recap.php';
    }

    public function editGrille() {
        if (isset($_GET['entreprise_id'])) {
            $entreprise_id = $_GET['entreprise_id'];
            $grille_data = $this->ObjGrilleModel->getGrilleByEntrepriseId($entreprise_id);
            // Récupérer les réponses pour chaque question
            foreach ($grille_data as &$question) {
                $question_id = $question['question_id'];
                $question['responses'] = $this->ObjQuestionModel->getAllResponsesByQuestionId($question_id);
            }
            $appversion['app_version'] = APP_VERSION;
            include '../view/editGrille.php';
        } else {
            echo "ID de l'entreprise non spécifié.";
        }
    }

    public function saveGrille() {
        if (!empty($_POST)) {
            $entreprise_id = isset($_POST['entreprise_id']) ? $_POST['entreprise_id'] : '';
            $reponses = isset($_POST['reponses']) ? $_POST['reponses'] : [];
    
            $result = $this->ObjGrilleModel->updateGrilleResponses($entreprise_id, $reponses);
    
            if ($result === true) {
                // Récupérer l'ID de la grille (si nécessaire, sinon vous pouvez le passer en tant que paramètre)
                $grille_id = $this->ObjGrilleModel->getGrilleIdByEntrepriseId($entreprise_id);
    
                // Rediriger vers l'URL avec les IDs appropriés
                header("Location: index.php?id={$grille_id}-{$entreprise_id}&ctrl=grille&action=GrilleIndex");
                exit();
            } else {
                echo $result;
            }
        } else {
            echo "Formulaire non soumis.";
        }
    }

    public function __destruct() {
        $this->ObjGrilleModel->closeConnection();
    }
}
?>