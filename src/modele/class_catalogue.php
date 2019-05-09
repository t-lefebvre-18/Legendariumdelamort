<?php
class Catalogue{

 private $db;
 private $insert;
 private $select;

 public function __construct($db){
 $this->db = $db;
 $this->insert = $db->prepare("INSERT INTO c ( libelle) VALUES ( :libelle);");
 $this->select = $db->prepare("SELECT id, libelle FROM type ;");

 }

 public function insert( $inputLibelle){
 $r = true;

 $this->insert->execute(array(':libelle'=>$inputLibelle));
 if ($this->insert->errorCode()!=0){
 print_r($this->insert->errorInfo());
 $r=false;
 }
 return $r;
 }



  public function select(){
 $liste = $this->select->execute();
 if ($this->select->errorCode()!=0){
 print_r($this->select->errorInfo());
 }
 return $this->select->fetchAll();
 }


}
?>
