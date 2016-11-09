<?php


    namespace GestionAbsences\Modele;


    class Pays extends Modele {

        /** @var  integer */
        private $ID_P;
        /** @var  string */
        private $Nom_P;

        /**
         * Pays constructor.
         * @param int $ID_P
         * @param string $Nom_P
         */
        public function __construct($ID_P = null, $Nom_P = null) {
            if (isset($ID_P)) {
                if ($ID_P <= 0 && isset($Nom_P)) {
                    $this->Nom_P=$Nom_P;
                    $this->sauvegarder();
                } else {
                    $this->ID_P = $ID_P;
                    $this->charger();


                }

            } else {
                $this->ID_P = " ";
                $this->Nom_P = " ";
            }


        }

        /**
         * @return string
         */
        public function getNomP() {
            return $this->Nom_P;
        }

        /**
         * @param string $Nom_P
         */
        public function setNomP($Nom_P) {
            $this->Nom_P = $Nom_P;
        }


        /**
         * @return int
         */
        public function getIDP() {
            return $this->ID_P;
        }


        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->ID_P)) {
                $this->bd->actionParams("UPDATE pays SET Nom_P=:nom WHERE ID_P=:id_P",
                                                 array(
                                                     ":nom" => $this->Nom_P,
                                                     ":id_P" => $this->ID_P
                                                 ));
            } else {
                $this->bd->actionParams("INSERT INTO pays(Nom_P) VALUES (:nom)",
                                        array(
                                            ":nom"=> $this->Nom_P
                                        ));
                $num = $this->bd->selectSansParams("SELECT MAX(ID_P) AS ID_P FROM pays");
                $this->ID_P=$num[0]->ID_P;
            }

        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_P)) {
                $result =
                    $this->bd->selectParams("SELECT Nom_P FROM Pays WHERE ID_P=:id",
                                            array(
                                                ":id" => $this->ID_P
                                            ));
                if(!empty($result)) {
                    $this->Nom_P = $result[0]->Nom_P;
                } else {
                    echo 'Erreur : Aucun Pays à ce numéro';
                    $this->Nom_P =" ";
                }
            }
        }

        public function toString(){
            return "(".$this->getIDP()."): ".$this->getNomP();
        }
    }