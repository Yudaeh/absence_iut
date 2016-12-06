<?php


    namespace GestionAbsences\Controleur;

    use GestionAbsences\Core\Controleur;
    use GestionAbsences\Modele\Adresse;
    use GestionAbsences\Modele\Etudiant;
    use GestionAbsences\Modele\Pays;
    use GestionAbsences\Modele\Ville;

    class CSV extends Controleur {

        /**
         * Méthode lancée par défaut sur un contrôleur.
         */
        public function index() {
            $this->importEtudiant('patron.csv', 1);
        }

        public function importEtudiant($fichier, $ID_G) {

            ini_set('auto_detect_line_endings', true);
            $fich = fopen($fichier, 'r');
            while (($tabR = fgetcsv($fich, 0, ";")) != false) {

                echo $tabR[8];
                $pays = new Pays(0, $tabR[8]);
                $pays->recherche();
                echo $pays->toString() . "<br/>";
                $ville = new Ville(0,$tabR[7],$tabR[6],$pays->getIDP());
                $ville->recherche();
                #var_dump($ville);
                echo $ville->toString()."<br/>";
                $adresse = new Adresse(0,$tabR[5],$tabR[4],$ville->getIDV());
                $adresse->recherche();
                echo $adresse->toString()."<br/>";
                $newEleve = new Etudiant($tabR[0],$tabR[1],$tabR[2],$ID_G,$tabR[3],$adresse->getIDA(),$tabR[9]);
                $newEleve->sauvegarder();
                echo $newEleve->toString();

            }
            ini_set('auto_detect_line_endings', false);
            fclose($fich);

        }
        
        /**
         * Traitement du formulaire d'importation
         */
        public function traitementCSV() {
        	if (strlen($_FILES['fichierCSV']['name'])!=0) {
        		$fichier = $_FILES['fichierCSV']['name'];
        		$groupe = $_POST['groupe'];
        		
        		CSV::importEtudiant($fichier, $groupe);
        		
        		unset($_POST);
        		unset($_FILES);
        		
        		$_SESSION['valid'] = "1";
        		header('Location: /projects/absence_iut/GestionAbsences/Importation');
        	} else {
        		$_SESSION['error'] = "1";
        		header('Location: /projects/absence_iut/GestionAbsences/Importation');
        	}
	
        }
    }