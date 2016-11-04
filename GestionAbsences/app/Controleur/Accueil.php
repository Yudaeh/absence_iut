<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Accueil extends Controleur {
    	
        /**
         * Méthode lancée par défaut sur un contrôleur.
         */
        public function index() {
            require (VUES . 'accueil/index.php');
        }
        
    }
?>