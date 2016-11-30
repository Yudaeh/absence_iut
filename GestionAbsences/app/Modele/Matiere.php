<?php


    namespace GestionAbsences\Modele;


    use GestionAbsences\Libs\BaseDeDonnees;

    class Matiere extends Modele {

        /** @var  int */
        private $ID_M;
        /** @var  string */
        private $Nom_M;

        /**
         * Matiere constructor.
         * @param int $ID_M
         * @param string $Nom_M
         */
        public function __construct($ID_M, $Nom_M=null) {
            if(isset($ID_M)){
                $this->ID_M = $ID_M;
                if(isset($Nom_M)){
                    $this->Nom_M = $Nom_M;

                } else {
                    $this->charger();
                }

            }
        }

        /**
         * @return int
         */
        public function getIDM() {
            return $this->ID_M;
        }

        /**
         * @param int $ID_M
         */
        public function setIDM($ID_M) {
            $this->ID_M = $ID_M;
        }

        /**
         * @return string
         */
        public function getNomM() {
            return $this->Nom_M;
        }

        /**
         * @param string $Nom_M
         */
        public function setNomM($Nom_M) {
            $this->Nom_M = $Nom_M;
        }

        public function chercherMatiere(){
            $this->connexionBD();
            $info = $this->bd->selectParams("SELECT ID_M From matiere WHere Nom_M=:nom", array(
                ":nom"=>$this->Nom_M
            ));
            return $info;
        }

        public static function findAll(){
            $bd=BaseDeDonnees::getInstance();
            $info = $bd->selectSansParams("Select ID_M,Nom_M From matiere");
            $matiere=array();
            for($i=0;$i<count($info);$i++){
                $matiere[]= new Matiere($info[$i]->ID_M,$info[$i]->Nom_M);

            }
            return $matiere;
        }

        public function sauvegarder() {
            $this->connexionBD();
            if(isset($this->ID_M)){
                if($this->ID_M == 0){
                    $this->bd->actionParams("Insert INTO matiere(Nom_M) VALUES (:nom)", array(
                        ":nom"=>$this->Nom_M
                    ));

                    $num = $this->bd->selectSansParams("SELECT MAX(ID_M) as ID_M FROM matiere");
                    $this->ID_M=$num[0]->ID_M;
                } else {
                    $this->bd->actionParams("UPDATE matiere SET Nom_M=:nom WHERE ID_M=:id", array(
                        ":nom"=>$this->Nom_M,
                        ":id"=>$this->ID_M
                    ));
                }
            }
        }

        public function charger() {
            $this->connexionBD();
            if(isset($this->ID_M)){
                $info = $this->bd->selectParams("SELECT Nom_M From matiere WHERE ID_M=:id", array(
                    ":id"=>$this->ID_M
                ));
                $this->Nom_M=$info[0]->Nom_M;
            }
        }

        public function toString(){
            return "(".$this->getIDM().") : ".$this->getNomM();
        }
    }