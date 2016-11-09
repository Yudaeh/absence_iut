<?php


    namespace GestionAbsences\Modele;


    class Groupe extends Modele {
        /** @var  int */
        private $ID_G;
        /** @var  string */
        private $Nom_G;
        /** @var  Filiere */
        private $ID_fil;

        /**
         * Groupe constructor.
         * @param int $ID_G
         * @param string $Nom_G
         * @param Filiere $ID_fil
         */
        public function __construct($ID_G, $Nom_G=null,$ID_fil=null) {
            if(isset($ID_G)){
                $this->ID_G = $ID_G;
                if(isset($Nom_G) && isset($ID_fil)){
                    $this->Nom_G = $Nom_G;
                    $this->ID_fil = new Filiere($ID_fil);
                    $this->sauvegarder();
                } else {
                    $this->charger();
                }
            }


        }

        /**
         * @return int
         */
        public function getIDG() {
            return $this->ID_G;
        }

        /**
         * @param int $ID_G
         */
        public function setIDG($ID_G) {
            $this->ID_G = $ID_G;
        }

        /**
         * @return string
         */
        public function getNomG() {
            return $this->Nom_G;
        }

        /**
         * @param string $Nom_G
         */
        public function setNomG($Nom_G) {
            $this->Nom_G = $Nom_G;
        }

        /**
         * @return Filiere
         */
        public function getIDFil() {
            return $this->ID_fil;
        }

        /**
         * @param Filiere $ID_fil
         */
        public function setIDFil($ID_fil) {
            $this->ID_fil = $ID_fil;
        }



        public function sauvegarder() {
            $this->connexionBD();
            if(isset($this->ID_G)){
                if($this->ID_G==0){
                    $this->bd->actionParams("INSERT INTO groupe (Nom_G, ID_fil) VALUES (:nom,:idf)", array(
                        ":nom"=>$this->Nom_G,
                        ":idf"=>$this->ID_fil->getIDF()
                    ));

                    $num = $this->bd->selectSansParams("SELECT MAX(ID_G) AS ID_G FROM groupe");
                    $this->ID_G= $num[0]->ID_G;
                } else {
                    $this->connexionBD();
                    if(isset($this->ID_G)){
                        $this->bd->actionParams("UPDATE groupe SET Nom_G=:nom,ID_fil=:idf WHERE ID_G=:id", array(
                            ":nom"=>$this->Nom_G,
                            ":idf"=>$this->ID_fil->getIDF(),
                            ":id"=>$this->ID_G
                        ));
                    }
                }
            }
        }

        public function charger() {
            $this->connexionBD();
            if(isset($this->ID_G)){
                $info = $this->bd->selectParams("SELECT Nom_G,ID_fil FROM groupe WHERE ID_G=:id", array(
                    ":id"=>$this->ID_G
                ));
                $this->Nom_G=$info[0]->Nom_G;
                $this->ID_fil=new Filiere($info[0]->ID_fil);
            }
        }

        public function toString(){
            return "(".$this->getIDG().") : ".$this->getNomG()." ".$this->getIDFil()->getNomF();
        }
    }