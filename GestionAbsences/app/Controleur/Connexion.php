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
		 * dont give a damn shit
		 * 
		 */
		public function connection() {
			$user = $_POST["nomUtilisateur"];
			$pwd = $_POST["password"];
			
			if (loginExist($user,$pwd)) { 
				seConnecter($user,$pwd); 
				header('Location: /projects/absence_iut/GestionAbsences/Accueil'); 
			} else {
				
			}
		}
		
		
		/**
		 * Déconnexion de la session
		 */
		public function deconnexion() {
			unset($_SESSION);
			session_destroy(); 
			
			// Redirection
			header('Location: /projects/absence_iut/GestionAbsences/Accueil');
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