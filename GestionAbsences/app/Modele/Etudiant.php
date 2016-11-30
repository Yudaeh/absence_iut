<?php


    namespace GestionAbsences\Modele;


    class Etudiant extends Modele {

        /** @var string */
        private $INE;
        /** @var  string */
        private $Nom_E;
        /** @var  string */
        private $Prenom_E;
        /** @var  string */
        private $Tel_E;
        /** @var  int */
        private $ID_Groupe;
        /** @var  Adresse */
        private $Adresse;
        /** @var  Adresse */
        private $Adresse_P;
        /** @var  string */
        private $Email_E;

        /**
         * Etudiant constructor.
         * @param string $INE
         * @param string $Nom_E
         * @param string $Prenom_E
         * @param int $ID_Groupe
         * @param Adresse $Adresse
         * @param string $Email_E
         */
        public function __construct($INE, $Nom_E=null, $Prenom_E=null, $ID_Groupe=null, $tel=null,
                                    $Adresse=null,
                                    $Email_E=null) {
            if (isset($INE)) {
                $this->INE = $INE;
                if (isset($Nom_E) && isset($Prenom_E) && isset($ID_Groupe) &&
                    isset($tel) &&
                    isset($Adresse) && isset($Email_E)
                ) {
                    $this->Nom_E = $Nom_E;
                    $this->Prenom_E = $Prenom_E;
                    $this->ID_Groupe = new Groupe($ID_Groupe);
                    $this->Tel_E = $tel;
                    $this->Adresse = new Adresse($Adresse);
                    $this->Email_E = $Email_E;
                    $this->sauvegarder();
                } else {
                    $this->charger();
                }

            }


        }

        /**
         * @return string
         */
        public function getINE() {
            return $this->INE;
        }

        /**
         * @param string $INE
         */
        public function setINE($INE) {
            $this->INE = $INE;
        }

        /**
         * @return string
         */
        public function getNomE() {
            return $this->Nom_E;
        }

        /**
         * @param string $Nom_E
         */
        public function setNomE($Nom_E) {
            $this->Nom_E = $Nom_E;
        }

        /**
         * @return string
         */
        public function getPrenomE() {
            return $this->Prenom_E;
        }

        /**
         * @param string $Prenom_E
         */
        public function setPrenomE($Prenom_E) {
            $this->Prenom_E = $Prenom_E;
        }

        /**
         * @return int
         */
        public function getIDGroupe() {
            return $this->ID_Groupe;
        }

        /**
         * @param int $ID_Groupe
         */
        public function setIDGroupe($ID_Groupe) {
            $this->ID_Groupe = $ID_Groupe;
        }

        /**
         * @return Adresse
         */
        public function getAdresse() {
            return $this->Adresse;
        }

        /**
         * @param Adresse $Adresse
         */
        public function setAdresse($Adresse) {
            $this->Adresse = $Adresse;
        }

        /**
         * @return Adresse
         */
        public function getAdresseP() {
            return $this->Adresse_P;
        }

        /**
         * @param Adresse $Adresse_P
         */
        public function setAdresseP($Adresse_P) {
            $this->Adresse_P = $Adresse_P;
        }

        /**
         * @return string
         */
        public function getEmailE() {
            return $this->Email_E;
        }

        /**
         * @param string $Email_E
         */
        public function setEmailE($Email_E) {
            $this->Email_E = $Email_E;
        }

        public function update() {
            $this->connexionBD();
            if (isset($this->INE)) {
                $this->bd->actionParams("UPDATE etudiant SET Nom_E=:nom,Prenom_E=:prenom,ID_Groupe=:idG,Tel_E=:tel,Adresse=:adresse,Adresse_P=:adresseP,Email_E=:email WHERE INE=:INE",
                                        array(
                                            ":INE" => $this->INE,
                                            ":nom" => $this->Nom_E,
                                            ":prenom" => $this->Prenom_E,
                                            ":idG" => $this->ID_Groupe,
                                            ":tel" => $this->Tel_E,
                                            ":adresse" => $this->Adresse,
                                            ":email" => $this->Email_E
                                        ));
            }
        }


        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->INE)) {
                $this->bd->actionParams("INSERT INTO etudiant(INE, Nom_E, Prenom_E, ID_Groupe, Tel_E, Adresse, Email_E) VALUES (:INE,:nom,:prenom,:idG,:tel,:adresse,:email)",
                                        array(
                                            ":INE" => $this->INE,
                                            ":nom" => $this->Nom_E,
                                            ":prenom" => $this->Prenom_E,
                                            ":idG" => $this->ID_Groupe->getIDG(),
                                            ":tel" => $this->Tel_E,
                                            ":adresse" => $this->Adresse->getIDA(),
                                            ":email" => $this->Email_E
                                        ));
            }
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->INE)) {
                $info =
                    $this->bd->selectParams("SELECT Nom_E,Prenom_E,ID_Groupe,Tel_E,Adresse,Adresse_P,Email_E FROM etudiant WHERE INE=:ine",
                                            array(
                                                ":ine" => $this->INE
                                            ));

                $this->Nom_E = $info[0]->Nom_E;
                $this->Prenom_E = $info[0]->Prenom_E;
                $this->ID_Groupe = new Groupe($info[0]->ID_Groupe);
                $this->Tel_E = $info[0]->Tel_E;
                $this->Adresse = new Adresse($info[0]->Adresse);
                $this->Adresse_P = new Adresse($info[0]->Adresse_P);
                $this->Email_E = $info[0]->Email_E;
            }
        }

        public function toString() {
            return "(" . $this->getINE() . ") : " . $this->getNomE() . " " .
                   $this->getPrenomE() . " " . $this->getIDGroupe()->toString();
        }
    }