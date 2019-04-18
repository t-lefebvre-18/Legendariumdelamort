<?php
    function actionJeu($twig, $db)
    {
        $form = array();
        $jeu = new Jeu($db);
        if(isset($_POST['btSupJ']))
        {
            $id = $_POST['id'];
            $jeu->delete($id);
        }
        
        if(isset($_POST['btAjoutJ']))
        {
            $nom = $_POST['inputNomJeu'];
            $duree = $_POST['inputDureeJeu'];
            $description = $_POST['inputDescription'];
            $reglejeu = $_POST['inputRegleJeu'];
            $IllustrationJeu=NULL;
            if(isset($_FILES['IllustrationJeu']))
            {   
                if(!empty($_FILES['IllustrationJeu']['name']))
                {            
                    $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                    $taille_max = 500000;            
                    $dest_dossier = '/var/www/html/vente/web/images/';            
                    if( !in_array( substr(strrchr($_FILES['IllustrationJeu']['name'], '.'), 1), $extensions_ok ) )           
                        echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';            
                    else
                    {   
                        if( file_exists($_FILES['IllustrationJeu']['tmp_name'])&& (filesize($_FILES['IllustrationJeu']['tmp_name'])) >  $taille_max)
                            echo 'Votre fichier doit faire moins de 500Ko !';                
                        else
                        {
                            $IllustrationJeu = basename($_FILES['IllustrationJeu']['name']);
                            // enlever les accents
                            $IllustrationJeu=strtr($IllustrationJeu,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                            // remplacer les caractères autres que lettres, chiffres et point par _                
                            $IllustrationJeu = preg_replace('/([^.a-z0-9]+)/i', '_', $IllustrationJeu);
                            // copie du fichier
                            move_uploaded_file($_FILES['IllustrationJeu']['tmp_name'], $dest_dossier.$IllustrationJeu);
                        }
                    }
                }
            }
            $exec = $jeu->insert($nom, $duree, $description, $reglejeu, $IllustrationJeu);
        }
        $liste = $jeu->select();
        echo $twig->render('gestionJeu.html.twig', array('form'=>$form, 'liste'=>$liste));
    }
   

    function actionModifJeu($twig,$db)
    {
        $form = array();
        $jeu = new Jeu($db);
        $id = $_POST['id']; 
        $unJeu = $jeu->selectByID($id);
        if(isset($_POST['btModifJ']))
        {
            $nom = $_POST['inputNomJeu'];
            $duree = $_POST['inputDureeJeu'];
            $description = $_POST['inputDescription'];
            $reglejeu = $_POST['inputRegleJeu'];
            
            $jeu->update($id, $nom, $duree, $description, $reglejeu);
           header("Location: index.php?page=gestionJeu");

        }
        echo $twig->render('modifJeu.html.twig', array('jeu'=>$unJeu));
    }