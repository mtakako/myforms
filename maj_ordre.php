<?php
include_once("var.inc.php");
include("ch_coordonnees_parametres.php");
include_once("functions.inc.php");
$connexion=connexion($bdd);

if (!empty($_POST["id_service"])){
	for ($i=0; $i<sizeof($_POST["id_affichage"]); $i++){
		if (!empty($_POST["ordre_affichage"][$i])&&$_POST["ordre_affichage"][$i]!=0){
			$req="update ch_coordonnees set ordre_coordonnee=".$_POST["ordre_affichage"][$i]." where id_coordonnee=".$_POST["id_affichage"][$i];
			execute_sql($req);
		
		}
	}
	header("Location: ch_coordonnees_rech.php?id_service=".$_POST["id_service"]);
}
elseif (!empty($_POST["id_pole"])){
	for ($i=0; $i<sizeof($_POST["id_affichage"]); $i++){
		if (!empty($_POST["ordre_affichage"][$i])&&$_POST["ordre_affichage"][$i]!=0){
			$req="update ch_unites_services set ordre_service=".$_POST["ordre_affichage"][$i]." where id_service=".$_POST["id_affichage"][$i];
			execute_sql($req);
		}
	}
	header("Location: ch_unites_services_rech.php?id_pole=".$_POST["id_pole"]);
}

?>
