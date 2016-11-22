<?php
    use GestionAbsences\Core\Application;

    // D�finitions des constantes pour l'ensemble des pages.
    define('URL_PUBLIC_FOLDER', 'public');
    define('URL_PROTOCOL', 'http://');
    define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
    define('URL_SUB_FOLDER',
           str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
    define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . '/');

    // VIEWS

    
    // Fichiers de configuration.
    define('CONFIG_BD', '../conf/bd.ini');

    // Les diff�rents modules du site.
    define('CONTROLEURS', '../app/Controleur/');
    define('VUES', '../app/view/');
    define('COMMON', '../app/Vue/_Common/');
    define('MODELES', '../app/Modele/');

    // Les constantes du site.
    define('SITE_ROOT', 'GestionAbsences');
    define('SITE_NAME', 'Gestion Absences');
    
    define('HEADER','../app/view/partial/header.php');
    define('FOOTER','../app/view/partial/footer.php');

    /**
     * Fonction d'auto-chargment des classes requises.<br>
     * Cette fonction est appel�e directement par PHP avec l'instrcution "use".
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