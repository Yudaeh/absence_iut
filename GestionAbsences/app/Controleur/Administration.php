<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Administration extends Controleur {
    	
        /**
         * M�thode lan��e par d�faut sur un contr�leur.
         */
        public function index() {
            require (VUES . 'administration/index.php');
        }
        
    }
?>