<?php
class Utilisateur{
    private $db;
    private $insert; // Étape 1
    private $connect;
    private $select;
    private $afficher;
    private $role;
    private $modifier;
    private $modifierPass;
    private $delete;
   
    public function __construct($db)
    {
        $this->db = $db;
        $this->insert = $db->prepare("insert into Utilisateur(EmailUtilisateur, MdpUtilisateur, RoleUtilisateur) values(:email, :mdp, :role)");   // Étape 2     
        $this->connect = $db->prepare("select EmailUtilisateur, RoleUtilisateur, MdpUtilisateur from Utilisateur where EmailUtilisateur = :email ");
        $this->select = $db->prepare("select email, idRole, nom, prenom, r.libelle as libellerole from utilisateur u, role r where u.idRole = r.id order by nom");
        $this->afficher = $db->prepare("select email, idRole, nom, prenom, r.libelle as libellerole from utilisateur u, role r where u.idRole = r.id AND email = :email");
        $this->role = $db->prepare("select id, libelle from role");
        $this->modifier = $db->prepare("UPDATE utilisateur set nom = :nom, prenom = :prenom, idRole = :idRole WHERE email = :email");
        $this->modifierPass = $db->prepare("UPDATE utilisateur set mdp = :mdp WHERE email = :email");
        $this->delete = $db->prepare("DELETE from utilisateur where email = :email");
    }
    
    public function insert($email, $mdp, $role)
    { // Étape 3
        $r = true;
        $this->insert->execute(array(':email'=>$email, ':mdp'=>$mdp, ':role'=>$role));
        if ($this->insert->errorCode()!=0)
        {
            print_r($this->insert->errorInfo());  
            $r=false;
        }
        return $r;
    }
    
    public function connect($email){
        $this->connect->execute(array(':email'=>$email));
        if($this->connect->errorCode()!=0){
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }
    
    public function select(){
        
        $this->select->execute();
        if($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    
    public function afficher($email){
        $this->afficher->execute(array(':email'=>$email));
        if($this->afficher->errorCode()!=0){
            print_r($this->afficher->errorInfo());
        }
        return $this->afficher->fetchAll();
        
    }
    
    public function role(){
        $this->role->execute();
        if($this->role->errorCode()!=0){
            print_r($this->role->errorInfo());
        }
        return $this->role->fetchAll();
    }
    public function modifier($email, $nom, $prenom, $idRole){
        $this->modifier->execute(array(":email"=>$email, ":nom"=>$nom, ":prenom"=>$prenom, "idRole"=>$idRole));
        if($this->modifier->errorCode()!=0){
            print_r($this->modifier->errorInfo());
        }
        return $this->modifier->fetchAll();
    }
    
        public function modifierPass($mdp, $email){
        $this->modifierPass->execute(array(":mdp"=>$mdp, ":email"=>$email));
        if($this->modifierPass->errorCode()!=0){
            print_r($this->modifierPass->errorInfo());
        }
        return $this->modifierPass->fetchAll();
    }
    public function delete($email){
        $this->delete->execute(array(':email'=>$email));
        if($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
        }
    }
}