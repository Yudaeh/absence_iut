<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Accueil extends Controleur {
    	
        /**
         * Méthode lancée par défaut par le contrôleur
         */
        public function index() {
            require (VUES . 'accueil/index.php');
            $this->setTitre("Accueil");
        }
        
    }
?>