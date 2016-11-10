<?php


    namespace GestionAbsences\Modele;


    class Absence extends Modele {

        /** @var  int */
        private $id_ab;
        /** @var  Planning */
        private $id_pla;
        /** @var  Etudiant */
        private $id_etu;
        /** @var  boolean */
        private $justify;

        /**
         * Absence constructor.
         * @param int $id_ab
         * @param Planning $id_pla
         * @param Etudiant $id_etu
         * @param bool $justify
         */
        public function __construct($id_ab,$id_pla = null,$id_etu = null,
                                    $justify = null) {
            if (isset($id_ab)) {
                $this->id_ab = $id_ab;
                if (isset($id_pla) && isset($id_etu) && isset($justify)) {
                    $this->id_pla = new Planning($id_pla);
                    $this->id_etu = new Etudiant($id_etu);
                    $this->justify = $justify;
                    $this->sauvegarder();
                } else {
                    $this->charger();
                }

            }

        }

        /**
         * @return int
         */
        public function getIdAb() {
            return $this->id_ab;
        }

        /**
         * @param int $id_ab
         */
        public function setIdAb($id_ab) {
            $this->id_ab = $id_ab;
        }

        /**
         * @return Planning
         */
        public function getIdPla() {
            return $this->id_pla;
        }

        /**
         * @param Planning $id_pla
         */
        public function setIdPla($id_pla) {
            $this->id_pla = $id_pla;
        }

        /**
         * @return Etudiant
         */
        public function getIdEtu() {
            return $this->id_etu;
        }

        /**
         * @param Etudiant $id_etu
         */
        public function setIdEtu($id_etu) {
            $this->id_etu = $id_etu;
        }

        /**
         * @return boolean
         */
        public function isJustify() {
            return $this->justify;
        }

        /**
         * @param boolean $justify
         */
        public function setJustify($justify) {
            $this->justify = $justify;
        }


        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->id_ab)) {
                $bool = 0;
                if ($this->justify) {
                    $bool = 1;
                }
                if ($this->id_ab == 0) {

                    $this->bd->actionParams("INSERT INTO absence(id_pla, id_etu, justify) VALUES (:pla,:etu,:justify)",
                                            array(
                                                ":pla" => $this->id_pla->getIdCours(),
                                                ":etu" => $this->id_etu->getINE(),
                                                ":justify" => $bool
                                            ));

                    $id =
                        $this->bd->selectSansParams("SELECT MAX(ID_ab) AS ID_ab FROM absence");
                    $this->id_ab = $id[0]->ID_ab;
                } else {
                    $this->bd->actionParams("UPDATE absence SET id_pla=:pla,id_etu=:etu,justify=:justify WHERE ID_ab=:id",
                                            array(
                                                ":pla" => $this->id_pla->getIdCours(),
                                                ":etu" => $this->id_etu->getINE(),
                                                ":justify" => $bool,
                                                ":id" => $this->id_ab
                                            ));
                }
            }

        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->id_ab)) {
                $info =
                    $this->bd->selectParams("SELECT id_pla,id_etu,justify FROM absence WHERE ID_ab=:id",
                                            array(
                                                ":id" => $this->id_ab
                                            ));

                $this->id_pla = new Planning($info[0]->id_pla);
                $this->id_etu = new Etudiant($info[0]->id_etu);
                if ($info[0]->justify == 1) {
                    $this->justify = true;
                } else {
                    $this->justify = false;
                }
            }
        }

        public function toString() {
            return "(" . $this->getIdAb() . ") :<br/> " .
                   $this->getIdPla()->toString() . "<br/>" .
                   $this->getIdEtu()->toString() . "<br/>" . $this->isJustify();
        }
    }