<?php
    namespace GestionAbsences\Libs;

    /**
     * Classe représentant la connexion à la base de données.
     * @author Paul PAGES
     */
    final class BaseDeDonnees {

        /**
         * Les options pour toutes les requêtes à la base de donnée.
         */
        public static $OPTIONS_DB = array(
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_SILENT
        );

        /**
         * @var BaseDeDonnees La seule instance de connexion à la base
         * de données (Pattern Singleton).
         */
        private static $instance;

        /** @var \PDO la connexion PDO à la base de données. */
        private $bd;

        /**
         * Créé la connexion à la base de données.
         */
        private function __construct() {
            // Importe le fichier de configuration.
            $config = parse_ini_file(CONFIG_BD);

            try {
                $this->bd = new \PDO(
                    $config['type'] . ':host=' . $config['host'] . ';port=' .
                    $config['port'] . ';dbname=' . $config['nom_bd'],
                    $config['login'], $config['mdp'], self::$OPTIONS_DB);
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        /**
         * Effectue une requête de sélection sans paramêtre sur la base de
         * données.
         * @param $requete string la requête à exécuter.
         * @return array
         * <ul>
         *     <li>Le résultat de la requête sous la forme d'un tableau
         *         d'objets.</li>
         *     <li>Un tableuu vide si une erreur est survenu.</li>
         * </ul>
         */
        public function selectSansParams($requete) {
            // Prépare la requête.
            $reqObj = $this->bd->prepare($requete);

            // Exécute la requête.
            $reqObj->execute();

            // Retourne les valeurs sous la forme d'un tableau d'objets.
            return $reqObj->fetchAll();
        }

        /**
         * Effectue une requête de sélection avec paramêtres sur la base de
         * données.
         * @param $requete string la requête à exécuter.
         * @param $params array un tableau contenant les paramètres sous la
         *     forme : ':nom_param' => valeur.
         * @return array
         * <ul>
         *     <li>Le résultat de la requête sous la forme d'un tableau
         *         d'objets.</li>
         *     <li>Un tableuu vide si une erreur est survenu.</li>
         * </ul>
         */
        public function selectParams($requete, $params) {
            // Prépare la requête.
            $reqObj = $this->bd->prepare($requete);

            // Remplace les paramêtres dans la requête.
            foreach ($params as $cle => $valeur) {
                $reqObj->bindParam($cle, $valeur);
            }

            // Exécute la requête.
            $reqObj->execute();

            // Retourne les valeurs sous la forme d'un tableau d'objets.
            return $reqObj->fetchAll();
        }

        /**
         * Exécute un requête de type "INSERT", "DELETE" ou "UPDATE" sur la
         * base de données.
         * @param $requete string la requête à exécuter.
         * @param $params array un tableau contenant les paramètres sous la
         *     forme : ':nom_param' => valeur.
         * @return bool
         * <ul>
         *     <li>True si l'action a été exécuté avec succès.</li>
         *     <li>False sinon.</li>
         * </ul>
         */
        public function actionParams($requete, $params) {
            // Prépare la requête.
            $reqObj = $this->bd->prepare($requete);

            // Remplace les paramêtres dans la requête.
            foreach ($params as $cle => $valeur) {
                $reqObj->bindParam($cle, $valeur);
            }

            // Exécute la requête.
            return $reqObj->execute();
        }

        public function fonctionStockee($procedure, $params) {
            // Extrait les paramêtres
            $strParams = '';

            foreach ($params as $cle => $valeur) {
                $strParams .= $cle . ', ';
            }

            $strParams = substr($strParams, 0, -2);

            // Prépare la requête.
            $reqObj = $this->bd->prepare('SELECT ' . $procedure
                                         . '(' . $strParams . ') FROM DUAL');

            // Remplace les paramêtres dans la requête.
            foreach ($params as $cle => $valeur) {
                $reqObj->bindParam($cle, $valeur);
            }

            // Exécute la requête.
            $reqObj->execute();

            return $reqObj->fetchAll();
        }

        public function procedureStockee($procedure, $params) {
            // Extrait les paramêtres
            $strParams = '';

            foreach ($params as $cle => $valeur) {
                $strParams .= $cle . ', ';
            }

            $strParams = substr($strParams, 0, -2);

            // Prépare la requête.
            $reqObj = $this->bd->prepare('CALL ' . $procedure
                                         . '(' . $strParams . ')');

            // Remplace les paramêtres dans la requête.
            foreach ($params as $cle => $valeur) {
                $reqObj->bindParam($cle, $valeur);
            }

            // Exécute la requête.
            return $reqObj->execute();
        }

        /**
         * @return BaseDeDonnees la seule instance de connexion à la base
         * de données (Pattern Singleton).
         */
        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new BaseDeDonnees();
            }

            return self::$instance;
        }
    }