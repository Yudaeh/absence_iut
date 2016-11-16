<?php
	namespace GestionAbsences\Controleur;
 
	use GestionAbsences\Core\Controleur;

	class Connexion extends Controleur {
	 
		/**
	 	 * Méthode lancée par défaut par le controleur
		 */
		public function index() {
			require (VUES . 'connexion/index.php');
		}
		
		/**
		 * Déconnexion de la session
		 */
		public function deconnexion() {
			unset($_SESSION);
			session_destroy(); 
		}
		
		public function seConnecter($user, $pwd) {
			$_SESSION['login'] = $user;
			$_SESSION['pwd'] = $pwd;
		}
		
		public function estConnecte() {
			return (!isset($_SESSION['login'])) || (empty($_SESSION['login']));
		}

		
	}
?>