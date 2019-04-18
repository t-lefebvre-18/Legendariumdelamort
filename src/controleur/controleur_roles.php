<?php

function actionRole($twig,$db){
    $form = array();
    $role = new Role($db);
    
    if(isset($_POST['btAjout'])){
        $libelle = $_POST['inputLibelle'];
        $role->insert($libelle);
    }
    if(isset($_POST['btSup'])){
        $id = $_POST['id'];
        $role->delete($id);
    }
    $roles = $role->select();
    echo $twig->render("roles.html.twig", array('form'=>$form, 'roles'=>$roles));
}
function actionModifRole($twig, $db){
    $role = new Role($db);
    $id = $_POST['id'];
    if(isset($_POST['btModif'])){
        $libelle = $_POST['inputLibelle'];
        $role->update($libelle, $id);
        header("Location: index.php?page=roles");
    }
    $unRole = $role->selectByID($id);
    echo $twig->render("roles-modif.html.twig", array('role'=>$unRole));
}