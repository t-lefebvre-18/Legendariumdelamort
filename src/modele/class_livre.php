<?php
class Livre {
    private $db;
    private $select;
    private $selectI;
    private $selecta;
    private $selectg;
    private $listeType;
    private $listeAuteur;
    private $listeEditeur;
    private $listeDispo;
    private $delete;
    private $insert;
    private $selectByID;
    private $update;
    private $search;
    private $coucou;
    public function __construct($db)
    {
        $this->db = $db;
        $this->select = $db->prepare("select * from Livre "
                                   . "inner join Type on Livre.TypeLivre=Type.IdType "
                                   . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                   . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                   . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                   . "order by TitreLivre");

        $this->selectI = $db->prepare("select * from Livre "
                                    . "inner join Type on Livre.TypeLivre=Type.IdType "
                                    . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                    . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                    . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                    . "where TypeLivre = :id order by TitreLivre");
        $this->selecta = $db->prepare("select * from Livre "
                                    . "inner join Type on Livre.TypeLivre=Type.IdType "
                                    . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                    . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                    . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                    . "where Auteur = :idA");
        $this->selectg = $db->prepare("select * from Livre "
                                    . "inner join Type on Livre.TypeLivre=Type.IdType "
                                    . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                    . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                    . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                    . "where TypeLivre = :idT");
        $this->listeType = $db->prepare("select * from Type");
        $this->listeAuteur = $db->prepare("select * from Auteur");
        $this->listeEditeur = $db->prepare("select * from Editeur");
        $this->listeDispo = $db->prepare("select * from Disponibilite");
        $this->insert = $db->prepare("insert into Livre(TitreLivre, Auteur, Editeur, AnneeLivre, TypeLivre, IllustrationLivre, ISBNLivre, ResumeLivre, DispoLivre, PrixLivre, NbrExemplaireLivre, SortieLivre) "
                                   . "values(:titre, :auteur, :editeur, :annee, :type, :photo, :isbn, :resume, :dispo, :prix, :nbrexemplaire, :date)");
        $this->delete = $db->prepare("delete from Livre where IdLivre=:id");
        $this->selectByID = $db->prepare("select * from Livre "
                                       . "inner join Type on Livre.TypeLivre=Type.IdType "
                                       . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                       . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                       . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                       . "where IdLivre=:id");
        $this->update = $db->prepare("update Livre set TitreLivre = :titre, Auteur = :auteur, Editeur = :editeur, AnneeLivre = :annee, TypeLivre = :type, "
                                   . "ISBNLivre = :isbn, ResumeLivre = :resume, DispoLivre = :dispo, PrixLivre = :prix, NbrExemplaireLivre = :nbrexemplaire "
                                   . "where Idlivre = :id");
        $this->search = $db->prepare("select * from Livre where TitreLivre = :search");
   }




   public function search($search)
   {
       $this->search->execute(array(':search'=>$search));
       if ($this->search->errorCode() != 0)
       {
           print_r($this->search->errorInfo());
       }
       return $this->search->fetchAll();
   }

    public function select()
    {
        $this->select->execute();
        if ($this->select->errorCode() != 0)
        {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectI($id)
    {
        $this->selectI->execute(array(':id'=>$id));
        if ($this->selectI->errorCode() != 0)
        {
            print_r($this->selectI->errorInfo());
        }
        return $this->selectI->fetchAll();
    }

    public function selecta($id)
    {
        $this->selecta->execute(array(':idA'=>$id));
        if ($this->selecta->errorCode() != 0)
        {
            print_r($this->selecta->errorInfo());
        }
        return $this->selecta->fetchAll();
    }

    public function selectg($id)
    {
        $this->selectg->execute(array(':idT'=>$id));
        if ($this->selectg->errorCode() != 0)
        {
            print_r($this->selectg->errorInfo());
        }
        return $this->selectg->fetchAll();
    }

    public function delete($id)
    {

        $this->delete->execute(array(':id' => $id));

        if ($this->delete->errorCode() != 0) {

            print_r($this->delete->errorInfo());
        }
    }

    public function listeType() {

        $this->listeType->execute();

        if ($this->listeType->errorCode() != 0) {

            print_r($this->listeType->errorInfo());
        }

        return $this->listeType->fetchAll();
    }

    public function listeAuteur() {

        $this->listeAuteur->execute();

        if ($this->listeAuteur->errorCode() != 0) {

            print_r($this->listeAuteur->errorInfo());
        }

        return $this->listeAuteur->fetchAll();
    }

    public function listeEditeur() {

        $this->listeEditeur->execute();

        if ($this->listeEditeur->errorCode() != 0) {

            print_r($this->listeEditeur->errorInfo());
        }

        return $this->listeEditeur->fetchAll();
    }

    public function listeDispo() {

        $this->listeDispo->execute();

        if ($this->listeDispo->errorCode() != 0) {

            print_r($this->listeDispo->errorInfo());
        }

        return $this->listeDispo->fetchAll();
    }

    public function insert($titre, $auteur, $editeur, $annee, $type, $isbn, $resume, $dispo, $prix, $nbrexemplaire, $photo) {

        if ($photo != NULL)
            $photo = "../web/images/$photo";
        else
            $photo = "../web/images/LivreBase.jpg";
        $date = date("Y-m-d");
        $this->insert->execute(array(':titre' => $titre, ':auteur' => $auteur, ':editeur' => $editeur, ':annee' => $annee, ':type' => $type, ':date'=>$date,
            ':isbn' => $isbn, ':resume' => $resume, ':dispo' => $dispo, ':prix' => $prix, ':nbrexemplaire' => $nbrexemplaire, ':photo' => $photo));

        if ($this->insert->errorCode() != 0) {

            print_r($this->insert->errorInfo());
        }
    }

    public function selectByID($id) {

        $this->selectByID->execute(array(':id' => $id));

        if ($this->selectByID->errorCode() != 0) {

            print_r($this->selectByID->errorInfo());
        }

        return $this->selectByID->fetchAll();
    }

    public function update($id, $titre, $auteur, $editeur, $annee, $type, $isbn, $resume, $dispo, $prix, $nbrexemplaire) {

        $this->update->execute(array(':id' => $id, ':titre' => $titre, ':auteur' => $auteur, ':editeur' => $editeur, ':annee' => $annee, ':type' => $type, ':isbn' => $isbn, ':resume' => $resume, ':dispo' => $dispo, ':prix' => $prix, ':nbrexemplaire' => $nbrexemplaire));

        if ($this->update->errorCode() != 0) {

            print_r($this->update->errorInfo());
        }
    }

}
