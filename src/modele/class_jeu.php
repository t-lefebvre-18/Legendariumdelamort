<?php
class Jeu
{
    private $db;
    private $select;
    private $insert;
    private $delete;
    private $selectByID;
    private $update;
    private $insertJDR;

    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select * from Jeu order by IdJeu");
        $this->insert = $db->prepare("insert into Jeu(NomJeu, DureeMoyJeu, DescriptionJeu, RegleJeu, IllustrationJeu) values(:nom, :dureejeu, :description, :regle, :illustration)");
        $this->delete = $db->prepare("delete from Jeu where IdJeu = :id ");
        $this->update = $db->prepare("update Jeu set NomJeu=:nom, DureeMoyJeu=:dureejeu, DescriptionJeu=:description, RegleJeu=:regle where IdJeu=:id");
        $this->selectByID = $db->prepare("select * from Jeu where IdJeu = :id");
        $this->insertJDR  =$db->prepare("insert into JDR(MjJDR, EmailJDR, TelephoneJDR, SynopsisJDR, FournisJDR, NbrJoueur, DateJDR, ValideJDR) values(:pseudo, :email, :tel, :synopsis, :fournis, :nbrJoueur, :date, :valide)");

}

    public function insertJDR($pseudo, $email, $tel, $synopsis, $fournis, $nbrJoueur, $listeDates, $valide)
    {
        $r = true;
        if($fournis == true)
            $fournis = "oui";
        else
            $fournis = "non";
        $this->insertJDR->execute(array(':pseudo'=>$pseudo, ':email'=>$email, ':tel'=>$tel, ':synopsis'=>$synopsis, ':fournis'=>$fournis, "nbrJoueur"=>$nbrJoueur, ':date'=>$listeDates, ':valide'=>$valide));
        if ($this->insertJDR->errorCode() != 0)
        {
            print_r($this->insertJDR->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function select()
    {
        $this->select->execute();
        if($this->select->errorCode()!=0)
        {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function insert($nom, $dureejeu, $description, $regle, $illustration)
    {
        if ($illustration != NULL)
            $illustration = "../web/images/$illustration";
        else
            $illustration = "../web/images/JeuBase.jpg";
        $this->insert->execute(array(':nom'=>$nom, ':dureejeu'=>$dureejeu, ':description'=>$description, ':regle'=>$regle, ':illustration'=>$illustration));
        if($this->insert->errorCode()!=0)
        {
            print_r($this->insert->errorInfo());
        }
    }

    public function delete($id)
    {
        $this->delete->execute(array(':id'=>$id));
        if($this->delete->errorCode()!=0)
        {
            print_r($this->connect->errorInfo());
        }
    }
    public function selectByID($id)
    {
        $this->selectByID->execute(array(':id'=>$id));
        if($this->selectByID->errorCode()!=0)
        {
            print_r($this->selectByID->errorInfo());
        }
        return $this->selectByID->fetch();
    }
    public function update($id, $nom, $dureejeu, $description, $regle)
    {
        $this->update->execute(array(':nom'=>$nom, ':dureejeu'=>$dureejeu, ':description'=>$description, ':regle'=>$regle, ':id'=>$id));
        if($this->update->errorCode()!=0)
        {
            print_r($this->update->errorInfo());
        }
    }
}
