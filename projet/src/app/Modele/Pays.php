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
        public function __construct($ID_P = null) {
            if(isset($ID_P) ) {
                $this->ID_P = $ID_P;
                $this->charger();
            }


        }

        /**
         * @return int
         */
        public function getIDP() {
            return $this->ID_P;
        }


        public function sauvegarder() {
            $this->connexionBD();
            if (!isset($this->ID_P)) {
               var_dump( $this->bd->actionParams("UPDATE pays SET Nom_P=:nom WHERE ID_P=:id_P",
                                        array(
                                            ":nom" => $this->Nom_P,
                                            ":id_P" => $this->ID_P
                                        )));
            }
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_P)) {
                $result=$this->bd->selectParams("SELECT Nom_P FROM Pays WHERE ID_P=:id",
                                        array(
                                            ":id" => $this->ID_P
                                        ));
                $this->Nom_P=$result[0]->Nom_P;
            }
        }
    }