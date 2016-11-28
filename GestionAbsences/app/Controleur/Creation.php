<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;

    class Creation extends Controleur {
    	
        /**
         * Méthode lançée par défaut sur un controleur, accéder à l'index
         */
        public function index() {
            require (VUES . 'creation/index.php');
        }
        
        /**
         * Méthode lançée pour accéder à la création de professeurs
         */
        public function professeurs() {
        	require (VUES . 'creation/professeurs.php');
        }
        
        /**
         * Méthode lançée pour accéder à la création de départements (enseignement)
         */
        public function departement() {
        	require (VUES . 'creation/departement.php');
        }
        
        /**
         * Méthode lançée pour accéder à la création des filières
         */
        public function  filiere() {
        	require (VUES . 'creation/filiere.php');
        }
        
        
        /**
         * Méthode lançée pour accéder à la création d'administratifs
         */
        public function administratif() {
        	require(VUES . 'creation/administratif.php');
        }
    }
?>