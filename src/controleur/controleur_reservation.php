<?php

function actionReservation($twig, $db)
{
    $form = array();
    $reserv = new Reservation($db);
    if(isset($_POST['btSupReserv']))
    {
        $id = $_POST['idReserv'];
        $exec = $reserv->delete($id);
    }
    $liste = $reserv->select();
    echo $twig->render('gestionReservation.html.twig', array('form'=>$form, 'liste'=>$liste));
}
