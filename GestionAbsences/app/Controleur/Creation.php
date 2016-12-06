<?php
    namespace GestionAbsences\Controleur;
    	
    use GestionAbsences\Core\Controleur;
    use GestionAbsences\Modele\Personnel;
    use GestionAbsences\Modele\Departement;
    use GestionAbsences\Modele\Filiere;
    use GestionAbsences\Modele\Groupe;

    class Creation extends Controleur {
    	
        /**
         * Méthode lançée par défaut sur un controleur, accéder à l'index
         */
        public function index() {
            // require (VUES . 'creation/index.php');
            require (VUES . 'creation/groupe.php');
        }
        
        /**
         * Méthode lançée pour accéder à la création de professeurs
         */
        public function professeur() {
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
         * Méthode lançée pour accéder à la création des groupes
         */
        public function groupe() {
        	require (VUES . 'creation/groupe.php');
        }
        
        
        /**
         * Méthode lançée pour accéder à la création d'administratifs
         */
        public function administratif() {
        	require(VUES . 'creation/administratif.php');
        }
        
        /**
         * Va créer un nouveau professeur à partir du formulaire de création
         */
        public function newProfesseur() {
        	
        	if (!isset($_POST["loginProfesseur"]) || empty($_POST["loginProfesseur"])
        			|| !isset($_POST["mdpProfesseur"]) || empty($_POST["mdpProfesseur"])
        			|| !isset($_POST["prenomProfesseur"]) || empty($_POST["prenomProfesseur"])
        			|| !isset($_POST["telProfesseur"]) || empty($_POST["telProfesseur"])
        			|| !isset($_POST["emailProfesseur"]) || empty($_POST["emailProfesseur"])
        			|| !isset($_POST["nomProfesseur"]) || empty($_POST["nomProfesseur"])
        			) {
        				
        		unset($_POST);
        		$_SESSION['error'] = "2";
        		header('Location: /projects/absence_iut/GestionAbsences/Creation');	
        	}
        	
        	$nom 	= 	$_POST["nomProfesseur"];
        	$prenom = 	$_POST["prenomProfesseur"];
        	$tel 	= 	$_POST["telProfesseur"];
        	$email 	= 	$_POST["emailProfesseur"];
        	$login 	=	$_POST["loginProfesseur"];
        	$mdp 	=   $_POST["mdpProfesseur"];
        	// Type enseignant = 3

        	$personnel = new Personnel(0, $nom, $prenom, 3);
        	$personnel->sauvegarder();
        	$personnel->createLogin($login,$mdp);
	
        	unset($_POST);
        	
        	header('Location: /projects/absence_iut/GestionAbsences/Creation');
        }
        
        /**
         * Va créer un nouveau département à partir du formulaire de création
         */
        public function newDepartement() {
      	
        	if (!isset($_POST["nomDepartement"]) || empty($_POST["nomDepartement"])) {
        		unset($_POST);
        		$_SESSION['error'] = "2";
        		header('Location: /projects/absence_iut/GestionAbsences/Creation');
        	}
        	
        	$nom = $_POST["nomDepartement"];
        	
        	$departement = new Departement(0,$nom);
        	$departement->sauvegarder();
        	
        	unset($_POST);
        	
        	header('Location: /projects/absence_iut/GestionAbsences/Creation');
        }
        
        /**
         * Va créer une nouvelle filière à partir du formulaire de création
         */
        public function newFiliere() {
        	if (!isset($_POST["nomFiliere"]) || empty($_POST["nomFiliere"])) {
        		unset($_POST);
        		$_SESSION['error'] = "2";
        		header('Location: /projects/absence_iut/GestionAbsences/Creation');
        	}
        	
        	$nom = $_POST["nomFiliere"];
        	$departement = $_POST["departement"];
        	
        	$filiere = new Filiere(0, $nom, $departement);
        	$filiere->sauvegarder();
        	
        	// header('Location: /projects/absence_iut/GestionAbsences/Creation');
        	
        	unset($_POST);
        }
        
        /**
         * Va créer un nouveau groupe à partir du formulaire de création
         */
        public function newGroupe() {
        	if (!isset($_POST["nomGroupe"]) || empty($_POST["nomGroupe"])) {
        		unset($_POST);
        		$_SESSION['error'] = "2";
        		header('Location: /projects/absence_iut/GestionAbsences/Creation');
        	}
        	 
        	$nom = $_POST["nomGroupe"];
        	$filiere = $_POST["filiere"];
        	 
        	$groupe = new Groupe(0, $nom, $filiere);
        	$groupe->sauvegarder();
        	 
        	// header('Location: /projects/absence_iut/GestionAbsences/Creation');
        	 
        	unset($_POST);
        }
        
        /**
         * Va créer un nouveau administratif à partir du formulaire de création
         */
        public function newAdministratif() {
        	
        	unset($_POST);
        }
    }
?>