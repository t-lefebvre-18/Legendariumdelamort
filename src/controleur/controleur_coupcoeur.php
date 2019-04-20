<?php
    function actionCoupCoeur($twig, $db)
    {
        $form = array();
        $cc = new CoupCoeur($db);

        if(isset($_POST['btSupCC']))
        {
            $id = $_POST['id'];
            $exec = $cc->delete($id);
        }

        $tabMaxIndex = $cc->maxIndex();
        $form['maxIndex'] = $tabMaxIndex[0];
        $liste = $cc->select();
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('gestionCoupCoeur.html.twig', array('form'=>$form, 'liste'=>$liste, 'types'=>$types));
    }


    function actionModifCoupCoeur($twig,$db)
    {
        $form = array();
        $cc = new CoupCoeur($db);
        $livre = new Livre($db);

        if(isset($_GET['id']))
            $form['id'] = $_GET['id'];
        else
            $form['id'] = NULL;
        if(isset($_GET['idChoix']))
        {
            $idChoix = $_GET['idChoix'];
            $id = $_GET['id'];
            $exec = $cc->insert($idChoix, $form['id']);
            header("Location: index.php?page=gestionCoupCoeur");
        }

        $liste = $livre->select();
        $type = new Type($db);
        $types = $type->select();
        echo $twig->render('modifCoupCoeur.html.twig', array('liste'=>$liste, 'form'=>$form, 'types'=>$types));
    }
