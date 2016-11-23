<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Creation extends Controleur {
    	
        /**
         * Méthode lançée par défaut sur un controleur
         */
        public function index() {
            require (VUES . 'creation/index.php');
        }
        
    }
?>