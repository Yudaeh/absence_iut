<?php
    namespace GestionAbsences\Controleur;

    use GestionAbsences\Core\Controleur;
    use GestionAbsences\Libs\BaseDeDonnees;
    use GestionAbsences\Modele\Pays;
    use GestionAbsences\Modele\Ville;

    class ControleurTest extends Controleur {

        /**
         * Méthode lancée par défaut sur un contrôleur.
         */
        public function index() {
            $bd=BaseDeDonnees::getInstance();
            var_dump($bd->selectSansParams("Select * FROM Pays"));
        }

        public function test($a,$b=null){
            echo $a . '  ' . $b;
        }

        public function testS($id,$nom=null,$cp=null,$idp=null){
           // $Pays=new Pays($id, $nom);
           // $Pays->sauvegarder();
           // var_dump($Pays);
           // $Pays2=new Pays($id);
            // var_dump($Pays2);
            $Ville=new Ville($id);
            var_dump($Ville);

        }
    }