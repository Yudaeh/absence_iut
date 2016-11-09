<?php


    namespace GestionAbsences\Modele;


    class Salle extends Modele {

        /** @var  int */
        private $ID_S;
        /** @var  string */
        private $Nom_S;
        /** @var  string */
        private $batiment;
        /** @var  int */
        private $num;

        /**
         * Salle constructor.
         * @param int $ID_S
         * @param string $Nom_S
         * @param string $batiment
         * @param int $num
         */
        public function __construct($ID_S, $Nom_S=null, $batiment=null, $num=null) {
            if(isset($ID_S)){
                $this->ID_S = $ID_S;
                if(isset($Nom_S) && isset($batiment) && isset($num)){
                    $this->Nom_S = $Nom_S;
                    $this->batiment = $batiment;
                    $this->num = $num;
                    $this->sauvegarder();
                } else {
                    $this->charger();

                }

            }

        }

        /**
         * @return int
         */
        public function getIDS() {
            return $this->ID_S;
        }

        /**
         * @param int $ID_S
         */
        public function setIDS($ID_S) {
            $this->ID_S = $ID_S;
        }

        /**
         * @return string
         */
        public function getNomS() {
            return $this->Nom_S;
        }

        /**
         * @param string $Nom_S
         */
        public function setNomS($Nom_S) {
            $this->Nom_S = $Nom_S;
        }

        /**
         * @return string
         */
        public function getBatiment() {
            return $this->batiment;
        }

        /**
         * @param string $batiment
         */
        public function setBatiment($batiment) {
            $this->batiment = $batiment;
        }

        /**
         * @return int
         */
        public function getNum() {
            return $this->num;
        }

        /**
         * @param int $num
         */
        public function setNum($num) {
            $this->num = $num;
        }

        public function sauvegarder() {
            $this->connexionBD();
            if(isset($this->ID_S)){
                if($this->ID_S==0){
                    $this->bd->actionParams("INSERT INTO salle(Nom_S, batiment, num) VALUES (:nom,:batiment,:num)", array(
                        ":nom"=>$this->Nom_S,
                        ":batiment"=>$this->batiment,
                        ":num"=>$this->num
                    ));

                    $num = $this->bd->selectSansParams("Select MAX(ID_S) as ID_S FROM salle");
                    $this->ID_S=$num[0]->ID_S;

                } else {
                    $this->bd->actionParams("UPDATE salle SET Nom_S=:nom,batiment=:batiment,num=:num Where ID_S=:id ", array(
                        ":nom"=>$this->Nom_S,
                        ":batiment"=>$this->batiment,
                        ":num"=>$this->num,
                        ":id"=>$this->ID_S
                    ));
                }
            }
        }

        public function charger() {
            $this->connexionBD();
            if(isset($this->ID_S)){
                $info = $this->bd ->selectParams("Select Nom_S,batiment,num From salle Where ID_S=:id", array(
                    ":id"=>$this->ID_S
                ));

                $this->Nom_S = $info[0]->Nom_S;
                $this->batiment = $info[0]->batiment;
                $this->num= $info[0]->num;
            }

        }

        public function toString(){
            return "(".$this->getIDS().") : ".$this->getNomS()." ".$this->getBatiment()." ".$this->getNum();
        }
    }