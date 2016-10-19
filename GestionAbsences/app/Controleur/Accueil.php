<?php


    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Accueil extends Controleur {
    	
        /**
         * M�thode lanc�e par d�faut sur un contr�leur.
         */
        public function index() {
            $this->render('accueil.index');
        }
        
        /**
         * Effectue un rendu de la vue
         * @param $view chemin de la vue
         */
        public function render($view) {
        	ob_start();
        	require($view = VUES . str_replace('.','/',$view) . '.php');
        }


    }