<?php


    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Accueil extends Controleur {
    	
        /**
         * Méthode lancée par défaut sur un contrôleur.
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