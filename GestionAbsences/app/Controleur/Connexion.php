<?php
	namespace GestionAbsences\Controleur;
 
	use GestionAbsences\Core\Controleur;
	
	use GestionAbsences\Modele\Personnel;
	
	class Connexion extends Controleur {
	    
		/**
	 	 * M�thode lanc�e par d�faut par le controleur
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
				header('Location: /projects/absence_iut/GestionAbsences/ErrorConnexion');
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
			return (isset($_SESSION['login'])) || (!empty($_SESSION['login']));
		}
		
		/**
		 * V�rifie si l'utilisateur est connect� en tant que administrateur
		 * @return true si connect� en administrateur
		 */
		public static function estConnecteAdministrateur() {		
				// TODO

		}
		
		/**
		 * V�rifie si l'utilisateur est connect� en tant que administratif
		 * @return true si connect� en administratif
		 */
		public static function estConnecteAdministratif() {
			return $this->estConnecte() && $_SESSION['type'] == 2; //TODO MIEUX
		}
		
		/**
		 * V�rifie si l'utilisateur est connect� en tant que professeur
		 * @return true si connect� en professeur
		 */
		public static function estConnecteProfesseur() {
			return $this->estConnecte() && $_SESSION['type'] == 3; //TODO MIEUX
		}
	}
?>