<?php
class Reservation
{
    private $db;
    private $select;
    private $delete;

    public function __construct($db)
    {
        $this->db = $db;
        $this->select = $db->prepare("select * from Reservation "
                                    ."inner join Livre on Reservation.LivreReservation = Livre.IdLivre "
                                    ."inner join Auteur on Livre.Auteur = Auteur.IdAuteur "
                                    ."inner join Editeur on Livre.Editeur = Editeur.IdEditeur "
                                    ."order by IdReservation");
        $this->delete = $db->prepare("delete from Reservation where IdReservation = :id ");
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
