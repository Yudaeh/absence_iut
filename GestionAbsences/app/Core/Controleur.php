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
     * Crée un nouveau contrôleur.
     */
    public function __construct() {
        session_start();
    }

    /**
     * Méthode lancée par défaut sur un contôleur.
     */
    public abstract function index();
    
    /**
     * Effectue un rendu de la vue
     * @param $view chemin de la vue
     */
    public abstract function render($view);
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