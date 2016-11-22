<?php
	namespace GestionAbsences\Controleur;
 
	use GestionAbsences\Core\Controleur;
	
	use GestionAbsences\Modele\Personnel;
	
	class Connexion extends Controleur {
	    
		/**
	 	 * Méthode lancée par défaut par le controleur
		 */
		public function index() {
			require (VUES . 'connexion/index.php');
		}
		
		/**
		 * Permet la connexion
		 */
		public function connection() {
			$user = $_POST["nomUtilisateur"];
			$pwd = $_POST["password"];
			
			$personnel = new Personnel();
			
			/*
			 * Si le login et le mot de passe (saisie dans le formulaire 
			 * de connexion) existe
			 */
			if ($personnel->loginExiste($user,$pwd)) {
				$this->seConnecter($user,$pwd); 
				header('Location: /projects/absence_iut/GestionAbsences/Accueil'); 
			} else {
				# Si le login n'est pas valide
			}
		}
		
		
		/**
		 * Déconnexion de la session
		 */
		public static function deconnexion() {
			unset($_SESSION);
			session_destroy(); 
			
			// Redirection
			header('Location: /projects/absence_iut/GestionAbsences/Accueil');
		}
		
		/**
		 * Se connecter à la session
		 * @param $user Le nom de l'utilisateur de la session
		 * @param $pwd Le mot de passe de la session
		 */
		public static function seConnecter($user, $pwd) {
			$_SESSION['login'] = $user;
			$_SESSION['pwd'] = $pwd;
		}
		
		/**
		 * @return true si quelqu'un est connecté, false sinon
		 */
		public static function estConnecte() {
			return (!isset($_SESSION['login'])) || (empty($_SESSION['login']));
		}
		
	}
?>