<?php
    function actionJDR($twig, $db)
    {
        $form = array();
        $jeu = new Jeu($db);
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $form['leJeu'] = $jeu->selectById($id);
            $dateUnMois = date('D-Y-m-d', strtotime('+1 month'));
            $n = 0;
            for($i = 0; $i<31; $i++)
            {
                $date = date('D-Y-m-d', strtotime('+'.$i.' day', strtotime($dateUnMois)));
                $jourDate = explode("-", $date);
                if($jourDate[0]!="Mon" && $jourDate[0]!="Sun")
                {
                    $tempo = explode("!-", "!".date('Y-m-d', strtotime('+'.$i.'day', strtotime($dateUnMois))));
                    $tabDateDispo[$n] = $tempo[1];
                    $n++;
                }
            }
        }
        else
        {
            if(isset($_GET['test']))
            {
                if($_POST['inputTest']==0)
                    echo "existe pas";
                else
                    echo "existe";
            }
            else
            {
                $form['valide'] = false;
                $form['message'] = "Aucun Jeu rensigné";
            }
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
