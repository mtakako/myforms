<?php
/****************Definition des variables connexion**********/
//nom de l'hote
$host="localhost";
//nom d'utilisateur
$user="user";
//mot de passe de l'utilisateur
$password="pwd";
//encodage base utf8 ou latin1
$encodage_bdd="utf8";
//encodage general de PHP : UTF-8 ou ISO-8859-1
$encodage="UTF-8";
//envoyer les emails : 0 pour les tests ou 1 pour la production
$messagerie="0";
/************************************************************/
/****************Extension des fichiers *******/
//extension des fichiers php :
$extension="php";
/************************************************************/
/****************Variables pour les couleurs****************/
//couleur des liens
$couleur_liens="#FF6600";
//couleur des objets
$couleur_objets="#DDF4FD";
//couleur du fond de page
$couleur_fond_page="#FFFFFF";
//couleur du fond de page
$couleur_fond_menu="#DDDDDD";
//couleur de fond du haut de page
$couleur_fond_haut="#FFFFFF";
//couleur de fond du bas de page
$couleur_fond_bas="#FFFFFF";
//couleur de la ligne 0 sur les resultat de la recherche
$couleur_ligne0="";
//couleur de la ligne 1 sur les resultat de la recherche
$couleur_ligne1="#DDDDDD";
//couleur des objets qui ne sont qu'en lecture seule
$couleur_protege="#D0D0D0";
//couleur des objets gerant les relations n a n
$couleur_relation_nan="#CCFFFF";
//couleur des titres
$couleur_page="#000000";
/************************************************************/
/****************Variables pour le Webmaster****************/
//Demande de validation de la suppression des relations n a n
//0 pour suppression sans demande de confirmation et 1 avec demande
$confirm_sup="1";
//afficher l'ensemble sous forme de frame
$frame="0";
//Nombre de lignes par page dans le moteur de recherche
$nbLig="10";
//Nombre de pages en lien avant et apres la page en cours
$ecart_page="5";
//Choix de la font et de sa taille, ex :Verdana, Arial, Helvetica, sans-serif
$font="Trebuchet MS,Helvetica,Verdana,sans-serif";
//taille de la police
$font_size="11px";
//affichage tabulaire (mode tableau) : 0 sinon 1 pour un affichage type formulaire
$mod_tabulaire_moteur="0";
//affichage page par page avec la valeur 0, si 1 alors tout s'affiche dans la page
$all_lignes="0";
//MODE PAR DEFAUT affichage des fenetres popup qui affiche la liste d'une table
// O convient a de petites bases de donnees  (centaines d'enregistrements par table)
// 2 convient a des base de donnees grosses (plusieurs milliers d'enregistrements par table)
$affiche_popup="0";
//afficher une barre de couleur en haut et en bas de page
$affiche_barres="0";
//repertoire dans lequel sont stockees les photos
$rep="./fichiers";
//afficher la liste des colonnes affichables dans le moteur
$affichage_choix_colonne="1";
//afficher le critere de tri
$affichage_tri="1";
//taille du texte qui sera tronque
$lg_max="150";
//Affichage des listes deroulantes de mise a jour des tables 1 a N au moment de l'insertion
$un_a_n_insertion="0";
//Affichage des listes des tables 1 a N au moment de la mise a jour
$un_a_n_maj="0";
//Affichage de la cle etrangere si la valeur de la table etrangere est vide
$affichage_id_etranger="1";
//Affichage des boutons radio horizontal ou non
$affichage_radio_horizontal="1";
//Affichage des boutons checkbox horizontal ou non
$affichage_checkbox_horizontal="1";
/************************************************************/
/****************Definition des variables affichage**********/
//titre du site
$titreDesPages="Formulaires";
//titre du lien rechercher
$rechercher_asc="Recherche ascendante";
//titre du lien rechercher
$rechercher_desc="Recherche descendante";
//titre du lien rechercher
$rechercher="Rechercher";
//titre du lien nouveau
$nouveau="Nouveau";
//titre du lien nouvelle recherche
$autre_rechercher="Nouvelle recherche";
//titre du lien effacer
$reset="Effacer";
//afficher tous les enregistrements
$lister_tous="(Tous)";
//titre des pages moteur de recherche
$titreMoteur="";
//titre des pages formulaire d'insertion
$titreInsert="";
//titre des pages formulaire de mise a jour
$titreEdit="";
//titre des pages formulaire de detail
$titreView="";
//titre des pages de la page tableau
$titreTableau="Suivi de";
//titre du lien Inserer
$inserer="Enregister et envoyer";
//titre du lien Inserer dans le moteur de recherche
$inserer_moteur="Inserer un nouveau";
//titre du lien Mettre a jour
$updater="Enregistrer";
//message pour insertion bien effectu&eacute;e
$inserer_OK="";
//message pour mise a jour bien effectu&eacute;e
$update_OK="";
//message pour suppression bien effectu&eacute;e
$del_OK="Suppression effectuee.";
//titre du lien Pr&eacute;c&eacute;dent
$retour="Precedent";
//titre des pages formulaire de Suppression
$titreDel="Formulaire de Suppression";
//titre du lien Fermer
$fermeture="Fermer";
//message pour v&eacute;rifier les suppression en cascade
$message_sup_nan="L'enregistrement que vous voulez supprimer est en lien avec la table ";
//affichage pour le choix des colonnes a afficher
$message_affichage_colonnes="Affichage des colonnes<br>(Ctrl+clic)";
//affichage pour le choix du tri
$message_tri_colonnes="Choix de tri";
//Texte du bouton d'export vers excel
$bouton_xls="Export Excel";
$lancer_rech="1";
/************************************************************/
?>
