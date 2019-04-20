<?php

    function actionEditeur($twig, $db)
    {
        $form = array();
        $editeur = new Editeur($db);
        if(isset($_POST['btSupE']))
        {
            $id = $_POST['id'];
            $editeur->delete($id);
        }
        if(isset($_POST['btAjoutE']))
        {
            $libelle = $_POST['inputLibelle'];
            $exec = $editeur->insert($libelle);
        }
        $liste = $editeur->select();
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('gestionEditeur.html.twig', array('form'=>$form, 'liste'=>$liste, 'types'=>$types));
    }

    function actionModifEditeur($twig,$db)
    {
        $form = array();
        $editeur = new Editeur($db);
        $id = $_POST['id'];
        $unEditeur = $editeur->selectByID($id);
        if(isset($_POST['btModifE']))
        {
            $libelle = $_POST['inputLibelle'];
            $editeur->update($id, $libelle);
            header("Location: index.php?page=gestionEditeur");
        }
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('modifEditeur.html.twig', array('editeur'=>$unEditeur, 'types'=>$types));
    }
