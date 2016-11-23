<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Importation extends Controleur {
    	
        /**
         * Méthode lançée par défaut sur un controleur
         */
        public function index() {
            require (VUES . 'importation/index.php');
        }
        
    }
?>