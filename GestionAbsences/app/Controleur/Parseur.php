<?php


    namespace GestionAbsences\Controleur;

    use GestionAbsences\Core\Controleur;
    use GestionAbsences\Modele\Date;
    use GestionAbsences\Modele\Groupe;
    use GestionAbsences\Modele\Matiere;
    use GestionAbsences\Modele\Personnel;
    use GestionAbsences\Modele\Salle;


    class Parseur extends Controleur {

        /**
         * Méthode lancée par défaut sur un contrôleur.
         */
        public function index() {
            #$bd = BaseDeDonnees::getInstance();
            #var_dump($bd->selectSansParams("SELECT * FROM Pays"));
            $this->testParse();
        }

        /**
         * Récuperer l'heure de début d'un cours
         * @param $fichier nom du ficher qui sera parser
         * @return array Valeur que l'on aura trouver avec parsage
         */
        function analyseHD($fichier) {
            $planning = fopen($fichier, "r");
            $tab = array();
            $tabRegex = array();
            $tabResult = array();
            $regex1 =
                "/^([A-Z]+):(\\d{4})(\\d{2})(\\d{2})T(\\d{2})(\\d{2})(\\d{2})/";
            while (($ligne = fgets($planning)) != false) {
                array_push($tab, $ligne);
                // var_dump($ligne);
                // echo '<br />';
                preg_match($regex1, $ligne, $tabRegex);
                if (!empty($tabRegex) && $tabRegex[1] == "DTSTART") {
                    $tabRegex[5] = intval($tabRegex[5]) + 2;
                    $tabResult[] = $tabRegex;
                }
            }

            return $tabResult;
        }

        /**
         * récupére l'heure de fin du cours
         * @param $fichier nom du ficher qui sera parser
         * @return array Valeur que l'on aura trouver avec parsage
         */
        function analyseHF($fichier) {
            $planning = fopen($fichier, "r");
            $tab = array();
            $tabRegex = array();
            $tabResult2 = array();
            $regex1 =
                "/^([A-Z]+):(\\d{4})(\\d{2})(\\d{2})T(\\d{2})(\\d{2})(\\d{2})/";
            while (($ligne = fgets($planning)) != false) {
                array_push($tab, $ligne);
                preg_match($regex1, $ligne, $tabRegex);
                if (!empty($tabRegex) && $tabRegex[1] == "DTEND") {
                    $tabRegex[5] = intval($tabRegex[5]) + 2;
                    $tabResult2[] = $tabRegex;
                    // echo $tabRegex[2].'/'.$tabRegex[3].'/'.$tabRegex[4].' '.
                    //     $tabRegex[5]. ':'.$tabRegex[6]. '<br />';
                }
            }

            return $tabResult2;
        }

        /**
         * récupére la matière du cours
         * @param $fichier nom du ficher qui sera parser
         * @return array Valeur que l'on aura trouver avec parsage
         */
        function analyseCours($fichier) {
            $planning = fopen($fichier, "r");
            $tab = array();
            $tabRegex = array();
            $tabResult = array();
            $regex1 = "/^([A-Z]+):(\\X+)/";
            while (($ligne = fgets($planning)) != false) {
                array_push($tab, $ligne);
                preg_match($regex1, $ligne, $tabRegex);
                if (!empty($tabRegex) && $tabRegex[1] == "SUMMARY") {
                    $tabResult[] = $tabRegex;
                }
            }

            return $tabResult;
        }

        /**
         * Récupére le salle où doit se passer le cours
         * @param $fichier nom du ficher qui sera parser
         * @return array Valeur que l'on aura trouver avec parsage
         */
        function analyseSalle($fichier) {
            $planning = fopen($fichier, "r");
            $tab = array();
            $tabRegex = array();
            $tabResult = array();
            $regex1 = "/^([A-Z]+):([A-Z]\\d{3})/";
            while (($ligne = fgets($planning)) != false) {
                array_push($tab, $ligne);
                preg_match($regex1, $ligne, $tabRegex);
                if (!empty($tabRegex) && $tabRegex[1] == "LOCATION") {
                    $tabResult[] = $tabRegex;
                }
            }

            return $tabResult;
        }

        /**
         * Récupére nom+prénom du prof et le groupe
         * @param $fichier nom du ficher qui sera parser
         * @return array Valeur que l'on aura trouver avec parsage
         */
        function analyseProf($fichier) {
            $planning = fopen($fichier, "r");
            $tab = array();
            $tabRegex = array();
            $tabResult = array();
            $regex1 = "/^([A-Z]+):\\\\[n](\\X+)\\\\[n](\\X+)\\s(\\X+)\\\\[n]/";
            while (($ligne = fgets($planning)) != false) {
                array_push($tab, $ligne);
                preg_match($regex1, $ligne, $tabRegex);
                if (!empty($tabRegex) && $tabRegex[1] == "DESCRIPTION") {
                    $tabResult[] = $tabRegex;
                }
            }

            return $tabResult;
        }

        /**
         * Affiche correctement une date
         * @param $tab tableau contenant les informations sur la date
         * @param $i ligne où l'on doit chercher les informations
         */
        function affichageH($tab, $i) {

            echo $tab[$i][2] . '/' . $tab[$i][3] . '/' . $tab[$i][4] . ' ' .
                 $tab[$i][5] .
                 ':' . $tab[$i][6] . '<br />';

        }

        /**
         * Vérifie si une date est fonctionnelle, si elle existe ou pas dans la
         * BD
         * @param $tabHD Tableau contenant l'heure de début
         * @param $tabHF Tableau contenant l'heure de fin
         * @param $i ligne des tableaux que l'on doit fouiller
         * @return true si la date est dans la BD, false si non existant ou
         *     multiple
         */
        function verifDate($tabHD, $tabHF, $i) {
            $heureD = $tabHD[$i][5] + $tabHD[$i][6] / 100;
            $heureF = $tabHF[$i][5] + $tabHF[$i][6] / 100;
            $date = new Date(0, $heureD, $heureF, $tabHD[$i][4], $tabHD[$i][3],
                             $tabHD[$i][2]);
            $info = $date->chercherDate();
            if ($info != null) {
                if (count($info) == 1) {
                    $date->setIDD($info[0]->ID_D);

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

        /**
         * Vérifie si une matière est fonctionnelle, si elle existe ou pas dans
         * la BD
         * @param $tabC Tableau contenant les matières
         * @param $i ligne des tableaux que l'on doit fouiller
         * @return true si la matière est dans la BD, false si non existant ou
         *     multiple
         */
        function verifCours($tabC, $i) {
            $matiere = new Matiere(0, $tabC[$i][2]);
            $info = $matiere->chercherMatiere();
            if ($info != null) {
                if (count($info) == 1) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            }
        }

        /**
         * Vérifie si un groupe existe bien dans la BD ou pas
         * @param $tabDesc Tableau contenant le groupe
         * @param $i ligne contenant les informations sur le groupe
         * @return true si le groupe est dans la BD, false si non existant ou
         *     multiple
         */
        function verifGroupe($tabDesc, $i) {
            $groupe = new Groupe(0, $tabDesc[$i][2], 1);
            $info = $groupe->chercherGroupe();
            if ($info != null) {
                if (count($info) == 1) {
                    $groupe->setIDG($info[0]->ID_G);

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * Vérifie si une salle est fonctionnelle, si elle existe ou pas dans
         * la BD
         * @param $tabS Tableau contenant la salle
         * @param $i ligne contenant les informations sur la salle
         * @return true si la salle est dans la BD, false si non existant ou
         *     multiple
         */
        function verifSalle($tabS, $i) {
            $batiment = substr($tabS[$i][2], 0, 1);
            $num = substr($tabS[$i][2], 1, 3);
            $salle = new Salle(0, $tabS[$i][2], $batiment, $num);
            $info = $salle->chercherSalle();
            if ($info != null) {
                if (count($info) == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * Vérifie si un enseignant est fonctionnel, si il existe ou pas dans
         * le BD
         * @param $tabP Tableau des enseignants
         * @param $i ligne contenant les informations de l'enseignants
         * @return true si l'enseignant est dans la BD, false si non existant
         *     ou multiple
         */
        function verifProf($tabP, $i) {
            $prof = new Personnel(0, $tabP[$i][3], $tabP[$i][4]);
            $info = $prof->chercherProf();
            // 1ère vérification
            if ($info != null) {
                if (count($info) == 1) {
                    $prof->setIDP($info[0]->ID_P);

                    return true;
                } else {
                    return false;
                }
            } else {
                // pas de prof trouvé
                return false;

            }
        }

        /**
         * Création de la date
         * @param $tabHD Tableau contenant la date de début
         * @param $tabHF Tableau contenant la date de fin
         * @param $i Ligne contenant les informations
         * @return Date
         */
        function creerDate($tabHD, $tabHF, $i) {
            $heureD = $tabHD[$i][5] + $tabHD[$i][6] / 100;
            $heureF = $tabHF[$i][5] + $tabHF[$i][6] / 100;
            $date = new Date(0, $heureD, $heureF, $tabHD[$i][4], $tabHD[$i][3],
                             $tabHD[$i][2]);
            $info = $date->chercherDate();
            $date->setIDD($info[0]->ID_D);
            return $date;
        }

        /**
         * Création de la date
         * @param $tabC Tableau contenant la matière
         * @param $i ligne contenant les informations
         * @return Matiere
         */
        function creerMatiere($tabC, $i) {
            $matiere = new Matiere(0, $tabC[$i][2]);
            $info = $matiere->chercherMatiere();
            $matiere->setIDM($info[0]->ID_M);
            return $matiere;
        }

        /**
         * Création de la Salle
         * @param $tabS Tableau contenant la matière
         * @param $i ligne contenant les informations
         * @return Salle
         */
        function creerSalle($tabS, $i) {
            $batiment = substr($tabS[$i][2], 0, 1);
            $num = substr($tabS[$i][2], 1, 3);
            $salle = new Salle(0, $tabS[$i][2], $batiment, $num);
            $info = $salle->chercherSalle();
            $salle->setIDS($info[0]->ID_S);
            return $salle;

        }

        /**
         * Création d'un enseignant
         * @param $tabP Tableau contenant les informations sur les enseignants
         * @param $i ligne contenant les informations sur un enseignant spécifique
         * @return Personnel
         */
        function creerProf($tabP, $i) {
            $prof = new Personnel(0, $tabP[$i][3], $tabP[$i][4]);
            $info = $prof->chercherProf();
            $prof->setIDP($info[0]->ID_P);
            return $prof;

        }

        function creerGroupe($tabDesc, $i) {
            $groupe = new Groupe(0, $tabDesc[$i][2], 1);
            $info = $groupe->chercherGroupe();
            $groupe->setIDG($info[0]->ID_G);
            return $groupe;
        }

        function testParse() {
            $fichier = "ADECaI-INFORMATIQUE.ics";
            // $fichier = "ADECaI-INFOCOM.ics";

            $tabHD = $this->analyseHD($fichier);
            $tabHF = $this->analyseHF($fichier);
            $tabC = $this->analyseCours($fichier);
            $tabS = $this->analyseSalle($fichier);
            $tabDesc = $this->analyseProf($fichier);
            $tabProbs = array(array());

            for ($i = 0; $i < count($tabHD); $i++) {


                $tabProbs[$i][0] = $this->verifDate($tabHD, $tabHF, $i);
                //echo $this->affichageH($tabHD, $i);
                //echo $this->affichageH($tabHF, $i);
                if (!empty($tabC)) {
                    $tabProbs[$i][1] = $this->verifCours($tabC, $i);
                }
                if (!empty($tabS[$i])) {
                    $tabProbs[$i][2] = $this->verifSalle($tabS, $i);
                }
                if (!empty($tabDesc[$i])) {
                    $tabProbs[$i][3] = $this->verifProf($tabDesc, $i);
                }
                if (!empty($tabDesc[$i])) {

                    $tabProbs[$i][4] = $this->verifGroupe($tabDesc, $i);


                }


            }
            for ($i = 0; $i < count($tabProbs); $i++) {
                $ok=0;
                echo ' ------- <br/> ';
                for ($y = 0; $y < count($tabProbs[$i]); $y++) {

                    if (isset($tabProbs[$i][$y])) {
                        if ($tabProbs[$i][$y]) {
                            if ($y == 0) {
                                $date = $this->creerDate($tabHD, $tabHF, $i);

                                $ok++;
                            } else if ($y == 1) {
                                $matiere = $this->creerMatiere($tabC, $i);

                                $ok++;
                            } else if ($y == 2) {
                                $salle = $this->creerSalle($tabS, $i);

                                $ok++;
                            } else if ($y == 3) {
                                $prof = $this->creerProf($tabDesc, $i);

                                $ok++;
                            } else if ($y == 4) {
                                $groupe= $this->creerGroupe($tabDesc, $i);

                                $ok++;
                            }

                        } else {
                            if ($y == 0) { // Date
                                $date = $this->creerDate($tabHD, $tabHF, $i);
                                $date->sauvegarder();
                            } else if ($y == 1) { // Matière
                                //Selectionne une matière

                            } else if ($y == 2) { // Salle
                                //Selectionne une salle
                            } else if ($y == 3) { // Prof
                                $allprof=Personnel::findAllProf();
                            } else if ($y == 4) { // Groupe

                            }
                        }
                    } else {
                       // echo 'introuvable';
                    }


                }
                echo 'nombre de variable ok:'.$ok.'<br/>';
                echo ' ------- <br/><br/> ';
            }
        }

    }
