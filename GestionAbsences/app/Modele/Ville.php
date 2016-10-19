<?php


    namespace GestionAbsences\Modele;


    class Ville extends Modele {

        /** @var  int */
        private $ID_V;
        /** @var  string */
        private $Nom;
        /** @var  string */
        private $CP;
        /** @var  Pays */
        private $ID_Pays;

        /**
         * Ville constructor.
         * @param int $ID_V
         */
        public function __construct($ID_V,$Nom=null,$CP=null,$ID_Pays=null) {
            if(isset($ID_V)){
                $this->ID_V = $ID_V;
                $this->charger();
            }

        }


        public function sauvegarder() {
            $this->connexionBD();
            if (!isset($this->ID_V)) {
                var_dump( $this->bd->actionParams("UPDATE ville SET Nom=:nom,CP=:cp,ID_Pays=:id WHERE ID_V=:id_v",
                                                  array(
                                                      ":nom" => $this->Nom,
                                                      ":cp" => $this->CP,
                                                      ":id" =>$this->ID_Pays->getIDP(),
                                                      ":id_v" => $this->ID_V
                                                  )));
            }
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_V)) {
                $result=$this->bd->selectParams("SELECT Nom,CP,ID_Pays FROM Ville WHERE ID_V=:id",
                                                array(
                                                    ":id" => $this->ID_V
                                                ));
                $this->Nom=$result[0]->Nom;
                $this->CP=$result[0]->CP;
                $this->ID_Pays=new Pays($result[0]->ID_Pays);
            }
        }
    }