<?php


    namespace GestionAbsences\Modele;


    class Planning extends Modele {

        /** @var  int */
        private $id_cours;
        /** @var  Matiere */
        private $id_matiere;
        /** @var  Date */
        private $id_date;
        /** @var  Personnel */
        private $id_prof;
        /** @var  Groupe */
        private $id_groupe;
        /** @var  Salle */
        private $id_salle;

        /**
         * Planning constructor.
         * @param int $id_cours
         * @param Matiere $id_matiere
         * @param Date $id_date
         * @param Personnel $id_prof
         * @param Groupe $id_groupe
         * @param Salle $id_salle
         */
        public function __construct($id_cours, $id_matiere = null,
                                    $id_date = null, $id_prof = null,
                                    $id_groupe = null, $id_salle = null) {
            if (isset($id_cours)) {
                $this->id_cours = $id_cours;
                if (isset($id_matiere) && isset($id_date) && isset($id_prof) &&
                    isset($id_groupe) && isset($id_salle)
                ) {
                    $this->id_matiere = new Matiere($id_matiere);
                    $this->id_date = new Date($id_date);
                    $this->id_prof = new Personnel($id_prof);
                    $this->id_groupe = new Groupe($id_groupe);
                    $this->id_salle = new Salle($id_salle);
                    $this->sauvegarder();
                } else {
                    $this->charger();
                }

            }
        }

        /**
         * @return int
         */
        public function getIdCours() {
            return $this->id_cours;
        }

        /**
         * @param int $id_cours
         */
        public function setIdCours($id_cours) {
            $this->id_cours = $id_cours;
        }

        /**
         * @return Matiere
         */
        public function getIdMatiere() {
            return $this->id_matiere;
        }

        /**
         * @param Matiere $id_matiere
         */
        public function setIdMatiere($id_matiere) {
            $this->id_matiere = $id_matiere;
        }

        /**
         * @return Date
         */
        public function getIdDate() {
            return $this->id_date;
        }

        /**
         * @param Date $id_date
         */
        public function setIdDate($id_date) {
            $this->id_date = $id_date;
        }

        /**
         * @return Personnel
         */
        public function getIdProf() {
            return $this->id_prof;
        }

        /**
         * @param Personnel $id_prof
         */
        public function setIdProf($id_prof) {
            $this->id_prof = $id_prof;
        }

        /**
         * @return Groupe
         */
        public function getIdGroupe() {
            return $this->id_groupe;
        }

        /**
         * @param Groupe $id_groupe
         */
        public function setIdGroupe($id_groupe) {
            $this->id_groupe = $id_groupe;
        }

        /**
         * @return Salle
         */
        public function getIdSalle() {
            return $this->id_salle;
        }

        /**
         * @param Salle $id_salle
         */
        public function setIdSalle($id_salle) {
            $this->id_salle = $id_salle;
        }


        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->id_cours)) {
                if ($this->id_cours == 0) {
                    $this->bd->actionParams("INSERT INTO planning(id_matiere, id_date, id_prof, id_groupe, id_salle) VALUES (:matiere,:datep,:prof,:groupe,:salle)",
                                            array(
                                                ":matiere" => $this->id_matiere->getIDM(),
                                                ":datep" => $this->id_date->getIDD(),
                                                ":prof" => $this->id_prof->getIDP(),
                                                ":groupe" => $this->id_groupe->getIDG(),
                                                ":salle" => $this->id_salle->getIDS()
                                            ));

                    $id =
                        $this->bd->selectSansParams("SELECT MAX(id_cours) AS id_cours FROM planning");
                    $this->id_cours = $id[0]->id_cours;
                } else {
                    $this->bd->actionParams("UPDATE planning SET id_matiere=:matiere,id_date=:datep,id_prof=:prof,id_groupe=:groupe,id_salle=:salle WHERE id_cours=:cours",
                                            array(
                                                ":matiere" => $this->id_matiere->getIDM(),
                                                ":datep" => $this->id_date->getIDD(),
                                                ":prof" => $this->id_prof->getIDP(),
                                                ":groupe" => $this->id_groupe->getIDG(),
                                                ":salle" => $this->id_salle->getIDS(),
                                                ":cours" => $this->id_cours
                                            ));
                }
            }
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->id_cours)) {
                $info =
                    $this->bd->selectParams("SELECT id_matiere,id_date,id_prof,id_groupe,id_salle FROM planning WHERE id_cours=:cours",
                                            array(
                                                ":cours" => $this->id_cours
                                            ));

                $this->id_matiere = new Matiere($info[0]->id_matiere);
                $this->id_date =new Date($info[0]->id_date);
                $this->id_prof =new Personnel($info[0]->id_prof);
                $this->id_groupe =new Groupe($info[0]->id_groupe);
                $this->id_salle = new Salle($info[0]->id_salle);
            }
        }

        public function toString() {
            return "(" . $this->getIdCours() . ") : " .
                   $this->getIdMatiere()->toString() . " " .
                   $this->getIdDate()->toString() . " " .
                   $this->getIdGroupe()->toString() . " " .
                   $this->getIdProf()->toString() . " " .
                   $this->getIdSalle()->toString();
        }
    }