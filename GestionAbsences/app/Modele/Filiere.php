<?php


    namespace GestionAbsences\Modele;


    class Filiere extends Modele {

        /** @var  int */
        private $ID_F;
        /** @var  string */
        private $Nom_F;
        /** @var  Departement */
        private $id_dep;

        /**
         * Filiere constructor.
         * @param int $ID_F
         * @param string $Nom_F
         * @param Departement $id_dep
         */
        public function __construct($ID_F, $Nom_F = null, $id_dep = null) {
            if (isset($ID_F)) {
                $this->ID_F = $ID_F;
                if (isset($Nom_F) && isset($id_dep)) {
                    $this->Nom_F = $Nom_F;
                    $this->id_dep = new Departement($id_dep);
                } else {
                    $this->charger();
                }
            }


        }

        /**
         * @return int
         */
        public function getIDF() {
            return $this->ID_F;
        }

        /**
         * @param int $ID_F
         */
        public function setIDF($ID_F) {
            $this->ID_F = $ID_F;
        }

        /**
         * @return string
         */
        public function getNomF() {
            return $this->Nom_F;
        }

        /**
         * @param string $Nom_F
         */
        public function setNomF($Nom_F) {
            $this->Nom_F = $Nom_F;
        }

        /**
         * @return Departement
         */
        public function getIdDep() {
            return $this->id_dep;
        }

        /**
         * @param Departement $id_dep
         */
        public function setIdDep($id_dep) {
            $this->id_dep = $id_dep;
        }

        public function sauvegarder() {
            $this->connexionBD();

            if (isset($this->ID_F)) {
            	
                if ($this->ID_F == 0) {
                	echo "lol";
                    $this->bd->actionParams("INSERT INTO filiere(Nom_F, Id_dep) VALUES (:nom,:id) ",
                                            array(
                                                ":nom" => $this->Nom_F,
                                                ":id" => $this->id_dep->getIDD()
                                            ));
                    $num = $this->bd->selectSansParams("SELECT MAX(ID_F) as ID_F FROM filiere");
                    $this->ID_F=$num[0]->ID_F;
                } else {
                    $this->bd->actionParams("UPDATE filiere Set Nom_F=:nom,Id_dep=:idd WHERE ID_F=:id", array(
                        ":nom" => $this->Nom_F,
                        "idd"=>$this->id_dep->getIDD(),
                        ":id" => $this->ID_F
                    ));
                }
            }
        }
        
        public function getAll() {
        	$this->connexionBD();
        	$info =
        	$this->bd->selectParams("SELECT ID_F,Nom_F,ID_Dep FROM filiere",
        			array(
        			));
        	
        	return $info;
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_F)) {
                $info = $this->bd->selectParams("SELECT Nom_F,id_dep FROM filiere WHERE ID_F=:id", array(
                                                      ":id" => $this->ID_F
                                                  ));

                $this->Nom_F=$info[0]->Nom_F;
                $this->id_dep=new Departement($info[0]->id_dep);
            }
        }

        public function toString(){
            return "(".$this->getIDF().") : ".$this->getNomF()." ".$this->getIdDep()->getNomD();
        }
    }