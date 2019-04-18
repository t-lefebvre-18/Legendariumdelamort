<?php
class Role{
    private $db;
    private $select;
    private $insert;
    private $delete;
    private $update;
    private $selectByID;

    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("SELECT id, libelle FROM role");
        $this->insert = $db->prepare("INSERT INTO role(libelle) values(:libelle)");
        $this->delete = $db->prepare("DELETE FROM role WHERE id = :id");
        $this->update = $db->prepare("UPDATE role set libelle = :libelle WHERE id = :id");
        $this->selectByID = $db->prepare("SELECT id, libelle FROM role WHERE id = :id");
    }
    
    public function select(){
        $this->select->execute();
        if($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    public function insert($libelle){
        $this->insert->execute(array(':libelle'=>$libelle));
        if($this->insert->errorCode()!=0){
            print_r($this->insert->errorInfo());
        }
    }
    public function delete($id){
        $this->delete->execute(array(':id'=>$id));
        if($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
        }
    }
    public function update($libelle, $id){
        $this->update->execute(array(':libelle'=>$libelle, ':id'=>$id));
        if($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
        }
    }
    public function selectByID($id){
        $this->selectByID->execute(array(':id'=>$id));
        if($this->selectByID->errorCode()!=0){
            print_r($this->selectByID->errorInfo());
        }
        return $this->selectByID->fetch();
    }
}
