<?php

namespace GestionAbsences\Core;

/**
 * Classe du contr�leur par d�faut, tous les contr�leurs doivent h�riter de
 * cette classe.
 * @author Maxime Brugel
 */
abstract class Controleur {

    /** @var string le titre de la page. */
    private $titre;

    /**
     * Cr�e un nouveau contr�leur.
     */
    public function __construct() {
        session_start();
    }

    /**
     * Méthode lancée par défaut sur le constructeur
     */
    public abstract function index();
    
    /**
     *
     * @return string le titre de la page.
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Modifie le titre de la page.
     * @param $titre string le titre de la page.
     */
    public function setTitre($titre) {
        $this->titre .= ' - ' . $titre;
    }
    
}