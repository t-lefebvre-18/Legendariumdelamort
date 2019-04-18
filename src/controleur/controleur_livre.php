<?php
function actionLivre($twig, $db)
{
    $form = array();
    $livre = new Livre($db);

    if(isset($_POST['btAjoutLivre']))
    {
        $titre = $_POST['inputTitre'];
        $auteur = $_POST['inputAuteur'];
        $editeur = $_POST['inputEditeur'];
        $annee = $_POST['inputAnnee'];
        $type = $_POST['inputType'];
        $isbn = $_POST['inputISBN'];
        $resume = $_POST['inputResume'];
        $dispo = $_POST['inputDispo'];
        $prix = $_POST['inputPrix'];
        $nbrexemplaire = $_POST['inputNbrExemplaire'];
        $photo=NULL;
        if(isset($_FILES['photo']))
        {
            if(!empty($_FILES['photo']['name']))
            {
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 5000000;
                $dest_dossier = '/var/www/html/vente/web/images/';
                if( !in_array( substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok ) )
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                else
                {
                    if( file_exists($_FILES['photo']['tmp_name'])&& (filesize($_FILES['photo']['tmp_name'])) >  $taille_max)
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    else
                    {
                        $photo = basename($_FILES['photo']['name']);
                        // enlever les accents
                        $photo=strtr($photo,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                        // copie du fichier
                        move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier.$photo);
                        $exec = $livre->insert($titre, $auteur, $editeur, $annee, $type, $isbn, $resume, $dispo, $prix, $nbrexemplaire, $photo);
                    }
                }
            }
        }
    }

    if(isset($_POST['btSupProd']))
    {
        $id = $_POST['inputID'];
        $livre->delete($id);
    }

    $liste = $livre->select();
    $types = $livre->listeType();
    $auteurs = $livre->listeAuteur();
    $editeurs = $livre->listeEditeur();
    $dispos = $livre->listeDispo();
    echo $twig->render('gestionLivre.html.twig', array('form'=>$form,'liste'=>$liste, 'type'=>$types, 'auteur'=>$auteurs, 'editeur'=>$editeurs, 'dispo'=>$dispos));
}

function actionModifLivre($twig, $db){
    $livre = new Livre($db);
    $id = $_POST['id'];

    if(isset($_POST['btModifLivre']))
    {
        $titre = $_POST['inputTitre'];
        $auteur = $_POST['inputAuteur'];
        $editeur = $_POST['inputEditeur'];
        $annee = $_POST['inputAnnee'];
        $type = $_POST['inputType'];
        $isbn = $_POST['inputISBN'];
        $resume = $_POST['inputResume'];
        $dispo = $_POST['inputDispo'];
        $prix = $_POST['inputPrix'];
        $nbrexemplaire = $_POST['inputNbrExemplaire'];
        $update= $livre->update($id, $titre, $auteur, $editeur, $annee, $type, $isbn, $resume, $dispo, $prix, $nbrexemplaire);
        header("Location: index.php?page=gestionLivre");
    }

        $liste = $livre->selectByID($id);
        $types = $livre->listeType();
        $auteurs = $livre->listeAuteur();
        $editeurs = $livre->listeEditeur();
        $dispos = $livre->listeDispo();
        echo $twig->render('modifLivre.html.twig', array('liste'=>$liste, 'type'=>$types, 'auteur'=>$auteurs, 'editeur'=>$editeurs, 'dispo'=>$dispos));
}

function actionPresLivre($twig, $db)
{
    $livre = new Livre($db);
    $form = array();

    if(isset($_POST['btReserver']))
    {
        if(isset($_POST['inputPseudo']))
        {
            if($_POST['inputPseudo']!='')
            {
                $id = $_POST['idLivre'];
                $pseudo = $_POST['inputPseudo'];
                $exec = $livre->reservation($id, $pseudo);
                if(!$exec)
                {
                    $form['valide'] = false;
                    $form['message'] = "Problème lors de la réservation";
                }
                else
                {
                    $form['valide'] = true;
                    $code = $livre->idReservation();
                    $titre = $livre->selectByID($id);
                    $titre = $titre[0][1];
                    $code = $code[0][0];
                    $form['message'] = "Réservation effectuée pour le livre :";
                    $form['titre'] = "$titre";
                    $form['message2'] = "Veuillez retenir ce code :";
                    $form['code'] = "$code";
                    $form['message3'] = "il vous servira à retirer votre livre en magasin";
                }
            }
            else
            {
                $form['valide'] = false;
                $form['message'] = "Votre pseudo ne peut être vide";
            }
        }
        else
        {
            $form['valide'] = false;
            $form['message'] = "Aucun pseudo spécifié";
        }
    }

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        if($id!='')
        {
            $liste = $livre->selectByID($id);
            if(count($liste[0])>1)
            {
                //Récupération de la liste des livres de l'auteur
                $idA = $liste[0][2];
                $recuplistea = $livre->selecta($idA);
                $longa = count($recuplistea);
                $listea = array();
                $tabnum = array();
                if($longa>8)
                    $longliste = 6;
                elseif($longa>5)
                    $longliste = 4;
                elseif($longa>1)
                    $longliste = 2;
                else
                    $longliste = 1;
                $numpossible = true;
                for($i = 0; $i<$longliste-1; $i++)
                {
                    $alea = rand(0, $longa-1);
                    foreach($tabnum as $num)
                    {
                        if($num == $alea)
                        {
                            $numpossible = false;
                        }
                    }
                    if($numpossible)
                    {
                        $listea[$i] = $recuplistea[$alea];
                        $tabnum[$i]=$alea;
                    }
                    else
                    {
                        $numpossible = true;
                        $i = $i-1;
                    }
                }

                //Récupération de la liste des livres du même genre
                $idG = $liste[0][5];
                $recuplisteg = $livre->selectg($idG);
                $longg = count($recuplisteg);
                $listeg = array();
                $tabnumg = array();
                if($longg>8)
                    $longlisteg = 6;
                elseif($longg>5)
                    $longlisteg = 4;
                elseif($longg>1)
                    $longlisteg = 2;
                else
                    $longlisteg = 1;
                $numpossibleg = true;
                for($k = 0; $k<$longlisteg-1; $k++)
                {
                    $aleag = rand(0, $longg-1);
                    foreach($tabnumg as $numg)
                    {
                        if($numg == $aleag)
                        {
                            $numpossibleg = false;
                        }
                    }
                    if($numpossibleg)
                    {
                        $listeg[$k] = $recuplisteg[$aleag];
                        $tabnumg[$k]=$aleag;
                    }
                    else
                    {
                        $numpossibleg = true;
                        $k = $k-1;
                    }
                }
            }
            else
            {
                $form['message'] = "Identifiant du livre inconnu";
                $liste = NULL;
                $listea = NULL;
                $listeg = NULL;
            }
        }
        else
        {
            $form['message'] = "Identifiant du livre inconnu";
            $liste = NULL;
            $listea = NULL;
            $listeg = NULL;
        }
    }
    else
    {
        $form['message'] = "Identifiant du livre non renseigné";
        $liste = NULL;
        $listea = NULL;
        $listeg = NULL;
    }
    echo $twig->render('presLivre.html.twig', array('form'=>$form, 'liste'=>$liste, 'listea'=>$listea, 'listeg'=>$listeg));
}
