<?php
session_start();
/* initialisation des fichiers TWIG */
require_once '../src/lib/vendor/autoload.php';
require_once '../src/config/parametres.php';
    require_once '../src/app/connexion.php';
    require_once '../src/config/routing.php';
require_once '../src/controleur/_controleurs.php';
    require_once '../src/modele/_classes.php';
    $db = connect($config);
    $loader = new Twig_Loader_Filesystem('../src/vue/');
    $twig = new Twig_Environment($loader, array());
$twig->addGlobal('session',$_SESSION);

    $reservation = new Reservation($db);
    $notifReserv = $reservation->selectNotif();
    $notifReserv = $notifReserv[0];
$twig->addGlobal('notifReserv', $notifReserv);

    $type = new Type($db);
$types = $type->select();
    $twig->addGlobal('types', $types);

    $twig->addGlobal('notif', 0);

$contenu = getPage($db);
$contenu($twig, $db);
?>
