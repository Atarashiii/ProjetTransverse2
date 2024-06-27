<?php
include '../config/config.php';
include_once '../model/Grille_model.php';

class Home_Controller {
    private $ObjGrilleModel;

    public function __construct($conn) {
        $this->ObjGrilleModel = new Grille_model($conn);
    }

    public function HomeIndex() {
        $grilles = $this->ObjGrilleModel->getAvailableGrilles();
        
        $appversion['app_version'] = APP_VERSION;
        include '../view/home.php';
    }

    public function __destruct() {
        $this->ObjGrilleModel->closeConnection();
    }
}
?>