<?php
class Type{
    private $db;
    private $select;
    private $insert;
    private $delete;
    private $selectByID;
    private $update;

    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select * from Type order by IdType");
        $this->selectByID = $db->prepare("select * from Type where IdType = :id");
        $this->update = $db->prepare("update Type set LibelleType = :libelle where IdType = :id");
        $this->delete = $db->prepare("delete from Type where IdType = :id ");
        $this->insert = $db->prepare("insert into Type(LibelleType) values(:libelle)");
}


    public function select(){
        $this->select->execute();
        if($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function insert($libelle)
    {
        $this->insert->execute(array(':libelle'=>$libelle));
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
    public function update($id, $libelle)
    {
        $this->update->execute(array(':libelle'=>$libelle, ':id'=>$id));
        if($this->update->errorCode()!=0)
        {
            print_r($this->update->errorInfo());
        }
    }
}
