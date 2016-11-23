<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Absence extends Controleur {
    	
        /**
         * Méthode lancée par défaut par le contrôleur
         */
        public function index() {
            require (VUES . 'Absence/index.php');
            $this->setTitre("Accueil");
        }
        
    }
?>
