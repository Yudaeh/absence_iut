<?php


    namespace GestionAbsences\Controleur;


    use GestionAbsences\Core\Controleur;
    use GestionAbsences\Modele\Etudiant;

    class CSV extends Controleur {

        /**
         * Méthode lancée par défaut sur un contrôleur.
         */
        public function index() {
            // TODO: Implement index() method.
        }

        public function importEtudiant($fichier,$ID_G){
            $tabR=array();
            while(($eleve=fgetcsv($fichier))!=false) {
                array_push($tabR, $eleve);
                $newEleve = new Etudiant($tabR[0],$tabR[1],$tabR[2],$ID_G);
            }
        }
    }