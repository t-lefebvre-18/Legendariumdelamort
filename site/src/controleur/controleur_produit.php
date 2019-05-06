
<?php
function actionProduit($twig, $db){
 $form = array();
  $produit = new Produit($db);
  $type = new Type($db);
  if (isset($_POST['btAjouter'])){
 $inputDesignation = $_POST['inputDesignation'];
  $inputDescription = $_POST['inputDescription'];
   $inputPrix = $_POST['inputPrix'];
    $inputType = $_POST['inputType'];
  
 $form['valide'] = true;

 $exec = $produit->insert($inputDesignation, $inputDescription, $inputPrix, $inputType);
 if (!$exec){
 $form['valide'] = false;
 $form['message'] = 'Problème';
 }

 }
  
 $liste = $produit->select();
 $listetype = $type->select();

 echo $twig->render('produit.html.twig', array('form'=>$form,'liste'=>$liste,'listetype'=>$listetype));
}
?>