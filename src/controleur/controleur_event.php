<?php
    function actionEvent($twig, $db)
    {
        $form = array();
        $datePass = array();
        $event = new Event($db);
        if(isset($_POST['btSupE']))
        {
            $id = $_POST['id'];
            $event->delete($id);
        }

        if(isset($_POST['btAjoutE']))
        {
            $titre = $_POST['inputTitre'];
            $description = $_POST['inputDescription'];
            $date = $_POST['inputDate'];
            $photo = NULL;
            if(isset($_FILES['IllEvent']))
            {
                if(!empty($_FILES['IllEvent']['name']))
                {
                    $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                    $taille_max = 5000000;
                    $dest_dossier = '/var/www/html/vente/web/images/';
                    if( !in_array( substr(strrchr($_FILES['IllEvent']['name'], '.'), 1), $extensions_ok ) )
                        echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                    else
                    {
                        if( file_exists($_FILES['IllEvent']['tmp_name'])&& (filesize($_FILES['IllEvent']['tmp_name'])) >  $taille_max)
                            echo 'Votre fichier doit faire moins de 500Ko !';
                        else
                        {
                            $photo = basename($_FILES['IllEvent']['name']);
                            // enlever les accents
                            $photo=strtr($photo,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                            // remplacer les caractères autres que lettres, chiffres et point par _
                            $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                            // copie du fichier
                            move_uploaded_file($_FILES['IllEvent']['tmp_name'], $dest_dossier.$photo);
                            $exec = $event->insert($titre, $description, $date, $photo);
                        }
                    }
                }
            }
        }
        $liste = $event->select();
        $y = 0;
        foreach($liste as $date)
        {
            $dateEvent = strtotime($date['DateEvent']);
            $dateAjd = strtotime(date('Y-m-d'));
            if(($dateAjd-$dateEvent)/86400 > 0)
            {
                $datePass[$y] = $date['IdEvent'];
                $y++;
            }
        }
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('gestionEvent.html.twig', array('form'=>$form, 'liste'=>$liste, 'types'=>$types, 'listePass'=>$datePass));
    }


    function actionModifEvent($twig,$db)
    {
        $form = array();
        $event = new Event($db);
        $id = $_POST['id'];
        $unEvent = $event->selectByID($id);
        if(isset($_POST['btModifE']))
        {
            $titre = $_POST['inputTitre'];
            $description = $_POST['inputDescription'];
            $date = $_POST['inputDate'];

            $event->update($id, $titre, $description, $date);
            header("Location: index.php?page=gestionEvent");
        }
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('modifEvent.html.twig', array('event'=>$unEvent, 'types'=>$types));
    }
