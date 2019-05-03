<?php
class Reservation
{
    private $db;
    private $select;
    private $delete;
    private $selectNotif;
    private $miseZero;

    public function __construct($db)
    {
        $this->db = $db;
        $this->select = $db->prepare("select * from Reservation "
                                    ."inner join Livre on Reservation.LivreReservation = Livre.IdLivre "
                                    ."inner join Auteur on Livre.Auteur = Auteur.IdAuteur "
                                    ."inner join Editeur on Livre.Editeur = Editeur.IdEditeur "
                                    ."order by IdReservation");
        $this->delete = $db->prepare("delete from Reservation where IdReservation = :id ");
        $this->selectNotif = $db->prepare("select count(IdReservation) from Reservation where NotifReservation=1");
        $this->miseZero = $db->prepare("update Reservation set NotifReservation = 0");
    }


    public function miseZero()
    {
        $this->miseZero->execute();
        if($this->miseZero->errorCode()!=0)
        {
            print_r($this->miseZero->errorInfo());
        } 
    }


    public function selectNotif()
    {
        $this->selectNotif->execute();
        if($this->selectNotif->errorCode()!=0)
        {
            print_r($this->selectNotif->errorInfo());
        }
        return $this->selectNotif->fetch();
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

    public function delete($id)
    {
        $this->delete->execute(array(':id'=>$id));
        if($this->delete->errorCode()!=0)
        {
            print_r($this->connect->errorInfo());
        }
    }
}
