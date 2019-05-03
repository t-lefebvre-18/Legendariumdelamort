<?php

function actionReservation($twig, $db)
{
    $form = array();
    $datePass = array();
    $reserv = new Reservation($db);
    $miseZero = $reserv->miseZero();
    if(isset($_POST['btSupReserv']))
    {
        $id = $_POST['idReserv'];
        $exec = $reserv->delete($id);
    }
    $liste = $reserv->select();
    $y = 0;
    foreach($liste as $date)
    {
        $dateReserv = strtotime($date['DateReservation']);
        $dateAjd = strtotime(date('Y-m-d'));
        if(($dateAjd-$dateReserv)/86400 >= 14)
        {
            $datePass[$y] = $date['IdReservation'];
            $y++;
        }
    }
    echo $twig->render('gestionReservation.html.twig', array('form'=>$form, 'liste'=>$liste, 'listePass'=>$datePass));
}
