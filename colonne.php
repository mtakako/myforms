<html>
<head>
<title>MyForms</title>
<?php
include_once("var.inc.php");
include_once("functions.inc.php");
include_once("encodage.inc.php");
include_once("stylef.php");
date_default_timezone_set('Europe/Paris');

$database=$_POST["database"];
$table=$_POST["table"];
@include("gen_diag_config.php");
?>

<script type="text/javascript">
function valider(){
	if (document.forms[0].couleur_page.value==""){
		alert("Renseigner la zone couleur de la page");
		document.forms[0].couleur_page.focus();
		return;
	}
	act='generate.php?database=<?php echo $database?>&table=<?php echo $table?>';
	document.formulaire.action=act;
	document.formulaire.submit();
}
</script>
<script language="javascript" src="scripts.js"></script>
</head>
<body>
<?php
@include_once($_POST["table"]."_config.php");
@include_once($_POST["table"]."_diag.php");
?>
<form name="formulaire" method="post">
<?php
$connexion=connexion($database);
$result = execute_sql("select * from $table");
$fields = mysqli_num_fields($result);
$rows   = mysqli_num_rows($result);
$i=0;
$table = db_field_direct_name($result, $i);
echo "<h2>La table '".$table."' possede ".$fields." colonne(s) et ".$rows." enregistrement(s).  </h2><br />";
?>
Titre du formulaire : <input size="60" type="text" name="titre_formulaire" value="<?php echo $titre_formulaire?>">

<p><b><u>1) Choisir les colonnes qui apparaitront dans le moteur de
	recherche</u></b></p>
<table border=1 bordercolor="1" cellspacing="0">
	<tr bgcolor="#CCCCCC">
		<th>Colonne / Libell&eacute;</th>
		<th>Type</th>
		<th>Longueur</th>
		<th>Propri&eacute;t&eacute;s</th>
		<th>&nbsp;</th>
		<th>Crit&egrave;res de recherche</th>
		<th>&nbsp;</th>
		<th>Colonnes affichables</th>
		<th>Colonnes affich&eacute;es par d&eacute;faut</th>
		<th>Trier sur une colonne</th>
		<th>Editeur (Hauteur Px)</th>
		<th>Photos</th>
		<th>Fichiers</th>
		<?php
		if (!isset($_GET['simple'])){
		?>
		<th>Colonne affich&eacute;es dans l'&eacute;tat sélectionn&eacute;</th>
		<th>Vue Workflow<input type=checkbox name=vue_util_zone_vide <?php if ($vue_util_zone_vide=="invisible") echo "checked"?> value=invisible>Zones vides invisibles</th>
		<?php
		}
		?>

		<th>Vue Moteur.<input type=checkbox name=view_admin_zone_vide <?php if ($view_admin_zone_vide=="invisible") echo "checked"?> value=invisible>Zones vides invisibles</th>
		<th>MAJ</th>
		<th>INS</th>
		<?php
		if (!isset($_GET['simple'])){
		?>
		<th>Tableau de suivi Workflow<br>Col date<input type="text" name="tableau_ordre_tri" value="<?php echo $tableau_ordre_tri?>"><br />Tri date<br /><input type="text" name="tableau_ordre_tri_colonnes" value="<?php echo $tableau_ordre_tri_colonnes?>"></th>
		<?php
		}
		?>
		<th>D&eacute;faut Insertion</th>
		<th>Indiquer la table et la colonne &agrave; l'origine de la cl&eacute; &eacute;trang&egrave;re</th>
		<th>Attribut html des formulaires Insertion</th>
		<th>Attribut html des formulaires Edition</th>
		<?php
		if (!isset($_GET['simple'])){
		?>
		<th>Attribut html dans la VUE Workflow</th>
		<?php
		}
		?>
		<th>Attribut html dans la VUE depuis le Moteur</th>		
		</tr>
<?php

while ($i < $fields) {
	$type  = db_field_direct_type($result, $i);
	$name  = db_field_direct_name($result, $i);
	$len   = db_field_direct_len($result, $i);
	$flags = db_field_direct_flags($result, $i);
	if ($i==0)
		echo "<input type=HIDDEN name=nom_id value=\"$name\">\n";

	echo "<tr ALIGN=center>";
	echo "<td><input type=hidden name=name[] value=\"$name\"><b>$name<br /><input type=text name=label[] value=\"";
	if (isset($label[$i])&&!empty($label[$i]))
		echo $label[$i];
	else
		echo $name;
	echo "\"></b></td>\n";
	echo "<td><input type=hidden name=type[] size=6 value=\"$type\">$type</td>";
	echo "<td><input type=hidden size=6 name=len[] value=\"$len\">$len</td>";
	echo "<td><input type=hidden size=6 name=flags[] value=\"$flags\">$flags</td>";

	echo "<td>&nbsp;</td>\n";
	echo "<td><input type=checkbox name=\"critere[]\" ";
	if (isset($critere)&&in_array($i,$critere))
		echo " checked ";
	echo "value=$i></td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td><input type=checkbox name=\"col_affichable[]\" ";
	if (isset($col_affichable)&&in_array($i,$col_affichable))
		echo " checked ";
	echo "value=$i></td>\n";

	echo "<td><input type=checkbox name=\"nu[]\" ";
	if (isset($nu)&&in_array($i,$nu))
		echo " checked ";
	echo "value=$i></td>\n";

	if (($i==0)&&!isset($tri))
		echo "<td><input type=radio name=tri value=$name checked></td>\n";
	elseif ($tri==$name)
		echo "<td><input type=radio name=tri value=$name checked></td>\n";
	else
		echo "<td><input type=radio name=tri value=$name></td>\n";

	echo "<td><input type=checkbox name=editeur[] ";
	if (isset($editeur)&&in_array($i,$editeur))
		echo " checked ";
	echo "value=$i><br />";
	echo "<input type=text size=4 name=hauteur_editeur[] value=\"";
	if (isset($hauteur_editeur))
		echo $hauteur_editeur[$i];
	echo "\">";
	echo "<input type=text size=4 name=largeur_editeur[] value=\"";
	if (isset($largeur_editeur))
		echo $largeur_editeur[$i];
	echo "\">";
	echo "</td>\n";

	echo "<td><input type=checkbox name=photos[] ";
	if (isset($photos)&&in_array($i,$photos))
		echo " checked ";
	echo "value=$i></td>\n";

	echo "<td><input type=checkbox name=fichiers[] ";
	if (isset($fichiers)&&in_array($i,$fichiers))
		echo " checked ";
	echo "value=$i></td>\n";

	if (!isset($_GET['simple'])){
		echo "<td>";
		$val_defaut='Tous';
		if (isset($etapes[$i])&&!empty($etapes[$i]))
			$val_defaut=$etapes[$i];
		enum_etat($lesetapes,"etapes[]",$val_defaut);
		$val_defaut='';
		if (isset($etapes2[$i])&&!empty($etapes2[$i]))
			$val_defaut=$etapes2[$i];
		enum_etat_niveau($lesetapes,"etapes2[]",$val_defaut);
		$val_defaut='';
		if (isset($etapes3[$i])&&!empty($etapes3[$i]))
			$val_defaut=$etapes3[$i];
		enum_etat_niveau($lesetapes,"etapes3[]",$val_defaut);
		echo "</td>\n";
		echo "<td><input type=checkbox name=\"vue[]\" ";
		if (isset($vue)&&in_array($i,$vue))
			echo " checked ";
		echo "value=$i></td>\n";
	}

	echo "<td><input type=checkbox name=\"vue_admin[]\" ";
	if (isset($vue_admin)&&in_array($i,$vue_admin))
		echo " checked ";
	echo "value=$i></td>\n";
	
	echo "<td><input type=checkbox name=\"maj_cols[]\" ";
	if (isset($maj_cols)&&in_array($i,$maj_cols))
		echo " checked ";
	echo "value=$i></td>\n";
	
	echo "<td><input type=checkbox name=\"ins_cols[]\" ";
	if (isset($ins_cols)&&in_array($i,$ins_cols))
		echo " checked ";
	echo "value=$i></td>\n";

	if (!isset($_GET['simple'])){	
		echo "<td>\n";
		echo "T1<input type=text size=2 name=tableau_ordre[$i] value=\"$tableau_ordre[$i]\">";
		echo "T2<input type=text size=2 name=tableau_ordre_admin[$i] value=\"$tableau_ordre_admin[$i]\">";
		echo "</td>\n";
	}	
	echo "<td><input type=text name=defauts[] value=\"";
	if (isset($defauts[$i])&&!empty($defauts[$i]))
		echo $defauts[$i];
	echo "\"></b></td>\n";


	echo "<td>\n";
	echo "<input name=tables[$i] value='".$tables[$i]."' type=text>";
	echo "<a href=javascript:OuvrirPopupTable('$database','tables[$i]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>";
	echo "</select>";
	echo "<br />Col1<input type=text size=2 name=cols1[] value=\"";
	if (isset($cols1[$i])&&!empty($cols1[$i]))
		echo $cols1[$i];
	else
		echo "0";
	echo "\">";
	echo "Col2<input type=text size=2 name=cols2[] value=\"";
	if (isset($cols2[$i])&&!empty($cols2[$i]))
		echo $cols2[$i];
	else
		echo "1";
	echo "\">";
	echo "<input type=text size=20 name=req_fk[] value=\"";
	if (isset($req_fk[$i])&&!empty($req_fk[$i]))
		echo $req_fk[$i];
	echo "\">";
	echo "</td>";
	
	echo "<td>DIV<textarea name=\"div_attributs[$i]\" cols=\"20\" rows=\"1\">";
	if (isset($div_attributs[$i])&&!empty($div_attributs[$i]))
		echo $div_attributs[$i];
	echo "</textarea>";
	echo "INPUT<textarea name=\"attributs[$i]\" cols=\"20\" rows=\"1\">";
	if (isset($attributs[$i])&&!empty($attributs[$i]))
		echo $attributs[$i];
	echo "</textarea>";	
	echo "</td>";
	
	echo "<td>DIV<textarea name=\"div_attributs_edit[$i]\" cols=\"20\" rows=\"1\">";
	if (isset($div_attributs_edit[$i])&&!empty($div_attributs_edit[$i]))
		echo $div_attributs_edit[$i];
	echo "</textarea>";
	echo "INPUT<textarea name=\"attributs_edit[$i]\" cols=\"20\" rows=\"1\">";
	if (isset($attributs_edit[$i])&&!empty($attributs_edit[$i]))
		echo $attributs_edit[$i];
	echo "</textarea>";
	echo "</td>";
	
	if (!isset($_GET['simple'])){
		echo "<td>DIV<textarea name=\"div_attributs_vue[$i]\" cols=\"20\" rows=\"1\">";
		if (isset($div_attributs_vue[$i])&&!empty($div_attributs_vue[$i]))
			echo $div_attributs_vue[$i];
		else echo "width=30%";
		echo "</textarea>";
		echo "</td>";
	}
	echo "<td>DIV<textarea name=\"div_attributs_view[$i]\" cols=\"20\" rows=\"1\">";
	if (isset($div_attributs_view[$i])&&!empty($div_attributs_view[$i]))
		echo $div_attributs_view[$i];
	else echo "width=30%";
	echo "</textarea>";
	echo "</td>";


	$i++;
	echo "</tr>";
}
?>
</table>
<br />

<?php
if (!isset($_GET['simple'])){
?>
<table border=1 bordercolor="1" cellspacing="0">
	<tr bgcolor="#CCCCCC">
		<th>Liste des Etats</th>
		<th>Actions au passage dans cet &eacute;tat</th>
	</tr>
<?php
	for ($i=0;$i<count($lesetats);$i++){
		echo "<tr>";
		echo "<td>$lesetats[$i]</td>";
		echo "<td><textarea name=\"actions1[]\" cols=\"80\" rows=\"4\">";
		if (isset($actions1[$i])&&!empty($actions1[$i]))
			echo $actions1[$i];
		echo "</textarea></td>";
		echo "<tr>";
	}
?>
</table>
<?php
}
?>
<br />
<table border=1 bordercolor="1" cellspacing="0">
	<tr bgcolor="#CCCCCC">
		<th>Inclusion de JS</th>
		<?php
		if (!isset($_GET['simple'])){
		?>
		<th>Dans Workflow Insertion</th>
		<th>Dans Workflow Edition</th>
		<?php
		}
		?>
		<th>Dans Formulaire Edition</th>
		<th>Dans Formulaire Insertion</th>
	</tr>
	<tr>
		<td>Dans le code de validation du formulaire</td>
		<?php
		if (!isset($_GET['simple'])){
		?>
			<?php
			echo "<td><textarea name=\"js_deb_insertion\" cols=\"50\" rows=\"2\">";
			if (isset($js_deb_insertion)&&!empty($js_deb_insertion))
				echo $js_deb_insertion;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"js_deb_edition\" cols=\"50\" rows=\"2\">";
			if (isset($js_deb_edition)&&!empty($js_deb_edition))
				echo $js_deb_edition;
			echo "</textarea></td>";
			?>
		<?php
		}
		?>
		<?php
		echo "<td><textarea name=\"js_deb_maj\" cols=\"50\" rows=\"2\">";
		if (isset($js_deb_maj)&&!empty($js_deb_maj))
			echo $js_deb_maj;
		echo "</textarea></td>";
		?>	
		<?php
		echo "<td><textarea name=\"js_deb_ins\" cols=\"50\" rows=\"2\">";
		if (isset($js_deb_ins)&&!empty($js_deb_ins))
			echo $js_deb_ins;
		echo "</textarea></td>";
		?>		
	</tr>
	<tr>
		<td>Fonctions JavaScript</td>
		<?php
		if (!isset($_GET['simple'])){
		?>
			<?php
			echo "<td><textarea name=\"js_fonction_insertion\" cols=\"50\" rows=\"2\">";
			if (isset($js_fonction_insertion)&&!empty($js_fonction_insertion))
				echo $js_fonction_insertion;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"js_fonction_edition\" cols=\"50\" rows=\"2\">";
			if (isset($js_fonction_edition)&&!empty($js_fonction_edition))
				echo $js_fonction_edition;
			echo "</textarea></td>";
			?>
		<?php
		}
		?>
		<?php
		echo "<td><textarea name=\"js_fonction_maj\" cols=\"50\" rows=\"2\">";
		if (isset($js_fonction_maj)&&!empty($js_fonction_maj))
			echo $js_fonction_maj;
		echo "</textarea></td>";
		?>	
		<?php
		echo "<td><textarea name=\"js_fonction_ins\" cols=\"50\" rows=\"2\">";
		if (isset($js_fonction_ins)&&!empty($js_fonction_ins))
			echo $js_fonction_ins;
		echo "</textarea></td>";
		?>			
	</tr>
</table>

<br />
<table border=1 bordercolor="1" cellspacing="0">
	<tr bgcolor="#CCCCCC">
		<th>Inclusion de PHP ou JavaScript ou CSS</th>
		<?php
		if (!isset($_GET['simple'])){
		?>
		<th>Dans workflow Insertion</th>
		<th>Dans workflow Edition</th>
		<th>Dans la Vue depuis le Workflow</th>		
		<?php
		}
		?>
		<th>Dans Formulaire Edition</th>
		<th>Dans Formulaire Insertion</th>
		<th>Dans la Vue depuis le Moteur</th>
	</tr>
	<tr>
		<td>D&eacute;but de ficher</td>
		<?php
		if (!isset($_GET['simple'])){
		?>
			<?php
			echo "<td><textarea name=\"insertion_deb_insertion\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_deb_insertion)&&!empty($insertion_deb_insertion))
				echo $insertion_deb_insertion;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"insertion_deb_edition\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_deb_edition)&&!empty($insertion_deb_edition))
				echo $insertion_deb_edition;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"insertion_deb_vue\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_deb_vue)&&!empty($insertion_deb_vue))
				echo $insertion_deb_vue;
			echo "</textarea></td>";
			?>	
		<?php
		}
		?>
		<?php
		echo "<td><textarea name=\"insertion_deb_maj\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_deb_maj)&&!empty($insertion_deb_maj))
			echo $insertion_deb_maj;
		echo "</textarea></td>";
		?>
		<?php
		echo "<td><textarea name=\"insertion_deb_ins\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_deb_ins)&&!empty($insertion_deb_ins))
			echo $insertion_deb_ins;
		echo "</textarea></td>";
		?>
		<?php
		echo "<td><textarea name=\"insertion_deb_view\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_deb_view)&&!empty($insertion_deb_view))
			echo $insertion_deb_view;
		echo "</textarea></td>";
		?>
	
	</tr>
	<tr>
		<td>Fin de fichier</td>
		<?php
		if (!isset($_GET['simple'])){
		?>
			<?php
			echo "<td><textarea name=\"insertion_fin_insertion\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_fin_insertion)&&!empty($insertion_fin_insertion))
				echo $insertion_fin_insertion;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"insertion_fin_edition\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_fin_edition)&&!empty($insertion_fin_edition))
				echo $insertion_fin_edition;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"insertion_fin_vue\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_fin_vue)&&!empty($insertion_fin_vue))
				echo $insertion_fin_vue;
			echo "</textarea></td>";
			?>
		<?php
		}
		?>
		<?php
		echo "<td><textarea name=\"insertion_fin_maj\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_fin_maj)&&!empty($insertion_fin_maj))
			echo $insertion_fin_maj;
		echo "</textarea></td>";
		?>
		<?php
		echo "<td><textarea name=\"insertion_fin_ins\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_fin_ins)&&!empty($insertion_fin_ins))
			echo $insertion_fin_ins;
		echo "</textarea></td>";
		?>
		<?php
		echo "<td><textarea name=\"insertion_fin_view\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_fin_view)&&!empty($insertion_fin_view))
			echo $insertion_fin_view;
		echo "</textarea></td>";
		?>	
	
	</tr>
</table>
<br />
<table border=1 bordercolor="1" cellspacing="0">
	<tr bgcolor="#CCCCCC">
		<th>Inclusion de PHP ou JavaScript ou CSS</th>
		<?php
		if (!isset($_GET['simple'])){
		?>
		<th>Dans tableau de suivi Utilisateur</th>
		<th>Dans tableau de suivi Administrateur</th>
		<?php
		}
		?>
		<th>Dans le moteur de recherche</th>
	</tr>
	<tr>
		<td>Tout début du ficher</td>
		<?php
		if (!isset($_GET['simple'])){
		?>
			<?php
			echo "<td></td>";
			?>
			<?php
			echo "<td></td>";
			?>
		<?php
		}
		?>
		<?php
		echo "<td><textarea name=\"insertion_tout_deb_moteur\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_tout_deb_moteur)&&!empty($insertion_tout_deb_moteur))
			echo $insertion_tout_deb_moteur;
		echo "</textarea></td>";
		?>
	</tr>
	
	<tr>
		<td>Début du ficher avant boutons</td>
		<?php
		if (!isset($_GET['simple'])){
		?>
			<?php
			echo "<td><textarea name=\"insertion_deb_suivi_user\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_deb_suivi_user)&&!empty($insertion_deb_suivi_user))
				echo $insertion_deb_suivi_user;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"insertion_deb_suivi_admin\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_deb_suivi_admin)&&!empty($insertion_deb_suivi_admin))
				echo $insertion_deb_suivi_admin;
			echo "</textarea></td>";
			?>
		<?php
		}
		?>
		<?php
		echo "<td><textarea name=\"insertion_deb_moteur\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_deb_moteur)&&!empty($insertion_deb_moteur))
			echo $insertion_deb_moteur;
		echo "</textarea></td>";
		?>
	</tr>
	<tr>
		<td>Boucle ou milieu du fichier</td>
		<?php
		if (!isset($_GET['simple'])){
		?>
			<?php
			echo "<td><textarea name=\"insertion_boucle_suivi_user\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_boucle_suivi_user)&&!empty($insertion_boucle_suivi_user))
				echo $insertion_boucle_suivi_user;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"insertion_boucle_suivi_admin\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_boucle_suivi_admin)&&!empty($insertion_boucle_suivi_admin))
				echo $insertion_boucle_suivi_admin;
			echo "</textarea></td>";
			?>
		<?php
		}
		?>
		<?php
		echo "<td><textarea name=\"insertion_boucle_moteur\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_boucle_moteur)&&!empty($insertion_boucle_moteur))
			echo $insertion_boucle_moteur;
		echo "</textarea></td>";
		?>
	</tr>	
	<tr>
		<td>Fin de fichier</td>
		<?php
		if (!isset($_GET['simple'])){
		?>
			<?php
			echo "<td><textarea name=\"insertion_fin_suivi_user\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_fin_suivi_user)&&!empty($insertion_fin_suivi_user))
				echo $insertion_fin_suivi_user;
			echo "</textarea></td>";
			?>
			<?php
			echo "<td><textarea name=\"insertion_fin_suivi_admin\" cols=\"50\" rows=\"2\">";
			if (isset($insertion_fin_suivi_admin)&&!empty($insertion_fin_suivi_admin))
				echo $insertion_fin_suivi_admin;
			echo "</textarea></td>";
			?>
		<?php
		}
		?>
		<?php
		echo "<td><textarea name=\"insertion_fin_moteur\" cols=\"50\" rows=\"2\">";
		if (isset($insertion_fin_moteur)&&!empty($insertion_fin_moteur))
			echo $insertion_fin_moteur;
		echo "</textarea></td>";
		?>
	</tr>
</table>
<p><br />
	<b><u>2) Choisir les tables qui sont en relation 1 &agrave; n avec la table '<?php echo $table?>'
			(tables filles)</u></b><br>
	<br />
	<?php
	//$resultat = mysqli_list_tables($database);
	
	$j = 0;
	?>
<table border=1 cellspacing="0" bordercolor="1">
	<tr bgcolor="#CCCCCC">
		<th>
		<p>
			S&eacute;lectionner les tables qui possedent en cl&eacute; &eacute;trang&egrave;re, l'identifiant
			de la table en cours.</p>
		</th>
	</tr>
<?php

echo "<tr ALIGN=center><td>";

echo "<textarea cols=60 rows=10 name=CIF>$CIF</textarea>";
echo "<a href=javascript:OuvrirPopupTable('$database','CIF','2')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>";

/*
echo "<select name=CIF[] MULTIPLE size=6><br />\n";
while ($j < mysqli_num_rows ($resultat)) {
	$tb_names[$j] = mysqli_tablename ($resultat, $j);
	echo "<OPTION value=$tb_names[$j]>$tb_names[$j] \n";
	$j++;
}
echo "</select>";
*/
echo "</td>";

?>
	</tr>
	<tr><td>
	<?php
if ($rech_1an==1)
	echo "<input type=checkbox name=rech_1an checked value=1>Ajouter Les tables comme crit&egrave;res de recherche</td></tr><tr><td>\n";
else
	echo "<input type=checkbox name=rech_1an value=1>Ajouter Les tables comme crit&egrave;res de recherche</td></tr><tr><td>\n";

if ($sup_cascade==1)
	echo "<input type=checkbox name=sup_cascade checked value=1>Suppression en cascade des enregistrements</td></tr><tr><td>\n";
else
	echo "<input type=checkbox name=sup_cascade value=1>Suppression en cascade des enregistrements</td></tr><tr><td>\n";
	
if ($navigation==1)
	echo "<input type=checkbox name=navigation checked value=1>Mettre un lien vers les tables dans le r&eacute;sultat de la recherche</td>\n";
else
	echo "<input type=checkbox name=navigation value=1>Mettre un lien vers les tables dans le r&eacute;sultat de la recherche</td>\n";

?>
</tr>
</table>
<br /><br /><br />
	<b><u>3) Choisir les tables qui sont en relation n &agrave; n avec la table '<?php echo $table?>'</u><br>
	<br />
<table border=1 cellspacing="0" bordercolor="1">
	<tr bgcolor="#CCCCCC">
		<th>Table relation avec '<?php echo $table?>'</th><th>Table relation avec '<?php echo $table?>'</th><th>Table filles avec '<?php echo $table?>'</th>
	</tr>


<?php
echo "<tr><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"relation[0]\" value=\"$relation[0]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','relation[0]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"association[0]\" value=\"$association[0]\">\n";
echo "<a href=javascript:OuvrirPopupRelation('$database','association[0]','1',document.forms[0].elements['relation[0]'].value)><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"table_fille[0]\" value=\"$table_fille[0]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','table_fille[0]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "Num colonne de la table distante à afficher dans la popup et servant de tri<br><input name=num_colonne2[0] value='$num_colonne2[0]' type=text><br><input name=num_colonne2_fk[0] value='$num_colonne2_fk[0]' type=text>\n";
echo "</td>\n";

if (!isset($_GET['simple'])){
    echo "<td>\n";
    echo "Colonne affich&eacute;e dans l'&eacute;tat sélectionn&eacute;<br>\n";
    $val_defaut='Tous';
    if (isset($etapesnan[0])&&!empty($etapesnan[0]))
            $val_defaut=$etapesnan[0];
    enum_etat($lesetapes,"etapesnan[0]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan2[0])&&!empty($etapesnan2[0]))
            $val_defaut=$etapesnan2[0];
    enum_etat_niveau($lesetapes,"etapesnan2[0]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan3[0])&&!empty($etapesnan3[0]))
            $val_defaut=$etapesnan3[0];
    enum_etat_niveau($lesetapes,"etapesnan3[0]",$val_defaut);
    echo "</td>\n";
}
echo "</tr>\n";

echo "<tr><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"relation[1]\" value=\"$relation[1]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','relation[1]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"association[1]\" value=\"$association[1]\">\n";
echo "<a href=javascript:OuvrirPopupRelation('$database','association[1]','1',document.forms[0].elements['relation[1]'].value)><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"table_fille[1]\" value=\"$table_fille[1]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','table_fille[1]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "Num colonne de la table distante à afficher dans la popup et servant de tri<br><input name=num_colonne2[1] value='$num_colonne2[1]' type=text><br><input name=num_colonne2_fk[1] value='$num_colonne2_fk[1]' type=text>\n";
echo "</td>\n";
if (!isset($_GET['simple'])){
    echo "<td>\n";
    echo "Colonne affich&eacute;e dans l'&eacute;tat sélectionn&eacute;<br>\n";
    $val_defaut='Tous';
    if (isset($etapesnan[1])&&!empty($etapesnan[1]))
            $val_defaut=$etapesnan[1];
    enum_etat($lesetapes,"etapesnan[1]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan2[1])&&!empty($etapesnan2[1]))
            $val_defaut=$etapesnan2[1];
    enum_etat_niveau($lesetapes,"etapesnan2[1]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan3[1])&&!empty($etapesnan3[1]))
            $val_defaut=$etapesnan3[1];
    enum_etat_niveau($lesetapes,"etapesnan3[1]",$val_defaut);
    echo "</td>\n";
}
echo "</tr>\n";

echo "<tr><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"relation[2]\" value=\"$relation[2]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','relation[2]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"association[2]\" value=\"$association[2]\">\n";
echo "<a href=javascript:OuvrirPopupRelation('$database','association[2]','1',document.forms[0].elements['relation[2]'].value)><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"table_fille[2]\" value=\"$table_fille[2]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','table_fille[2]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "Num colonne de la table distante à afficher dans la popup et servant de tri<br><input name=num_colonne2[2] value='$num_colonne2[2]' type=text><br><input name=num_colonne2_fk[2] value='$num_colonne2_fk[2]' type=text>\n";
echo "</td>\n";
if (!isset($_GET['simple'])){
    echo "<td>\n";
    echo "Colonne affich&eacute;e dans l'&eacute;tat sélectionn&eacute;<br>\n";
    $val_defaut='Tous';
    if (isset($etapesnan[2])&&!empty($etapesnan[2]))
            $val_defaut=$etapesnan[2];
    enum_etat($lesetapes,"etapesnan[2]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan2[2])&&!empty($etapesnan2[2]))
            $val_defaut=$etapesnan2[2];
    enum_etat_niveau($lesetapes,"etapesnan2[2]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan3[2])&&!empty($etapesnan3[2]))
            $val_defaut=$etapesnan3[2];
    enum_etat_niveau($lesetapes,"etapesnan3[2]",$val_defaut);
    echo "</td>\n";
}
echo "</tr>\n";


echo "<tr><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"relation[3]\" value=\"$relation[3]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','relation[3]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"association[3]\" value=\"$association[3]\">\n";
echo "<a href=javascript:OuvrirPopupRelation('$database','association[3]','1',document.forms[0].elements['relation[3]'].value)><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"table_fille[3]\" value=\"$table_fille[3]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','table_fille[3]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "Num colonne de la table distante à afficher dans la popup et servant de tri<br><input name=num_colonne2[3] value='$num_colonne2[3]' type=text><br><input name=num_colonne2_fk[3] value='$num_colonne2_fk[3]' type=text>\n";
echo "</td>\n";
if (!isset($_GET['simple'])){
    echo "<td>\n";
    echo "Colonne affich&eacute;e dans l'&eacute;tat sélectionn&eacute;<br>\n";
    $val_defaut='Tous';
    if (isset($etapesnan[3])&&!empty($etapesnan[3]))
            $val_defaut=$etapesnan[3];
    enum_etat($lesetapes,"etapesnan[3]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan2[3])&&!empty($etapesnan2[3]))
            $val_defaut=$etapesnan2[3];
    enum_etat_niveau($lesetapes,"etapesnan2[3]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan3[3])&&!empty($etapesnan3[3]))
            $val_defaut=$etapesnan3[3];
    enum_etat_niveau($lesetapes,"etapesnan3[3]",$val_defaut);
    echo "</td>\n";
}
echo "</tr>\n";


echo "<tr><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"relation[4]\" value=\"$relation[4]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','relation[4]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"association[4]\" value=\"$association[4]\">\n";
echo "<a href=javascript:OuvrirPopupRelation('$database','association[4]','1',document.forms[0].elements['relation[4]'].value)><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "<input type=\"text\" size=\"40\" name=\"table_fille[4]\" value=\"$table_fille[4]\">\n";
echo "<a href=javascript:OuvrirPopupTable('$database','table_fille[4]','1')><img border=0 src=images/loupe.gif ALT=D&eacute;tails width=15 height=15></A>\n";
echo "</td><td>\n";
echo "Num colonne de la table distante à afficher dans la popup et servant de tri<br><input name=num_colonne2[4] value='$num_colonne2[4]' type=text><br><input name=num_colonne2_fk[4] value='$num_colonne2_fk[4]' type=text>\n";
echo "</td>\n";
if (!isset($_GET['simple'])){
    echo "<td>\n";
    echo "Colonne affich&eacute;e dans l'&eacute;tat sélectionn&eacute;<br>\n";
    $val_defaut='Tous';
    if (isset($etapesnan[4])&&!empty($etapesnan[4]))
            $val_defaut=$etapesnan[4];
    enum_etat($lesetapes,"etapesnan[4]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan2[4])&&!empty($etapesnan2[4]))
            $val_defaut=$etapesnan2[4];
    enum_etat_niveau($lesetapes,"etapesnan2[4]",$val_defaut);
    $val_defaut='';
    if (isset($etapesnan3[4])&&!empty($etapesnan3[4]))
            $val_defaut=$etapesnan3[4];
    enum_etat_niveau($lesetapes,"etapesnan3[4]",$val_defaut);
    echo "</td>\n";
}
echo "</tr>\n";

echo "<tr><td colspan=3>Mode affichage popup dans cette page : 0 ou 2<br><input name=mode_affichage_popup value='$mode_affichage_popup' type=text><td><tr>\n";

if ($rech_nan==1)
	echo "<tr><td colspan=3><input type=checkbox checked name=rech_nan value=1>Ajouter Les tables comme crit&egrave;res de recherche<br />\n";
else
	echo "<tr><td colspan=3><input type=checkbox name=rech_nan value=1>Ajouter Les tables comme crit&egrave;res de recherche<br />\n";

if ($navigation2==1)
	echo "<input type=checkbox name=navigation2 checked value=1>Mettre des liens vers les tables dans le r&eacute;sultat de la recherche</td></tr>\n";
else
	echo "<input type=checkbox name=navigation2 value=1>Mettre des liens vers les tables dans le r&eacute;sultat de la recherche</td></tr>\n";


?>
</table>
<br /><br /><br />
<p><b><u>4) Choisir une couleur pricipale pour vos pages</u></b></p>
<?php
if (empty($couleur_page)) $couleur_page='#377BA8';
?>
Indiquer votre couleur (ex : navy, green, orange, marron...) : <input type=text value="<?php echo $couleur_page?>" name=couleur_page>&nbsp;<a href=javascript:OuvrirFen('palette.php?retour=couleur_page',600,420)>Utiliser la palette</A>
<br /><br />

<u>5) Droits d'affichage (boutons depuis le moteur de recherche) :</u>
<br />
<input type="checkbox" <?php if (mb_strstr($mod, 'V')) echo 'checked'?> name="mod_v" value=V>Voir une fiche detail<br />
<input type="checkbox" <?php if (mb_strstr($mod, 'M')) echo 'checked'?> name="mod_m" value=M>Mise a jour<br />
<input type="checkbox" <?php if (mb_strstr($mod, 'I')) echo 'checked'?> name="mod_i" value=I>Insertion<br />
<input type="checkbox" <?php if (mb_strstr($mod, 'D')) echo 'checked'?> name="mod_d" value=D>D&eacute;truire, suppression<br />
<?php
if (!isset($_GET['simple'])){
?>
<input type="checkbox" <?php if (mb_strstr($mod, 'W')) echo 'checked'?> name="mod_w" value=W>Workflow, suivi du formulaire<br />
<?php
}
?>
<br /><br />
<u>6) Taille du tableau des colonnes affichables :</u>
<input type="text" name="nb_col_affichable" value="<?php echo $nb_col_affichable?>">

<br /> <br />

<p><b><u>7) G&eacute;n&eacute;rer les fichiers de mises &agrave; jour de la table</u></b></p>
<input type="checkbox" checked name="moteur" value="1">G&eacute;n&eacute;rer le moteur de recherche<br />
<input type="checkbox" checked name="insert" value="1">G&eacute;n&eacute;rer le formulaire insertion<br />
<input type="checkbox" checked name="del" value="1">G&eacute;n&eacute;rer le formulaire de suppression<br />
<input type="checkbox" checked name="edit" value="1">G&eacute;n&eacute;rer le formulaire de mise a jour<br />
<input type="checkbox" checked name="view" value="1">G&eacute;n&eacute;rer la fiche de vue depuis le moteur<br />
<?php
if (!isset($_GET['simple'])){
?>
<input type="checkbox" checked name="voir" value="1">G&eacute;n&eacute;rer la fiche de vue depuis le workflow<br />
<input type="checkbox" checked name="tableau_gen" value="1">G&eacute;n&eacute;rer les tableaux de suivi<br />
<input type="checkbox" checked name="workflow_ins" value="1">G&eacute;n&eacute;rer le formulaire workflow insertion<br />
<input type="checkbox" checked name="workflow_edit" value="1">G&eacute;n&eacute;rer le formulaire workflow edition<br />
<?php
}
?>
<input type="checkbox" checked name="param" value="1">G&eacute;n&eacute;rer le fichier parametres
<br />
<input type="checkbox" checked name="excel" value="1">G&eacute;n&eacute;rer le script d'export vers Excel<br />



<center><input type=button value=G&eacute;n&eacute;rer onClick=valider()></center>
</p>
</form>
</body>
</html>
