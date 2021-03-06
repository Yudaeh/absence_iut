<?php
    namespace GestionAbsences\Modele;
    
    use GestionAbsences\Libs\BaseDeDonnees;

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
        public function __construct($ID_P, $Nom_P = null,
                                    $Prenom_P = null, $id_Type = null) {
            if (isset($ID_P)) {
                if ( isset($Nom_P) && isset($Prenom_P) &&
                    isset($id_Type)
                ) {
                	$this->ID_P = $ID_P;
                    $this->Nom_P = $Nom_P;
                    $this->Prenom_P = $Prenom_P;
                    $this->id_Type = new Type($id_Type);
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
         * @param int $ID_P
         */
        public function setIDP($ID_P) {
            $this->ID_P = $ID_P;
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

        /**
         * Recherche l'identifiant d'un prof, en fonction du nom et du prénom
         * @return array contenant l'id du prof
         */
        public function chercherProf(){
            $this->connexionBD();
            $info = $this->bd->selectParams("Select ID_P From personnel Where Nom_P=:nom And Prenom_P=:prenom", array(
                ":nom"=>$this->Nom_P,
                ":prenom"=>$this->Prenom_P
            ));
            return $info;
        }

        /**
         * Récupere tous les enseignants présent dans la BD
         * Renvoie un tableau d'objet Personnel
         */
        public static function findAllProf(){

            $bd=BaseDeDonnees::getInstance();
            $info = $bd->selectSansParams("Select ID_P,Nom_P,Prenom_P From personnel Where id_Type=3");
            $prof=array();
            for ($i=0;$i<count($info);$i++){
                $prof[]=new Personnel($info[$i]->ID_P,$info[$i]->Nom_P,$info[$i]->Prenom_P,3);
            }

            return $prof;
        }

        public function sauvergarderLogin() {
            $this->connexionBD();
            if (isset($this->ID_P)) {
                $this->bd->actionParams("UPDATE personnel SET Login=:login,Pwd=:pwd WHERE ID_P=:id",
                                        array(
                                            ":login" => $this->Login,
                                            ":pwd" => $this->PWD,
                                            ":id" => $this->ID_P
                                        ));
            }
        }    
	         
        public function sauvegarder() {
            $this->connexionBD();
            
            if (isset($this->ID_P)) {
            	if($this->ID_P==0){
            		echo '<br/>'.$this->Nom_P.'<br/>';
            		$this->bd->actionParams("INSERT INTO personnel(Nom_P,Prenom_P,id_Type) VALUES (:nom,:prenom,:id)",
            				array(
            						":nom" => $this->Nom_P,
            						":prenom" => $this->Prenom_P,
            						":id" => $this->id_Type->getIDT()
            				));
            		$num = $this->bd->selectSansParams("SELECT MAX(ID_P) AS ID_P FROM personnel");
            		$this->ID_P = $num[0]->ID_P;
            	} else {
            		$this->bd->actionParams("UPDATE personnel SET Nom_P=:nom,Prenom_P=:prenom,id_Type=:id
WHERE ID_P=:id_p", array(
            				":nom" => $this->Nom_P,
            				":prenom" => $this->Prenom_P,
            				":id" => $this->id_Type->getIDT(),
            				":id_p" => $this->ID_P
            		));
            	}
                
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

        /**
         * Vérifie si un login avec son mot de passe existe
         * @param $loginTest Le login que l'on test
         * @param $pwdTest Le mot de passe que l'on test
         * @return True si le login (avec mot de passe correstpondant)
         * existe, false sinon
         */
        public function loginExiste($loginTest, $pwdTest) {
            $this->connexionBD();
            $info =
                $this->bd->selectParams("SELECT Login, Pwd FROM personnel WHERE Pwd=:Password AND Login=:LOG",
                                        array(
                                            ":LOG" => $loginTest,
                                            ":Password" => $pwdTest
                                        ));

            return !empty($info) && $info[0]->Login == $loginTest && $info[0]->Pwd == $pwdTest;
        }

        /**
         * Retourne le type (l'id) d'un utilisateur en fonction de
         * son login
         * @param unknown $loginTest
         * @param unknown $pwdTest
         */
        public function getTypeFromLogin($loginTest) {
            $this->connexionBD();
            $info =
                $this->bd->selectParams("SELECT id_Type FROM personnel WHERE Login=:LOGIN",
                                        array(
                                            ":LOGIN" => $loginTest,
                                        ));

            return $info[0]->id_Type;
        }
    }