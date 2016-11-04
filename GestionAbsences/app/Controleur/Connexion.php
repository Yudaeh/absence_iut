<?php
	namespace GestionAbsences\Controleur;
 
	use GestionAbsences\Core\Controleur;

	class Connexion extends Controleur {
	 
		/**
	 	* Méthode lancée par défaut sur un contrôleur.
		 */
		public function index() {
			require (VUES . 'connexion/index.php');
		}

	}
?>