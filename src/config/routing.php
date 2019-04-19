<?php
function getPage($db)
{
$lesPages['accueil'] = "actionAccueil;0";
$lesPages['connexion'] = "actionConnexion;0";
$lesPages['deconnexion'] = "actionDeconnexion;0";
$lesPages['apropos'] = "actionApropos;0";
$lesPages['mentions'] = "actionMentions;0";
$lesPages['inscription'] = "actionInscription;0";
$lesPages['maintenance'] = "actionMaintenance;0";
$lesPages['utilisateur'] = "actionUtilisateur;1";
$lesPages['gestionProduits'] = "actionProduit;1";
$lesPages['modifutilisateur'] = "actionModifUtilisateur;1";
$lesPages['modifProduit'] = "actionModifProduit;1";
$lesPages['roles'] = "actionRole;1";
$lesPages['modifRole'] = "actionModifRole;1";
$lesPages['gestionLivre'] = "actionLivre;1";
$lesPages['modifLivre'] = "actionModifLivre;1";
$lesPages['gestionType'] = "actionType;1";
$lesPages['modifType'] = "actionModifType;1";
$lesPages['gestionEditeur'] = "actionEditeur;1";
$lesPages['modifEditeur'] = "actionModifEditeur;1";
$lesPages['gestionAuteur'] = "actionAuteur;1";
$lesPages['modifAuteur'] = "actionModifAuteur;1";
$lesPages['gestionJeu'] = "actionJeu;1";
$lesPages['modifJeu'] = "actionModifJeu;1";
$lesPages['gestionCoupCoeur'] = "actionCoupCoeur;1";
$lesPages['modifCoupCoeur'] = "actionModifCoupCoeur;1";
$lesPages['gestionEvent'] = 'actionEvent;1';
$lesPages['modifEvent'] = 'actionModifEvent;1';
$lesPages['librairie'] = 'actionLibrairie;0';
$lesPages['livre'] = 'actionPresLivre;0';
$lesPages['gestionReservation'] = 'actionReservation;1';

if ($db != null)
{
if (isset($_GET['page']))
{
$page = $_GET['page'];
}
else
{
$page = 'accueil';
}
if (!isset($lesPages[$page]))
{
$page = 'accueil';
}
$explose = explode(";", $lesPages[$page]);
$role = $explose[1];
if ($role != 0)
{
if (isset($_SESSION['login']))
{
if (isset($_SESSION['role']))
{
if ($role != $_SESSION['role'])
{

$contenu = 'actionAccueil';
}
else
{
$contenu = $explose[0];
}
}
else
{
$contenu = 'actionAccueil';
}
} else
{
$contenu = 'actionAccueil';
}
} else
{
$contenu = $explose[0];
}
} else
{
// Si $db est null
$contenu = 'actionMaintenance';
}
return $contenu;
}

?>
