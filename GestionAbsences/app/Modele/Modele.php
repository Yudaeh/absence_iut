<?php


    namespace GestionAbsences\Modele;


    use GestionAbsences\Libs\BaseDeDonnees;

    abstract class Modele {

        /** @var  BaseDeDonnees */
        protected $bd ;

        protected function connexionBD() {
            $this->bd=BaseDeDonnees::getInstance();
        }

        public abstract function sauvegarder();

        public abstract function charger();
    }