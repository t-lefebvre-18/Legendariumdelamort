<?php
    function actionAuteur($twig, $db)
    {
        $form = array();
        $auteur = new Auteur($db);
        if(isset($_POST['btSupA']))
        {
            $id = $_POST['id'];
            $auteur->delete($id);
        }
        if(isset($_POST['btAjoutA']))
        {
            $nom = strtoupper($_POST['inputNom']);
            $prenom = $_POST['inputPrenom'];
            $datenaiss = $_POST['inputDateNaiss'];
            $pays = $_POST['inputPays'];

            $exec = $auteur->insert($nom, $prenom, $datenaiss, $pays);
        }
        $liste = $auteur->select();
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('gestionAuteur.html.twig', array('form'=>$form, 'liste'=>$liste, 'types'=>$types));
    }


    function actionModifAuteur($twig,$db)
    {
        $form = array();
        $auteur = new Auteur($db);
        $id = $_POST['id'];
        $unAuteur = $auteur->selectByID($id);
        if(isset($_POST['btModifA']))
        {
            $nom = strtoupper($_POST['inputNom']);
            $prenom = $_POST['inputPrenom'];
            $datenaiss = $_POST['inputDateNaiss'];
            $pays = $_POST['inputPays'];

            $auteur->update($id, $nom, $prenom, $datenaiss, $pays);
           header("Location: index.php?page=gestionAuteur");

        }
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('modifAuteur.html.twig', array('auteur'=>$unAuteur, 'types'=>$types));
    }
