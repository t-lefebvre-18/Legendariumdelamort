<?php

function actionProduit($twig, $db)
{
    $form = array();
    $prod = new Produit($db);

    if(isset($_POST['btAjoutProd'])){
        $designation = $_POST['inputDesignation'];
        $description = $_POST['description'];
        $prix = $_POST['inputPrix'];
        $idType = $_POST['inputType'];
        $exec = $prod->insert($designation, $description, $prix, $idType);
    }
    if(isset($_POST['btSupProd'])){
        $cocher = $_POST['cocher'];
        $id = $_POST['inputID'];
        $prod->delete($id);
    }
    if(isset($_POST['btSupprimerPlusieurs'])){
        $id = $_POST['inputID'];
        foreach ($cocher as $id){
            $prod->delete($id);
        }
    }
    $liste = $prod->select();
    $types = $prod->listeTypes();

    echo $twig->render('gestionProduits.html.twig', array('form'=>$form,'liste'=>$liste, 'types'=>$types));
}

function actionModifProduit($twig, $db)
{
    $prod = new Produit($db);
    $id = $_POST['id'];
    if(isset($_POST['btModifProduit'])){
        $designation = $_POST['inputDesignation'];
        $description = $_POST['inputDescription'];
        $prix = $_POST['inputPrix'];
        $idType = $_POST['inputType'];
        $update= $prod->update($id, $designation, $description, $prix, $idType);
       header("Location: index.php?page=gestionProduits");
    }

        $liste = $prod->selectByID($id);
        $types = $prod->listeTypes();
        echo $twig->render('modifProduits.html.twig', array('liste'=>$liste, 'types'=>$types));
}
