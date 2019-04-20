<?php
    function actionUtilisateur($twig, $db)
    {
        $utilisateur = new Utilisateur($db);
        if(isset($_POST['btSup'])){
            $email = $_POST['email'];
            $utilisateur->delete($email);
        }
        $liste = $utilisateur->select();
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('utilisateur.html.twig', array('liste'=>$liste, 'types'=>$types));
    }
    function actionModifUtilisateur($twig, $db)
    {
        $form = array();
        $utilisateur = new Utilisateur($db);
        $roles = $utilisateur->role();
        if(isset($_POST['btModifUtilisateur'])){

            $email = $_POST['email'];
            $nom = $_POST['inputNom'];
            $prenom = $_POST['inputPrenom'];
            $idRole = $_POST['inputRole'];
            if($_POST['inputPassword'] != null){
                $password = $_POST['inputPassword'];
                $cpassword = $_POST['inputPassword2'];
                if($password != $cpassword){
                    $form["erreur"] = "Les mots de passes doivent être identiques";
                }
                else
                {
                    $mdp = password_hash($password, PASSWORD_DEFAULT);
                    $utilisateur->modifierPass($mdp, $email);
                }
            }
            $utilisateur->modifier($email, $nom, $prenom, $idRole);
            header("Location: index.php?page=utilisateur");
        }
        $util = $utilisateur->afficher($_POST['email']);
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('utilisateur-modif.html.twig', array('liste'=>$util, 'roles'=>$roles, 'form'=>$form, 'types'=>$types));
    }
