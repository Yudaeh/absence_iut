<?php

namespace GestionAbsences\Core;

/**
 * Classe du contrôleur par défaut, tous les contrôleurs doivent hériter de
 * cette classe.
 * @author Paul PAGES
 */
abstract class Controleur {

    /** @var string le titre de la page. */
    private $titre;

    /**
     * Créé un nouveau contrôleur.
     */
    public function __construct() {
        session_start();
    }

    /**
     * Méthode lancée par défaut sur un contrôleur.
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