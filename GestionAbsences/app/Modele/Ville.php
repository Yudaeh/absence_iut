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
         * @param null $Nom
         * @param null $CP
         * @param null $ID_Pays
         */
        public function __construct($ID_V = null, $Nom = null, $CP = null,
                                    $ID_Pays = null) {
            if (isset($ID_V)) {
                if ( isset($Nom) && isset($CP) &&
                    isset($ID_Pays)
                ) {
                    $this->ID_V = $ID_V;
                    $this->Nom = $Nom;
                    $this->CP = $CP;
                    $this->ID_Pays = new Pays($ID_Pays);


                } else {
                    $this->ID_V = $ID_V;
                    $this->charger();

                }

            }

        }

        /**
         * @return int
         */
        public function getIDV() {
            return $this->ID_V;
        }

        /**
         * @return string
         */
        public function getNom() {
            return $this->Nom;
        }

        /**
         * @param string $Nom
         */
        public function setNom($Nom) {
            $this->Nom = $Nom;
        }

        /**
         * @return string
         */
        public function getCP() {
            return $this->CP;
        }

        /**
         * @param string $CP
         */
        public function setCP($CP) {
            $this->CP = $CP;
        }

        /**
         * @return Pays
         */
        public function getIDPays() {
            return $this->ID_Pays;
        }

        /**
         * @param Pays $ID_Pays
         */
        public function setIDPays($ID_Pays) {
            $this->ID_Pays = $ID_Pays;
        }

        /**
         * Recherche si une ville existe, et si oui renvoie son id
         */
        public function recherche(){
            $this->connexionBD();
            if(isset($this->Nom)){

                $id = $this->bd->selectParams("Select ID_V From ville Where Nom=:nom AND CP=:cp", array(
                    ":nom"=>$this->Nom,
                    ":cp"=>$this->CP
                ));
                if($id !=null){

                    $this->ID_V=$id[0]->ID_V;
                } else {

                    $this->sauvegarder();
                }

            }

        }

        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->ID_V)) {
                if($this->ID_V == 0){
                    $this->bd->actionParams("INSERT INTO ville (Nom, CP, ID_Pays) VALUES (:nom,:cp,:pays)",
                                            array(
                                                ":nom" => $this->Nom,
                                                ":cp" => $this->CP,
                                                ":pays" => $this->ID_Pays->getIDP()
                                            ));
                    $num =
                        $this->bd->selectSansParams("SELECT MAX(ID_V) AS ID_V FROM ville");
                    $this->ID_V = $num[0]->ID_V;
                } else {
                    $this->bd->actionParams("UPDATE ville SET Nom=:nom,CP=:cp,ID_Pays=:id WHERE ID_V=:id_v",
                                            array(
                                                ":nom" => $this->Nom,
                                                ":cp" => $this->CP,
                                                ":id" => $this->ID_Pays->getIDP(),
                                                ":id_v" => $this->ID_V
                                            ));
                }

            }
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_V)) {
                $result =
                    $this->bd->selectParams("SELECT Nom,CP,ID_Pays FROM Ville WHERE ID_V=:id",
                                            array(
                                                ":id" => $this->ID_V

                                            ));
                if (!empty($result)) {
                    $this->Nom = $result[0]->Nom;
                    $this->CP = $result[0]->CP;
                    $this->ID_Pays = new Pays($result[0]->ID_Pays);
                } else {
                    echo 'Erreur : Aucune ville à ce numéro';
                    $this->Nom = " ";
                    $this->CP = " ";
                    $this->ID_Pays = new Pays();
                }

            }
        }

        public function toString() {
            return "(" . $this->getIDV() . "):" . $this->getNom() . "  " .
                   $this->getCP() . "  " . $this->getIDPays()->getNomP();
        }
    }