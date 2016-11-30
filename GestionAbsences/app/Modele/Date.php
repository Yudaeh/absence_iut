<?php


    namespace GestionAbsences\Modele;


    class Date extends Modele {

        /** @Var int */
        private $ID_D;
        /** @var  int */
        private $Heure_deb;
        /** @var  int */
        private $Heure_fin;
        /** @var  int */
        private $jour;
        /** @var  int */
        private $mois;
        /** @var  int */
        private $an;

        /**
         * Date constructor.
         * @param $ID_D
         * @param int $Heure_deb
         * @param int $Heure_fin
         * @param int $jour
         * @param int $mois
         * @param int $an
         */
        public function __construct($ID_D, $Heure_deb = null, $Heure_fin = null,
                                    $jour = null, $mois = null,
                                    $an = null) {
            if (isset($ID_D)) {
                $this->ID_D = $ID_D;
                if (isset($Heure_deb) && isset($Heure_fin) &&
                    isset($jour) && isset($mois) && isset($an)
                ) {

                    $this->Heure_deb = $Heure_deb;
                    $this->Heure_fin = $Heure_fin;
                    $this->jour = $jour;
                    $this->mois = $mois;
                    $this->an = $an;

                } else {
                    $this->charger();
                }

            }


        }

        /**
         * @return mixed
         */
        public function getIDD() {
            return $this->ID_D;
        }

        /**
         * @param mixed $ID_D
         */
        public function setIDD($ID_D) {
            $this->ID_D = $ID_D;
        }

        /**
         * @return int
         */
        public function getHeureDeb() {
            return $this->Heure_deb;
        }

        /**
         * @param int $Heure_deb
         */
        public function setHeureDeb($Heure_deb) {
            $this->Heure_deb = $Heure_deb;
        }

        /**
         * @return int
         */
        public function getHeureFin() {
            return $this->Heure_fin;
        }

        /**
         * @param int $Heure_fin
         */
        public function setHeureFin($Heure_fin) {
            $this->Heure_fin = $Heure_fin;
        }

        /**
         * @return int
         */
        public function getJour() {
            return $this->jour;
        }

        /**
         * @param int $jour
         */
        public function setJour($jour) {
            $this->jour = $jour;
        }

        /**
         * @return int
         */
        public function getMois() {
            return $this->mois;
        }

        /**
         * @param int $mois
         */
        public function setMois($mois) {
            $this->mois = $mois;
        }

        /**
         * @return int
         */
        public function getAn() {
            return $this->an;
        }

        /**
         * @param int $an
         */
        public function setAn($an) {
            $this->an = $an;
        }



        public function chercherDate(){
            $this->connexionBD();
            $info = $this->bd->selectParams("Select ID_D From date WHERE Heure_deb=:hd AND Heure_fin=:hf AND jour=:jour AND mois=:mois AND date.an=:an ", array(
                ":hd" => $this->Heure_deb,
                ":hf" => $this->Heure_fin,
                ":jour" => $this->jour,
                ":mois" => $this->mois,
                ":an" => $this->an
            ));
            return $info;
        }

        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->ID_D)) {
                if ($this->ID_D == 0) {
                  $this->bd->actionParams("INSERT INTO date(Heure_deb,Heure_fin,jour,mois,an) VALUES (:hd,:hf,:jour,:mois,:an)",
                                            array(
                                                ":hd" => $this->Heure_deb,
                                                ":hf" => $this->Heure_fin,
                                                ":jour" => $this->jour,
                                                ":mois" => $this->mois,
                                                ":an" => $this->an


                                            ));

                    $num =
                        $this->bd->selectSansParams("SELECT MAX(ID_D) AS ID_D FROM date ");
                    $this->ID_D = $num[0]->ID_D;
                } else {
                    $this->bd->actionParams("UPDATE date SET Heure_deb=:hd,Heure_fin=:hf,jour=:jour,mois=:mois,an=:an WHERE ID_D=:id",
                                            array(
                                                ":hd" => $this->Heure_deb,
                                                ":hf" => $this->Heure_fin,
                                                ":jour" => $this->jour,
                                                ":mois" => $this->mois,
                                                ":an" => $this->an,
                                                ":id" => $this->ID_D
                                            ));
                }

            }

        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_D)) {
                $info =
                    $this->bd->selectParams("SELECT Heure_deb,Heure_fin,jour,mois,an FROM date WHERE ID_D=:id",
                                            array(
                                                ":id" => $this->ID_D
                                            ));

                $this->Heure_deb = $info[0]->Heure_deb;
                $this->Heure_fin = $info[0]->Heure_fin;
                $this->jour = $info[0]->jour;
                $this->mois = $info[0]->mois;
                $this->an = $info[0]->an;
            }
        }

        public function toString(){
            return "(".$this->getIDD().") : ".$this->getHeureDeb()."h =>".$this->getHeureFin().
                   "h le ".$this->getJour()."/".$this->getMois()."/".$this->getAn();
        }
    }