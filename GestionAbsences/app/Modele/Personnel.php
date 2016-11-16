<?php


    namespace GestionAbsences\Modele;


    class Personnel extends Modele {
        private static $DEFAULT_MDP = '0000';

        /** @var  int */
        private $ID_P;
        /** @var  string */
        private $Nom_P;
        /** @var  string */
        private $Prenom_P;
        /** @var  Type */
        private $id_Type;
        /** @var  string */
        private $Tel_P;
        /** @var  string */
        private $Email_P;
        /** @var  string */
        private $Login;
        /** @var  string */
        private $PWD;

        /**
         * Personnel constructor.
         * @param $ID_P
         * @param $Nom_P
         * @param $Prenom_P
         * @param $id_Type
         */
        public function __construct($ID_P = null, $Nom_P = null,
                                    $Prenom_P = null, $id_Type = null) {
            if (isset($ID_P)) {
                if ($ID_P <= 0 && isset($Nom_P) && isset($Prenom_P) &&
                    isset($id_Type)
                ) {
                    $this->Nom_P = $Nom_P;
                    $this->Prenom_P = $Prenom_P;
                    $this->id_Type = new Type($id_Type);
                    $this->sauvegarder();
                } else {
                    $this->ID_P = $ID_P;
                    $this->charger();
                }
            }


        }


        public function createLogin($login, $pwd) {
            $this->setLogin($login);
            if (isset($pwd)) {
                $this->setPWD($pwd);
            } else {
                $this->setPWD(self::$DEFAULT_MDP);
            }

            $this->sauvergarderLogin();
        }


        /**
         * @return mixed
         */
        public function getNomP() {
            return $this->Nom_P;
        }

        /**
         * @param mixed $Nom_P
         */
        public function setNomP($Nom_P) {
            $this->Nom_P = $Nom_P;
        }

        /**
         * @return mixed
         */
        public function getPrenomP() {
            return $this->Prenom_P;
        }

        /**
         * @param mixed $Prenom_P
         */
        public function setPrenomP($Prenom_P) {
            $this->Prenom_P = $Prenom_P;
        }

        /**
         * @return mixed
         */
        public function getIdType() {
            return $this->id_Type;
        }

        /**
         * @param mixed $id_Type
         */
        public function setIdType($id_Type) {
            $this->id_Type = $id_Type;
        }

        /**
         * @return mixed
         */
        public function getTelP() {
            return $this->Tel_P;
        }

        /**
         * @param mixed $Tel_P
         */
        public function setTelP($Tel_P) {
            $this->Tel_P = $Tel_P;
        }

        /**
         * @return mixed
         */
        public function getEmailP() {
            return $this->Email_P;
        }

        /**
         * @param mixed $Email_P
         */
        public function setEmailP($Email_P) {
            $this->Email_P = $Email_P;
        }

        /**
         * @return mixed
         */
        public function getLogin() {
            return $this->Login;
        }

        /**
         * @param mixed $Login
         */
        public function setLogin($Login) {
            $this->Login = $Login;
        }

        /**
         * @return mixed
         */
        public function getPWD() {
            return $this->PWD;
        }

        /**
         * @param mixed $PWD
         */
        public function setPWD($PWD) {
            $this->PWD = $PWD;
        }

        /**
         * @return mixed
         */
        public function getIDP() {
            return $this->ID_P;
        }

        public function sauvergarderLogin() {
            $this->connexionBD();
            if (isset($this->ID_P)) {
                $this->bd->actionParams("UPDATE personnel SET Login=:login,Pwd=:pwd WHERE ID_P=:id",
                                        array(
                                            ":login" => $this->Login,
                                            ":pws" => $this->PWD,
                                            ":id" => $this->ID_P
                                        ));
            }
        }

        public function sauvegarder() {
            $this->connexionBD();
            if (isset($this->ID_P)) {
                $this->bd->actionParams("UPDATE personnel SET Nom_P=:nom,Prenom_P=:prenom,id_Type=:id 
WHERE ID_P=:id_p", array(
                    ":nom" => $this->Nom_P,
                    ":prenom" => $this->Prenom_P,
                    ":id" => $this->id_Type->getIDT(),
                    ":id_p" => $this->ID_P
                ));
            } else {
                $this->bd->actionParams("INSERT INTO personnel(Nom_P,Prenom_P,id_Type) VALUES (:nom,:prenom,:id)",
                                        array(
                                            ":nom" => $this->Nom_P,
                                            ":prenom" => $this->Prenom_P,
                                            ":id" => $this->id_Type->getIDT(),
                                        ));
                $num =
                    $this->bd->selectSansParams("SELECT MAX(ID_P) AS ID_P FROM personnel");
                $this->ID_P = $num[0]->ID_P;
            }
        }

        public function charger() {
            $this->connexionBD();
            if (isset($this->ID_P)) {
                $info =
                    $this->bd->selectParams("SELECT Nom_P,Prenom_P,id_Type,Tel_P,Email_P,Login,Pwd FROM personnel WHERE ID_P=:id",
                                            array(
                                                ":id" => $this->ID_P
                                            ));
                if(!empty($info)){
                    $this->Nom_P = $info[0]->Nom_P;
                    $this->Prenom_P=$info[0]->Prenom_P;
                    $this->id_Type=new Type($info[0]->id_Type);
                    $this->Tel_P=$info[0]->Tel_P;
                    $this->Email_P=$info[0]->Email_P;
                    $this->Login=$info[0]->Login;
                    $this->PWD=$info[0]->Pwd;
                } else {
                    $this->Nom_P = " ";
                    $this->Prenom_P=" ";
                    $this->id_Type=new Type();
                    $this->Tel_P=" ";
                    $this->Email_P=" ";
                    $this->Login=" ";
                    $this->PWD=" ";
                }
            }
        }

        public function toString(){
            return "(".$this->getIDP().") :".$this->getNomP()." ".$this->getPrenomP().
                   " ". $this->getIdType()->getNomT();
        }
        
        
        public function loginExiste($loginTest, $pwdTest) {
        	$this->connexionBD();
        	if (isset($this->ID_P)) {
        		$info =
        		$this->bd->selectParams("SELECT Login,Pwd FROM personnel WHERE Login=:LOGIN AND Pwd=:PWD",
        				array(
        						":LOGIN" => $loginTest,
        						":PWD" => $pwdTest,
        				));
        		
        		return !empty($info);
            }
        }	
        
    }