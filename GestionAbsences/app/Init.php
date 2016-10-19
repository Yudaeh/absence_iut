<?php
    use GestionAbsences\Core\Application;

    // Définitions des constantes pour l'ensemble des pages.
    define('URL_PUBLIC_FOLDER', 'public');
    define('URL_PROTOCOL', 'http://');
    define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
    define('URL_SUB_FOLDER',
           str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
    define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . '/');

    // Fichiers de configuration.
    define('CONFIG_BD', '../conf/bd.ini');

    // Les différents modules du site.
    define('CONTROLEURS', '../app/Controleur/');
    define('VUES', '../app/Vue/');
    define('COMMON', '../app/Vue/_Common/');
    define('MODELES', '../app/Modele/');

    // Les constantes du site.
    define('SITE_ROOT', 'GestionAbsences');
    define('SITE_NAME', 'Gestion Absences');
    
    define('FOUNDATION_CSS', '../public/css/foundation.css');
    define('FOUNDATION_APP_CSS','../public/css/app.css');
    define('FOUNDATION_JQUERY','../public/js/vendor/jquery.js');
    define('FOUNDATION_WHAT_INPUT','../public/js/vendor/what-input.js');
    define('FOUNDATION_JS','../public/js/vendor/foundation.js');
    define('FOUNDATION_APP_JS','../public/js/app.js');

    /**
     * Fonction d'auto-chargment des classes requises.<br>
     * Cette fonction est appelée directement par PHP avec l'instrcution "use".
     * @param $classe string le chemin de la classe à charger.
     */
    function __autoload($classe) {
        // Modifie le chemin à cause de l'architecture du projet.

        $classe = explode("\\", $classe);
        $classe[0] = "app";
        array_unshift($classe, "..");

        // Importe la classe une seule fois.
        include_once implode('\\', $classe) . '.php';
    }

    // Routage.
    $app = new Application();