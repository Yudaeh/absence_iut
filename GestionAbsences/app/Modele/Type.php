<?php


    namespace GestionAbsences\Modele;


    class Type extends Modele {

        /** @var  int */
        private $ID_T;
        /** @var  string */
        private $Nom_T;

        /**
         * Type constructor.
         * @param int $ID_T
         * @param string $Nom_T
         */
        public function __construct($ID_T = null, $Nom_T = null) {
            if (isset($ID_T)) {
                if ($ID_T <= 0 && isset($Nom_T)) {
                    $this->Nom_T = $Nom_T;
                    $this->sauvegarder();
                } else {
                    $this->ID_T = $ID_T;
                    $this->charger(); //TODO écrire charger()
                }
            }


        }

        /**
         * @return string
         */
        public function getNomT() {
            return $this->Nom_T;
        }

        /**
         * @param string $Nom_T
         */
        public function setNomT($Nom_T) {
            $this->Nom_T = $Nom_T;
        }

        /**
         * @return int
         */
        public function getIDT() {
            return $this->ID_T;
        }


        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->ID_T)) {
                $this->bd->actionParams("UPDATE type SET Nom_T=:nom WHERE ID_T=:id",
                                        array(
                                            ":nom" => $this->Nom_T,
                                            ":id" => $this->ID_T
                                        ));
            } else {
                $this->bd->actionParams("INSERT INTO type(Nom_T) VALUES (:nom)",
                                        array(
                                            ":nom" => $this->Nom_T
                                        ));
                $num =
                    $this->bd->selectSansParams("SELECT MAX(ID_T) AS ID_T FROM type ");
                $this->ID_T = $num[0]->ID_T;

            }
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_T)) {
                $info=$this->bd->selectParams("SELECT Nom_T FROM type WHERE ID_T=:id ",
                                        array(
                                            ":id" => $this->ID_T
                                        ));
                if(!empty($info)){
                    $this->Nom_T=$info[0]->Nom_T;
                } else {
                    $this->Nom_T=" ";
                }
            }
        }

        public function toString() {
            return "(".$this->getIDT()."): ".$this->getNomT();
        }
    }