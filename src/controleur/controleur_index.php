<?php
function actionAccueil($twig, $db){
  $form = array();
  $livre = new Livre($db);
  $liste = $livre->select();
  $event = new Event($db);
  $listeevent = $event->select();
 echo $twig->render('index.html.twig', array('form'=>$form,'liste'=>$liste,'listeevent'=>$listeevent));
 }

 function actionDeconnexion($twig){
  session_unset();
  session_destroy();

  header("Location:index.php");
 }

 function actionPropos($twig){
  echo $twig->render('propos.html.twig', array());
 }

 function actionProfil($twig,$db){
  $form = array();

   $event = new Event($db);
   $listeevent = $event->select();
  echo $twig->render('profil.html.twig', array('form'=>$form, 'listeevent'=>$listeevent));
 }


function actionConnexion($twig, $db){

 $form = array();

 if (isset($_POST['btConnecter'])){
      $form['valide'] = true;
 $inputEmail = $_POST['inputEmail'];
 $inputPassword = $_POST['inputPassword'];
 $utilisateur = new Utilisateur($db);
 $unUtilisateur = $utilisateur->connect($inputEmail);
 if ($unUtilisateur!=null){
 if(!password_verify($inputPassword,$unUtilisateur['mdp'])){
 $form['valide'] = false;
 $form['messageTitre'] = 'Echec de la connexion !';
 $form['message'] = 'Mot de passe incorrect';
 }
 else{
 $_SESSION['login'] = $inputEmail;
 $_SESSION['role'] = $unUtilisateur['idRole'];
 header("Location:index.php");

 }
 }
 else{
 $form['valide'] = false;
$form['messageTitre'] = 'Echec de la connexion !';
 $form['message'] = 'Email incorrect';

 }
 }
 echo $twig->render('connexion.html.twig', array('form'=>$form));

}

function actionMentionslegales($twig, $db){
  $form = array();
  $event = new Event($db);
  $listeevent = $event->select();
 echo $twig->render('mentionslegales.html.twig', array('form'=>$form, 'listeevent'=>$listeevent));
}

function actionMaintenance($twig){
 echo $twig->render('maintenance.html.twig', array());
}

function actionInscrire($twig, $db){
 $form = array();
 if (isset($_POST['btInscrire'])){
 $inputEmail = $_POST['inputEmail'];
 $inputPassword = $_POST['inputPassword'];
 $inputPassword2 =$_POST['inputPassword2'];
 $nom = $_POST['nom'];
 $prenom =$_POST['prenom'];
 $dateCrea =$_POST['dateCrea'];
 $role = $_POST['role'];
 $form['valide'] = true;
 if ($inputPassword!=$inputPassword2){
 $form['valide'] = false;
 $form['messageTitre'] = 'Echec de l\'inscription !';
 $form['message'] = 'Les mots de passe sont différents';
 }
 else{
 $utilisateur = new Utilisateur($db);
 $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword,PASSWORD_DEFAULT),$nom, $prenom,$dateCrea, $role);
 if (!$exec){
 $form['valide'] = false;
 $form['messageTitre'] = 'Echec de l\'inscription !';
 $form['message'] = 'Email déjà utilisé';
 }
 }
 $form['email'] = $inputEmail;
 $form['role'] = $role;
 }

 echo $twig->render('inscrire.html.twig', array('form'=>$form));
}





?>
