<?php
class Event{
    private $db;
    private $select;
    private $insert;
    private $delete;
    private $selectByID;
    private $update;
    
    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select * from Event order by IdEvent");
        $this->insert = $db->prepare("insert into Event(TitreEvent, DescriptionEvent, DateEvent, IllustrationEvent) values(:titre, :description, :date, :illustration)");
        $this->update = $db->prepare("update Event set TitreEvent=:titre, DescriptionEvent=:description, DateEvent=:date where IdEvent=:id");

        
        $this->selectByID = $db->prepare("select * from Event where IdEvent = :id");        

        $this->delete = $db->prepare("delete from Event where IdEvent = :id ");
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
    
    public function insert($titre, $description, $date, $illustration)
    {
        if ($illustration != NULL)
            $illustration = "../web/images/$illustration";
        else
            $illustration = "../web/images/LivreBase.jpg";
        
        $this->insert->execute(array(':titre'=>$titre, ':description'=>$description, ':date'=>$date, ':illustration'=>$illustration));
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
    public function update($id, $titre, $description, $date)
    {
        $this->update->execute(array(':titre'=>$titre, ':description'=>$description, ':date'=>$date, ':id'=>$id));
        if($this->update->errorCode()!=0)
        {
            print_r($this->update->errorInfo());
        }
    }
}

