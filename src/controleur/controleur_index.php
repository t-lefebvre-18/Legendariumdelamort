<?php
function actionAccueil($twig, $db)
{
    $form = array();
    $type = new Type($db);
    $cc = new CoupCoeur($db);
    $event = new Event($db);
    $livre = new Livre($db);
    $types = $type->select();
    $listeCC = $cc->select();
    $listeEvent = $event->select();
    $listeDNprov = $livre->selectDN();
    for($i = 0; $i<3; $i++)
        $listeDN[$i]=$listeDNprov[$i];
    echo $twig->render('index.html.twig', array('form'=>$form,'types'=>$types, 'CC'=>$listeCC, 'event'=>$listeEvent, "DN"=>$listeDN));
}

function actionInscription($twig, $db)
{
    $form = array();
    if(isset($_POST['btInscrire'])){
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $inputPassword2 = $_POST['inputPassword2'];
        $role = $_POST['role'];
        $form['valide'] = true;
        if($inputPassword!= $inputPassword2)
        {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        }
        else
        {
            $utilisateur = new Utilisateur($db);
            $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword, PASSWORD_DEFAULT), $role);
            if(!$exec)
            {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table utilisateur.';
            }
        }
        $form['email'] = $inputEmail;
        $form['role'] = $role;
    }
    $type = new Type($db);
    $types = $type->select();
    echo $twig->render('inscription.html.twig', array('form' => $form, 'types'=>$types));
}

function actionConnexion($twig, $db)
{
    $form = array();
    if (isset($_POST['btConnecter']))
    {
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];

        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->connect($inputEmail);
        var_dump($unUtilisateur['MdpUtilisateur']);
        if ($unUtilisateur != null)
        {
            if (!password_verify($inputPassword, $unUtilisateur['MdpUtilisateur']))
            {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect.';
            }
            else
            {
                $_SESSION['login'] = $inputEmail;
                $_SESSION['role'] = $unUtilisateur['RoleUtilisateur'];
                header("Location:index.php");
            }
        }
        else
        {
            $form['valide'] = false;
            $form['message'] = 'Login ou mot de passe incorrect';
        }
    }
    $type = new Type($db);
    $types = $type->select();
    echo $twig->render('connexion.html.twig', array('form' => $form, 'types'=>$types));
}

function actionApropos($twig){
    echo $twig->render('apropos.html.twig', array('types'=>$types));
}

function actionMentions($twig){
    echo $twig->render('mentions.html.twig', array());
}

function actionDeconnexion($twig){
    session_unset();
    session_destroy();
    header("Location:index.php");
}

function actionMaintenance($twig){
    echo $twig->render('maintenance.html.twig', array());
}

function actionLibrairie($twig, $db)
{
    $form = array();
    $livre = new Livre($db);

    if(isset($_POST['btSearch']))
    {
        $search = $_POST['search'];
        $form['valideSearch'] = true;
        $form['messageSearch'] = $search;
        $i = 0;
        $listeLivre = array();
        $resultatSearch1 = $db->query("select * from Livre "
                                    . "inner join Type on Livre.TypeLivre=Type.IdType "
                                    . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                    . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                    . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                    . "where TitreLivre like '%$search%'");
        $resultatSearch[0]=$resultatSearch1;
        $resultatSearch2 = $db->query("select * from Livre "
                                    . "inner join Type on Livre.TypeLivre=Type.IdType "
                                    . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                    . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                    . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                    . "where NomAuteur like '%$search%'");
        $resultatSearch[1]=$resultatSearch2;
        $resultatSearch3 = $db->query("select * from Livre "
                                    . "inner join Type on Livre.TypeLivre=Type.IdType "
                                    . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                    . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                    . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                    . "where LibelleEditeur like '%$search%'");
        $resultatSearch[2]=$resultatSearch3;
        $resultatSearch4 = $db->query("select * from Livre "
                                    . "inner join Type on Livre.TypeLivre=Type.IdType "
                                    . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                    . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                    . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                    . "where ResumeLivre like '%$search%'");
        $resultatSearch[3]=$resultatSearch4;
        foreach($resultatSearch as $RS)
        {
            foreach($RS as $coucou)
            {
                $idpossible = true;
                foreach($listeLivre as $id)
                {
                    if($coucou["IdLivre"]==$id["IdLivre"])
                        $idpossible = false;
                }
                if($idpossible)
                {
                    $listeLivre[$i]=$coucou;
                    $i++;
                }
            }
        }
    }
    else
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $form['id'] = $id;
        }
        else
            $id = NULL;

        if(isset($_GET['trier']))
            $trier = $_GET['trier'];
        else
            $trier = NULL;

        if($id != NULL && $trier != NULL)
        {
            if($trier == 1)
                $trier = "SortieLivre";
            elseif($trier == 2)
                $trier = "JaimeLivre desc";
            elseif($trier == 3)
                $trier = "PrixLivre";
            elseif($trier == 4)
                $trier = "PrixLivre desc";
            elseif($trier == 5)
                $trier = "DispoLivre";
            else
                $trier = "TitreLivre";
            //$listeLivre = $livre->selectIT($id, $trier);
            $listeLivre = $db->query("select * from Livre "
                                        . "inner join Type on Livre.TypeLivre=Type.IdType "
                                        . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                        . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                        . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                        . "where TypeLivre = $id order by $trier");
        }
        else if($id != NULL)
            $listeLivre = $livre->selectI($id);
        else if($trier != NULL)
        {
            if($trier == 1)
                $trier = "SortieLivre";
            elseif($trier == 2)
                $trier = "JaimeLivre desc";
            elseif($trier == 3)
                $trier = "PrixLivre";
            elseif($trier == 4)
                $trier = "PrixLivre desc";
            elseif($trier == 5)
                $trier = "DispoLivre";
            else
                $trier = "TitreLivre";
            $listeLivre = $db->query("select * from Livre "
                                   . "inner join Type on Livre.TypeLivre=Type.IdType "
                                   . "inner join Auteur on Livre.Auteur=Auteur.IdAuteur "
                                   . "inner join Editeur on Livre.Editeur=Editeur.IdEditeur "
                                   . "inner join Disponibilite on Livre.DispoLivre=Disponibilite.IdDisponibilite "
                                   . "order by $trier");
        }
        else
            $listeLivre = $livre->select();
    }
    $type = new Type($db);
    $types = $type->select();
    echo $twig->render('librairie.html.twig', array('form'=>$form,'liste'=>$listeLivre, 'types'=>$types));
}
