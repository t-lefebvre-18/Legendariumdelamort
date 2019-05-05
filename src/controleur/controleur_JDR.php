<?php
    function actionJDR($twig, $db)
    {
        $form = array();
        $jeu = new Jeu($db);
        if(isset($_POST['btAjoutJDR']))
        {
            $pseudo = $_POST['inputPseudo'];
            $email = $_POST['inputEmail'];
            $tel = $_POST['inputTel'];
            $synopsis = $_POST['inputSynopsis'];
            if(isset($_POST['inputFournis']))
                $fournis = true;
            else
                $fournis = false;
            $nbrJoueur = $_POST['inputNbrJoueur'];
            if(isset($_POST['dateDisp']))
            {
                $dates = $_POST['dateDisp'];
                $listeDates = "";
                foreach($dates as $dateJDR)
                {
                    $listeDates = $listeDates."--".$dateJDR;
                }
                $exec = $jeu->insertJDR($pseudo, $email, $tel, $synopsis, $fournis, $nbrJoueur, $listeDates, 0);
                if(!$exec)
                {
                    $form['valide'] = false;
                    $form['message'] = "Echec lors de l'enregistrement de la demande";
                }
                else
                    $form['valide'] = true;
            }
            else
            {
                $form['valide'] = false;
                $form['message'] = "Vous n'avez pas sélectionné de date !";
            }
        }
        else if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $form['leJeu'] = $jeu->selectById($id);
            $n = 0;
            for($i = 0; $i<31; $i++)
            {
                $date = date('D-Y-m-d', strtotime('+1 month, +'.$i.' day'));
                $jourDate = explode("-", $date);
                if($jourDate[0]!="Mon" && $jourDate[0]!="Sun")
                {
                    $tabDateDispo[$n] = date('Y-m-d', strtotime('+1 month, +'.$i.' day'));
                    $n++;
                }
            }
        }
        else
        {
                $form['valide'] = false;
                $form['message'] = "Aucun Jeu renseigné";
        }
        echo $twig->render('creationJDR.html.twig', array('form'=>$form, 'dateDispo'=>$tabDateDispo));
    }



    function actionChoixJeu($twig, $db)
    {
        $form = array();
        $jeu = new Jeu($db);
        $lesJeux = $jeu->select();
        echo $twig->render('choixJeu.html.twig', array('listeJeu'=>$lesJeux));
    }
