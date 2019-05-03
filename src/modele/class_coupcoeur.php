<?php
class CoupCoeur{
    private $db;
    private $maxIndex;
    private $select;
    private $insert;
    private $delete;
    private $selectByID;
    private $update;

    public function __construct($db){
        $this->db = $db;
        $this->maxIndex = $db->prepare("select count(IdCoupCoeur) from CoupCoeur");
        $this->select = $db->prepare("select * from CoupCoeur "
                                   . "inner join Livre on CoupCoeur.LivreCoupCoeur=Livre.IdLivre "
                                   . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                   . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                   . "order by IdCoupCoeur");
        $this->insert = $db->prepare("insert into CoupCoeur(LivreCoupCoeur) values(:id)");
        $this->update = $db->prepare("update CoupCoeur set LivreCoupCoeur=:idChoix where IdCoupCoeur=:id");
        $this->delete = $db->prepare("delete from CoupCoeur where IdCoupCoeur=:id ");

        $this->selectByID = $db->prepare("select * from Editeur where IdEditeur = :id");
}

    public function maxIndex()
    {
        $this->maxIndex->execute();
        if($this->maxIndex->errorCode()!=0)
        {
            print_r($this->maxIndex->errorInfo());
        }
        return $this->maxIndex->fetch();
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

    public function insert($idChoix, $id)
    {
        if($id==NULL)
        {
            var_dump($test);
            $this->insert->execute(array(':id'=>$idChoix));
            if($this->insert->errorCode()!=0)
            {
                print_r($this->insert->errorInfo());
            }
        }
        else
        {
            $this->update->execute(array(':id'=>$id, ':idChoix'=>$idChoix));
            if($this->update->errorCode()!=0)
            {
                print_r($this->update->errorInfo());
            }
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
