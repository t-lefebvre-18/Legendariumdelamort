<?php
class Auteur{
    private $db;
    private $select;
    private $insert;
    private $delete;
    private $selectByID;
    private $update;

    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select * from Auteur order by IdAuteur");
        $this->insert = $db->prepare("insert into Auteur(NomAuteur, PrenomAuteur, DateNaissAuteur, PaysAuteur) values(:nom, :prenom, :datenaiss, :pays)");
        $this->selectByID = $db->prepare("select * from Auteur where IdAuteur = :id");
        $this->update = $db->prepare("update Auteur set NomAuteur=:nom, PrenomAuteur=:prenom, DateNaissAuteur=:datenaiss, PaysAuteur=:pays where IdAuteur=:id");


        $this->delete = $db->prepare("delete from Auteur where IdAuteur = :id ");
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

    public function insert($nom, $prenom, $datenaiss, $pays)
    {
        $this->insert->execute(array(':nom'=>$nom, ':prenom'=>$prenom, ':datenaiss'=>$datenaiss, ':pays'=>$pays));
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
    public function update($id, $nom, $prenom, $datenaiss, $pays)
    {
        $this->update->execute(array(':nom'=>$nom, ':prenom'=>$prenom, ':datenaiss'=>$datenaiss, ':pays'=>$pays, ':id'=>$id));
        if($this->update->errorCode()!=0)
        {
            print_r($this->update->errorInfo());
        }
    }
}
