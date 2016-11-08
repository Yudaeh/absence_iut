<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Error extends Controleur {
    	
        /**
         * M�thode lanc�e par d�faut sur un contr�leur.
         */
        public function index() {
            require (VUES . 'error/index.php');
        }
        
    }
?>