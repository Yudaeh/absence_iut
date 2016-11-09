<?php

namespace GestionAbsences\Core;

/**
 * Classe permettant d'effectuer le routage vers le contrôleur de la page
 * d�sir�e via l'URL et d'appeler la m�thode avec les arguments contenues dans
 * l'URL pour afficher la page.
 * @author Maxime Brugel
 */
final class Application {

    /** @var Controleur le contrôleur de la page demand�e. */
    private $controleur;

    /** @var string la m�thode du contrôleur à appeler. */
    private $methode;

    /** @var array un tableau contenant les arguments de la m�thode. */
    private $args;

    /**
     * Donne le contr�le de la page au contr�leur pass� en argument dans l'URL
     * et ex�cute la m�thode du contr�leur avec les arguments pass�s en
     * arguments dans l'URL.<br> Si aucun contr�leur ne correspond au contr�leur
     * pass� en argument, affiche une page d'erreur.
     */
    public function __construct() {
        
        // Par d�faut
        $this->methode = 'index';
        $this->params = array();
        
        // D�coupe l'URL
        $url = $this->decouperURL();
        
        // Le nom du contr�leur.
        $controleur = isset($url) ? $url[0] : 'Accueil';
        
        // V�rifie si le contr�leur existe
        if (file_exists(CONTROLEURS . $controleur . '.php')) {
            
            /*
             * Si oui on passe la 1ere lettre du contr�leur de l'URL en
             * majuscule pour correspondre au nom du contrôleur dans
             * l'application.
             */
            $url[0] = ucfirst($controleur);
            
            // Affectation du nom du contr�leur
            $this->controleur = $controleur;
            
            // Enlève le nom du contr�leur du tableau de l'URL
            unset($url[0]);
            
            // Importe le contr�leur
            require_once CONTROLEURS . $controleur . '.php';
            
            // Ajout du namespace
            $controleur =  SITE_ROOT . '\Controleur\\' . $controleur;
            
            // Cr�� le contr�leur
            $this->controleur = new $controleur();
            
            // V�rifie que le contr�leur a appeler est bien un contrôleur.
            if (!($this->controleur instanceof Controleur)) {
                header('Location: /projects/absence_iut/GestionAbsences/Error');
                
                return;
            }
            
            /*
             * Si il y a une m�thode pass�e en argument dans l'URL et qu'elle
             * existe dans le contr�leur
             */
            if (isset($url[1]) && method_exists($this->controleur, $url[1])) {
                
                // On l'appelle
                $this->methode = $url[1];
                
                // Enlève le nom de la m�thode du tableau de l'URL
                unset($url[1]);
            }
            
            // Cr�� un objet repr�sentant la m�thode.
            $methode = new \ReflectionMethod($this->controleur, $this->methode);
            
            // V�rifie que la m�thode est appelable.
            if (!$methode->isPublic()) {
                // $this->error();
                // TODO
                return;
            }
            
            // Si il reste des arguments pour la m�thode dans le tableau de
            // l'URL
            $this->params = $url ? array_values($url) : [];
            
            // On appelle la m�thode avec ses arguments
            call_user_func_array(
                    [
                        $this->controleur, $this->methode
                    ], $this->params);
        } else {
            // Si la page n'est pas connue
            header('Location: /projects/absence_iut/GestionAbsences/Error');;
            
        }
    }

    /**
     * D�coupe l'URL en plusieurs cha�nes de caract�res par rapport au caract�re
     * '/' et les placent dans un tableau.
     * @return array le tableau contenant l'URL d�coup�e, ou null si aucune URL
     *         est pr�sente.
     */
    private function decouperURL() {
        if (isset($_GET['url'])) {
            
            // V�rifie que l'URL est valide.
            $url = filter_var(rtrim($_GET['url']), FILTER_SANITIZE_URL);
            
            /*
             * On cr�� un tableau des �l�ments de l'URL en s�parant chaque
             * �l�ment du tableau en fonction du '/' dans l'URL.
             */
            return explode('/', $url);
        }
        // else
        return null;
    }
}