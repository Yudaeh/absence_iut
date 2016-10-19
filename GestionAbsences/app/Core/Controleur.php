<?php

namespace GestionAbsences\Core;

/**
 * Classe du contr�leur par d�faut, tous les contr�leurs doivent h�riter de
 * cette classe.
 * @author Paul PAGES
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
     * M�thode lanc�e par d�faut sur un cont�leur.
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