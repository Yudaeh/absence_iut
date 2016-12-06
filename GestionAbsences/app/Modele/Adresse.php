<?php


    namespace GestionAbsences\Modele;


    class Adresse extends Modele {
        /** @var */
        private $ID_A;
        /** @var  int */
        private $Num;
        /** @var  string */
        private $Rue;
        /** @var  Ville */
        private $ID_Ville;

        /**
         * Adresse constructor.
         * @param $ID_A
         * @param int $Num
         * @param string $Rue
         * @param Ville $ID_Ville
         */
        public function __construct($ID_A = null, $Num = null, $Rue = null,
                                    $ID_Ville = null) {
            if (isset($ID_A)) {
                if ($ID_A <= 0 && isset($Num) && isset($Rue) &&
                    isset($ID_Ville)
                ) {
                    $this->ID_A = $ID_A;
                    $this->Num = $Num;
                    $this->Rue = $Rue;
                    $this->ID_Ville = new Ville($ID_Ville);

                } else {
                    $this->ID_A = $ID_A;
                    $this->charger();
                }
            }


        }

        /**
         * @return mixed
         */
        public function getIDA() {
            return $this->ID_A;
        }

        /**
         * @return int
         */
        public function getNum() {
            return $this->Num;
        }

        /**
         * @param int $Num
         */
        public function setNum($Num) {
            $this->Num = $Num;
        }

        /**
         * @return string
         */
        public function getRue() {
            return $this->Rue;
        }

        /**
         * @param string $Rue
         */
        public function setRue($Rue) {
            $this->Rue = $Rue;
        }

        /**
         * @return Ville
         */
        public function getIDVille() {
            return $this->ID_Ville;
        }

        /**
         * @param Ville $ID_Ville
         */
        public function setIDVille($ID_Ville) {
            $this->ID_Ville = $ID_Ville;
        }

        /**
         * Recherche si une adresse existe, si modifie l'id l'adresse courante
         * avec l'id trouvé
         */
        public function recherche() {
            $this->connexionBD();

            $id =
                $this->bd->selectParams("SELECT ID_A FROM adresse WHERE Rue=:rue AND Num=:num",
                                        array(
                                            ":rue" => $this->Rue,
                                            ":num" => $this->Num
                                        ));
            if ($id != null) {

                $this->ID_A = $id[0]->ID_A;
            } else {

                $this->sauvegarder();
            }


        }

        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->ID_A)) {
                if($this->ID_A==0){
                    $this->bd->actionParams("INSERT INTO adresse(Num,Rue,ID_Ville) VALUES (:num,:rue,:id)",
                                            array(
                                                ":num" => $this->Num,
                                                ":rue" => $this->Rue,
                                                ":id" => $this->ID_Ville->getIDV()
                                            ));
                    $num =
                        $this->bd->selectSansParams("SELECT MAX(ID_A) AS ID_A FROM adresse");
                    $this->ID_A = $num[0]->ID_A;
                } else {
                    $this->bd->actionParams("UPDATE adresse SET Num=:num,Rue=:rue,ID_Ville=:id",
                                            array(
                                                ":num" => $this->Num,
                                                ":rue" => $this->Rue,
                                                ":id" => $this->ID_Ville->getIDV()
                                            ));
                }

            }
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_A)) {
                $info =
                    $this->bd->selectParams("SELECT Num,Rue,ID_Ville FROM adresse WHERE ID_A=:id",
                                            array(
                                                ":id" => $this->ID_A
                                            ));
                if (!empty($info)) {
                    $this->Num = $info[0]->Num;
                    $this->Rue = $info[0]->Rue;
                    $this->ID_Ville = new Ville($info[0]->ID_Ville);
                } else {
                    $this->Num = " ";
                    $this->Rue = " ";
                    $this->ID_Ville = new Ville();
                }
            }
        }

        public function toString() {
            return "(" . $this->getIDA() . "): " . $this->getRue() . " " .
                   $this->getNum() .
                   " " . $this->getIDVille()->getNom();
        }
    }