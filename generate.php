<html>
<head>
<?php
include_once("var.inc.php");
include_once("functions.inc.php");
include_once("encodage.inc.php");
include_once("stylef.php");
date_default_timezone_set('Europe/Paris');

/******** RECUP POST ET GET ********/

$database=$_GET["database"];
$table=$_GET["table"];
$titre_formulaire=$_POST["titre_formulaire"];
$tableau_ordre_tri=$_POST["tableau_ordre_tri"];
$tableau_ordre_tri_colonnes=$_POST["tableau_ordre_tri_colonnes"];
$nom_id=$_POST["nom_id"];
$name=$_POST["name"];
$label=$_POST["label"];
$type=$_POST["type"];
$len=$_POST["len"];
$flags=$_POST["flags"];
$critere=$_POST["critere"];
$col_affichable=$_POST["col_affichable"];
$nu=$_POST["nu"];
$tri=$_POST["tri"];
$editeur=$_POST["editeur"];
$hauteur_editeur=$_POST["hauteur_editeur"];
$largeur_editeur=$_POST["largeur_editeur"];
$photos=$_POST["photos"];
$fichiers=$_POST["fichiers"];
$etapes=$_POST["etapes"];
$etapes2=$_POST["etapes2"];
$etapes3=$_POST["etapes3"];
$etapesnan=$_POST["etapesnan"];
$etapesnan2=$_POST["etapesnan2"];
$etapesnan3=$_POST["etapesnan3"];
$vue=$_POST["vue"];
$vue_admin=$_POST["vue_admin"];
$maj_cols=$_POST["maj_cols"];
$ins_cols=$_POST["ins_cols"];
$tableau_ordre=$_POST["tableau_ordre"];
$tableau_ordre_admin=$_POST["tableau_ordre_admin"];
$defauts=$_POST["defauts"];
$tables=$_POST["tables"];
$cols1=$_POST["cols1"];
$cols2=$_POST["cols2"];
$req_fk=$_POST["req_fk"];
$div_attributs=$_POST["div_attributs"];
$attributs_edit=$_POST["attributs_edit"];
$div_attributs_edit=$_POST["div_attributs_edit"];
$div_attributs_vue=$_POST["div_attributs_vue"];
$div_attributs_view=$_POST["div_attributs_view"];
$attributs=$_POST["attributs"];
$diag_etats=$_POST["diag_etats"];
$actions1=$_POST["actions1"];
$js_deb_insertion=$_POST["js_deb_insertion"];
$js_fonction_insertion=$_POST["js_fonction_insertion"];
$js_deb_edition=$_POST["js_deb_edition"];
$js_fonction_edition=$_POST["js_fonction_edition"];
$js_deb_maj=$_POST["js_deb_maj"];
$js_deb_ins=$_POST["js_deb_ins"];
$js_fonction_maj=$_POST["js_fonction_maj"];
$js_fonction_ins=$_POST["js_fonction_ins"];
$insertion_deb_insertion=$_POST["insertion_deb_insertion"];
$insertion_fin_insertion=$_POST["insertion_fin_insertion"];
$insertion_deb_edition=$_POST["insertion_deb_edition"];
$insertion_fin_edition=$_POST["insertion_fin_edition"];
$insertion_deb_vue=$_POST["insertion_deb_vue"];
$insertion_fin_vue=$_POST["insertion_fin_vue"];
$insertion_deb_view=$_POST["insertion_deb_view"];
$insertion_fin_view=$_POST["insertion_fin_view"];
$insertion_deb_maj=$_POST["insertion_deb_maj"];
$insertion_fin_maj=$_POST["insertion_fin_maj"];
$insertion_deb_ins=$_POST["insertion_deb_ins"];
$insertion_fin_ins=$_POST["insertion_fin_ins"];
$insertion_deb_suivi_user=$_POST["insertion_deb_suivi_user"];
$insertion_deb_suivi_admin=$_POST["insertion_deb_suivi_admin"];
$insertion_boucle_suivi_user=$_POST["insertion_boucle_suivi_user"];
$insertion_boucle_suivi_admin=$_POST["insertion_boucle_suivi_admin"];
$insertion_fin_suivi_user=$_POST["insertion_fin_suivi_user"];
$insertion_fin_suivi_admin=$_POST["insertion_fin_suivi_admin"];
$insertion_tout_deb_moteur=$_POST["insertion_tout_deb_moteur"];
$insertion_deb_moteur=$_POST["insertion_deb_moteur"];
$insertion_boucle_moteur=$_POST["insertion_boucle_moteur"];
$insertion_fin_moteur=$_POST["insertion_fin_moteur"];

$CIF=$_POST["CIF"];
$rech_1an=$_POST["rech_1an"];
$navigation=$_POST["navigation"];
$relation=$_POST["relation"];
$association=$_POST["association"];
$table_fille=$_POST["table_fille"];
$num_colonne2=$_POST["num_colonne2"];
$num_colonne2_fk=$_POST["num_colonne2_fk"];
$num_autre_colonne=$_POST["num_autre_colonne"];
$mode_affichage_popup=$_POST["mode_affichage_popup"];
$rech_nan=$_POST["rech_nan"];
$sup_cascade=$_POST["sup_cascade"];
$navigation2=$_POST["navigation2"];
$couleur_page=$_POST["couleur_page"];

$mod_v=$_POST["mod_v"];
$mod_m=$_POST["mod_m"];
$mod_i=$_POST["mod_i"];
$mod_d=$_POST["mod_d"];
$mod_w=$_POST["mod_w"];

$mod=$mod_v.$mod_m.$mod_i.$mod_d.$mod_w;

$nb_col_affichable=$_POST["nb_col_affichable"];
$moteur=$_POST["moteur"];
$insert=$_POST["insert"];
$del=$_POST["del"];
$edit=$_POST["edit"];
$view=$_POST["view"];
$voir=$_POST["voir"];
$tableau_gen=$_POST["tableau_gen"];
$workflow_ins=$_POST["workflow_ins"];
$workflow_edit=$_POST["workflow_edit"];
$param=$_POST["param"];
$excel=$_POST["excel"];
$vue_util_zone_vide=$_POST["vue_util_zone_vide"];
$view_admin_zone_vide=$_POST["view_admin_zone_vide"];

?>
</head>
<body bgcolor="#FFCC99">
<?php
include("gen_config.php");

$filename_config = $table."_config.php";
include($filename_config);

if (isset($param)&&($param==1)){
	include("gen_parametres.php");
}

if (isset($moteur)&&($moteur==1)){
	include("gen_moteur.php");
}

if (isset($excel)&&($excel==1)){
	include("gen_xls.php");
}

if (isset($insert)&&($insert==1)){
	include("gen_ins.php");
}
if (isset($workflow_ins)&&($workflow_ins==1)){
	include("gen_workflow_ins.php");
}

if (isset($workflow_edit)&&($workflow_edit==1)){
	include("gen_workflow_edit.php");
}

if (isset($edit)&&($edit==1)){
	include("gen_edit.php");
}

if (isset($del)&&($del==1)){
	include("gen_del.php");
}

if (isset($view)&&($view==1)){
	include("gen_view.php");
}

if (isset($voir)&&($voir==1)){
	include("gen_vue.php");
}

if (isset($tableau_gen)&&($tableau_gen==1)){
	include("gen_tableau.php");
	include("gen_tableau_admin.php");
}

?>
<a href=javascript:history.back()>Voir a nouveau les parametres</a>
<br/><br/>
<a href="db.php">Retour au menu general</a>

<hr>
<?php
//include("param_read.php");
?>
</body>
</html>
