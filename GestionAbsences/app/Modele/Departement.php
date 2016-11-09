<?php


    namespace GestionAbsences\Modele;


    class Departement extends Modele {

        /** @var  int */
        private $ID_D;
        /** @var  string */
        private $Nom_D;

        /**
         * Departement constructor.
         * @param int $ID_D
         * @param string $Nom_D
         */
        public function __construct($ID_D, $Nom_D=null) {
            if(isset($ID_D)){
                $this->ID_D = $ID_D;
                if(isset($Nom_D)){
                    $this->Nom_D = $Nom_D;
                    $this->sauvegarder();
                } else {
                    $this->charger();
                }

            }

        }

        /**
         * @return int
         */
        public function getIDD() {
            return $this->ID_D;
        }

        /**
         * @param int $ID_D
         */
        public function setIDD($ID_D) {
            $this->ID_D = $ID_D;
        }

        /**
         * @return string
         */
        public function getNomD() {
            return $this->Nom_D;
        }

        /**
         * @param string $Nom_D
         */
        public function setNomD($Nom_D) {
            $this->Nom_D = $Nom_D;
        }



        public function sauvegarder() {
            $this->connexionBD();
            if(isset($this->ID_D)){
                if($this->ID_D==0){
                    $this->bd->actionParams("Insert into departement(Nom_D) VALUES (:nom)", array(
                        ":nom"=>$this->Nom_D
                    ));

                    $num = $this->bd->selectSansParams("Select MAX(ID_D) as ID_D From departement");
                    $this->ID_D=$num[0]->ID_D;
                } else {
                    $this->bd->actionParams("UPDATE Departement Set Nom_D=:nom WHERE ID_D=:id", array(
                        ":nom"=>$this->Nom_D,
                        ":id"=>$this->ID_D
                    ));
                }
            }
        }

        public function charger() {
            $this->connexionBD();
            if(isset($this->ID_D)){
                $info = $this->bd->selectParams("SELECT Nom_D FROM departement WHERE ID_D=:id", array(
                    ":id"=>$this->ID_D
                ));
                $this->Nom_D=$info[0]->Nom_D;
            }
        }

        public function toString(){
            return "(".$this->getIDD().") : ".$this->getNomD();
        }
    }