<html>
<head>
<?php
include_once("encodage.inc.php");
?>
</head>
<body>
<?php
include_once("functions.inc.php");
include_once("var.inc.php");
include_once($table."_config.php");

$filename = $table."_edit.".$extension;
print "Ecriture du fichier $filename<br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");

fwrite_encode($fp,'<meta http-equiv="X-UA-Compatible" content="IE=8" />'."\n");

fwrite_encode($fp, "<?php\n" );
fwrite_encode($fp,'include("session.php");'."\n");
fwrite_encode($fp,'include("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode($fp,'@include("'.$table.'_diag.'.$extension.'");'."\n");
fwrite_encode($fp,"//Inclusion de la page entete qui inclue les variables et les fonctions.\n");
fwrite_encode($fp,'include("entete.php");'."\n");
fwrite_encode($fp,'$connexion=connexion($bdd);'."\n");

fwrite_encode($fp,'if (!empty($mode_affichage_popup)) $affiche_popup=$mode_affichage_popup;'."\n");

fwrite_encode($fp, "?>\n" );
fwrite_encode($fp,'<script type="text/javascript">'."\n");
fwrite_encode($fp,$js_fonction_maj."\n" );
fwrite_encode($fp,'</script>'."\n");
fwrite_encode($fp, '<?php if (!isset($suite)){'."\n" );
fwrite_encode($fp, 'echo "<h2>$titreEdit $titre_formulaire I-$id </h2>";'."\n" );
fwrite_encode($fp, '?>'."\n" );
fwrite_encode($fp,"<!-- Formulaire de mise a jour des donnees-->\n" );
fwrite_encode($fp,"<form name=formulaire action=$filename enctype=\"multipart/form-data\" method=\"post\">\n" );
fwrite_encode($fp,$insertion_deb_maj."\n" );

$connexion=connexion($database);

$req="select * from $table";
$result = execute_sql($req);
$fields = mysqli_num_fields($result);
fwrite_encode($fp,"<!-- Fonction de verification de saisie des donnees -->\n" );
fwrite_encode($fp,'<script type="text/javascript">'."\n");
fwrite_encode($fp,'function valider(){'."\n");
$flags = db_field_direct_flags($result,0);

if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}
while ($i < $fields) {
	$type  = db_field_direct_type($result, $i);
	$flags = db_field_direct_flags($result, $i);
	$nom_de_colonne =  db_field_direct_name($result, $i);

	if (isset($maj_cols)&&in_array($i,$maj_cols)){

		//Gestion de la colonne etat en cas de workflow
		//Cette colone est obligatoire si elle existe
		if ($nom_de_colonne=='etat'){
			// recup du numero de colonne de etat
			$i_etat=$i;
			$i++;
			fwrite_encode($fp,'   if (getCheckedRadioValue("etat")==null){'."\n");
			fwrite_encode($fp,'       alert("Indiquer un Etat de validation.");'."\n");
			fwrite_encode($fp,'       document.forms[0].elements["etat"].focus();'."\n");
			fwrite_encode($fp,'       return;'."\n");
			fwrite_encode($fp,'     }'."\n");
			continue;
		}

		if (db_type($type,$flags)=='int'){
			fwrite_encode($fp,'      tab=document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value.split("|");'."\n");
			if (mb_stristr($flags,'not_null'))
				fwrite_encode($fp,'      if ((tab[0]=="")||(isNotInteger(tab[0]))){'."\n");
			else
				fwrite_encode($fp,'      if (isNotInteger(tab[0])){'."\n");
			fwrite_encode($fp,'         alert("Voir la saisie de la zone " + document.forms[0].elements[\''.$tab_colonnes[$i].'\'].name);'."\n");
			fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
			fwrite_encode($fp,'         return;'."\n");
			fwrite_encode($fp,'      }'."\n");
		}
		elseif (db_type($type,$flags)=='real'){
			fwrite_encode($fp,'      tab=document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value.split("|");'."\n");
			if (mb_stristr($flags,'not_null'))
				fwrite_encode($fp,'      if ((tab[0]=="")||(isNaN(tab[0]))){'."\n");
			else
				fwrite_encode($fp,'      if (isNaN(tab[0])){'."\n");
			fwrite_encode($fp,'         alert("Voir la saisie de la zone " + document.forms[0].elements[\''.$tab_colonnes[$i].'\'].name);'."\n");
			fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
			fwrite_encode($fp,'         return;'."\n");
			fwrite_encode($fp,'      }'."\n");
		}
		else if (db_type($type,$flags)=='enum'){
			if (mb_stristr($flags,'not_null')){

				fwrite_encode($fp,'      tmp=0;'."\n");
				fwrite_encode($fp,'      for (var i=0; i<document.forms[0].elements[\''.$tab_colonnes[$i].'\'].length;i++) {'."\n");
				fwrite_encode($fp,'         if (document.forms[0].elements[\''.$tab_colonnes[$i].'\'][i].checked) {'."\n");
				fwrite_encode($fp,'            tmp=1;'."\n");
				fwrite_encode($fp,'         }'."\n");
				fwrite_encode($fp,'      }'."\n");
				fwrite_encode($fp,'      if (tmp==0){'."\n");
				fwrite_encode($fp,'         alert("Voir la saisie de la zone '.$tab_colonnes[$i].'");'."\n");
				fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'][0].focus();'."\n");
				fwrite_encode($fp,'         return;'."\n");
				fwrite_encode($fp,'      }'."\n");
			}
		}
		else if (db_type($type,$flags)=='set'){
			if (mb_stristr($flags,'not_null')){

				fwrite_encode($fp,'      tmp=0;'."\n");
				fwrite_encode($fp,'      for (var i=0; i<document.forms[0].elements[\''.$tab_colonnes[$i].'[]\'].length;i++) {'."\n");
				fwrite_encode($fp,'         if (document.forms[0].elements[\''.$tab_colonnes[$i].'[]\'][i].checked) {'."\n");
				fwrite_encode($fp,'            tmp=1;'."\n");
				fwrite_encode($fp,'         }'."\n");
				fwrite_encode($fp,'      }'."\n");


				fwrite_encode($fp,'      if (tmp==0){'."\n");
				fwrite_encode($fp,'         alert("Voir la saisie de la zone '.$tab_colonnes[$i].'");'."\n");
				fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'][0].focus();'."\n");
				fwrite_encode($fp,'         return;'."\n");
				fwrite_encode($fp,'      }'."\n");
			}
		}
		else if (db_type($type,$flags)=='date'){
			if (mb_stristr($flags,'not_null'))
				fwrite_encode($fp,'      if ((document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value=="")||(CheckDate(document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value)==0)){'."\n");
			else
				fwrite_encode($fp,'      if (CheckDate(document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value)==0){'."\n");
			fwrite_encode($fp,'         alert("Voir la saisie de la zone '.$tab_colonnes[$i].'");'."\n");
			fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
			fwrite_encode($fp,'         return;'."\n");
			fwrite_encode($fp,'      }'."\n");
		}
		else if (isset($photos)&&in_array($i,$photos)){
			// ne rien faire
		}
		else if (isset($fichiers)&&in_array($i,$fichiers)){
			// ne rien faire
		}
		else  if (mb_stristr($flags,'not_null')){
			fwrite_encode($fp,'      if (document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value==""){'."\n");
			fwrite_encode($fp,'         alert("Renseigner la zone " + document.forms[0].elements[\''.$tab_colonnes[$i].'\'].name);'."\n");
			fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
			fwrite_encode($fp,'         return;'."\n");
			fwrite_encode($fp,'      }'."\n");
		}
		//Si format de type heure
		if (mb_stristr($nom_de_colonne,'heure')){
			fwrite_encode($fp,'      if (validation_heure(document.forms[0].elements[\''.$tab_colonnes[$i].'\'])){'."\n");
			fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
			fwrite_encode($fp,'         return;'."\n");
			fwrite_encode($fp,'      }'."\n");
		}
	}
	$i++;
}
fwrite_encode($fp,$js_deb_maj."\n" );

fwrite_encode($fp,'   document.forms[0].action="<?php echo $PHP_SELF;?>?suite=1"'.";\n");
fwrite_encode($fp,'   if (confirm("Voulez-vous confirmer votre saisie ?")){'."\n");

//Ajout de la selection des options de liste dans les relations n a n avant la validation du formulaire
for ($w=0;$w<5;$w++){
   if (!empty($table_fille[$w])){
        list($nom_table_relation,$col_relation_depart)=explode(".",$association[$w]);
        fwrite_encode($fp,"<?php\n" );
        fwrite_encode($fp,'if ($affiche_popup==0){'."\n");
        fwrite_encode($fp,"echo 'soumettre_1liste(document.forms[0].elements[\'$col_relation_depart"."[]\']);';\n" );
        fwrite_encode($fp,"}?>\n" );
    }
}

fwrite_encode($fp,'      document.forms[0].submit();'."\n");
fwrite_encode($fp,'   }'."\n");
fwrite_encode($fp,'}'."\n");
fwrite_encode($fp,'</script> '."\n");


// Gestion de FCK
if (isset($editeur)){
	fwrite_encode($fp,'<script type="text/javascript" src="./fckeditor.js"></script>'."\n");
	fwrite_encode($fp,'<script type="text/javascript">'."\n");

	fwrite_encode($fp,'window.onload = function()'."\n");
	fwrite_encode($fp,'{'."\n");
	fwrite_encode($fp,'	var sBasePath = document.location.href.substring(0,document.location.href.lastIndexOf("'.$filename.'"));'."\n");

	for ($l=0;$l<sizeof($editeur);$l++){
		fwrite_encode($fp,'	var oFCKeditor'.$l.' = new FCKeditor("'.$tab_colonnes[$editeur[$l]].'","100%","'.$hauteur_editeur[$editeur[$l]].'");'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.BasePath	= sBasePath ;'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.ToolbarSet	= "Basic" ;'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.ReplaceTextarea() ;'."\n");
	}
	fwrite_encode($fp,'}'."\n");
	fwrite_encode($fp,'</script>'."\n");
}




fwrite_encode($fp,'<div class="tableform">'."\n");
fwrite_encode($fp,'<?php '."\n");

$flags = db_field_direct_flags($result,0);
$maclause="";
$f=0;
if (!mb_stristr($flags,'auto')){
	// gestion du pasage des parametres pour la maj et la vue pour les relations a 3 pattes
	while ($f < $fields) {
		$type  = db_field_direct_type($result, $f);
		if (db_type($type,$flags)=='int'){
			$macolonne=db_field_direct_name($result, $f);
			if (empty($maclause))
				$maclause=$macolonne.'=$'.$macolonne;
			else
				$maclause=$maclause.' and '.$macolonne.'=$'.$macolonne;
		}
		$f++;
	}
	fwrite_encode($fp,'$req='."\"select * from $table where $maclause\";\n" );
}
else{
	$maclause="$nom_id=".'$id';
	fwrite_encode($fp,'$req='."\"select * from $table where $maclause\";\n" );
}


fwrite_encode($fp,'$ret=execute_sql($req);'."\n" );
fwrite_encode($fp,'$row = mysqli_fetch_row($ret);  '."\n");
fwrite_encode($fp,'?>'."\n");
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}
$num_gen=0; //numero de la zone de saisie pour l'editeur html
while ($i < $fields) {
	if (isset($maj_cols)&&in_array($i,$maj_cols)){
		$type  = db_field_direct_type($result, $i);
		$name  = db_field_direct_name($result, $i);
		$len   = db_field_direct_len($result, $i);
		$flags = db_field_direct_flags($result, $i);
		// Gestion des labels
		if ($name=='etat'){
			// ne rien faire
			$i++;
			continue;
		}
		fwrite_encode($fp,"<div $div_attributs_edit[$i] class=trform>"."\n" );
		if (mb_stristr($flags,'not_null')){
			if (isset($label)&&(!empty($label)))
				fwrite_encode($fp,'<div class=tdform><?php echo $label['.$i.']?> <font color=red>(*)</font></div>'."\n" );
			else
				fwrite_encode($fp,"<div class=tdform>".ucfirst(mb_strtolower($nom))." <font color=red>(*)</font></div>\n" );
		}
		else{
			if (isset($label)&&(!empty($label)))
				fwrite_encode($fp,'<div class=tdform><?php echo $label['.$i.']?></div>'."\n" );
			else
				fwrite_encode($fp,"<div class=tdform>".ucfirst(mb_strtolower($nom))."</div>\n" );
		}

		$fk="";
		if (!empty($tables[$i])){
			$nom_fk=explode(".",$tables[$i]);
			$fk=$nom_fk[0];
		}
		fwrite_encode($fp,'<?php echo "<div class=\"tdform tdfinform\">";?>'."\n");

		if (empty($fk)){		
			if (isset($photos)&&in_array($i,$photos)){
				//MdB gestion de photos 02/07/03
				fwrite_encode($fp,'<?php if (!empty($row['.$i.'])){'."\n");
				fwrite_encode($fp,"   echo \"<input $attributs_edit[$i] style=background-color:$couleur_protege; onFocus=blur() type=hidden ".'value=\"$row['.$i.']\"'." name=$name".'_photo'.">\";\n");
				fwrite_encode($fp,"   echo \"<input style=background-color:$couleur_protege; onFocus=blur()  type=hidden ".'value=\"$row['.$i.']\"'." name=$name".'_photo_sav'.">\";\n");

				if (!mb_stristr($flags,'not_null')){
					fwrite_encode($fp,'   echo "&nbsp;<a href=\"javascript:del_image(document.forms[0].elements[\''.$name.'_photo\'],\''.$name.'\')\"><img src=./images/del.gif></a>";'."\n");
				}

				fwrite_encode($fp,"}\n");
				fwrite_encode($fp,"else{\n");
				fwrite_encode($fp,"   echo \"<input style=background-color:$couleur_protege; onFocus=blur() type=hidden ".'value=\"$row['.$i.']\"'." name=$name".'_photo'.">\";\n");
				fwrite_encode($fp,"}\n");
                                fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$name.'\'."-".$row['.$i.'];'."\n");
				fwrite_encode($fp,'   echo "&nbsp;<a target=_blank href=\"$fichier\"><img src=\"$fichier\" id=\"'.$name.'\" class=\"output_image\"/></a><br />";'."\n");
				fwrite_encode($fp,"echo \"<input $attributs_edit[$i] type=file ".'value=\"$row['.$i.']\"'." name=$name onchange='preview_image(event,this)'>\";?>\n");

				
			}
			elseif (isset($fichiers)&&in_array($i,$fichiers)){
				//MdB gestion des fichiers 13/10/12
				fwrite_encode($fp,'<?php if (!empty($row['.$i.'])){'."\n");
				fwrite_encode($fp,"   echo \"<input $attributs_edit[$i] style=background-color:$couleur_protege; onFocus=blur() type=text ".'value=\"$row['.$i.']\"'." name=$name".'_fichier'.">\";\n");
				fwrite_encode($fp,"   echo \"<input style=background-color:$couleur_protege; onFocus=blur()  type=hidden ".'value=\"$row['.$i.']\"'." name=$name".'_fichier_sav'.">\";\n");
				if (!mb_stristr($flags,'not_null')){
					fwrite_encode($fp,'   echo "&nbsp;<a href=\"javascript:del_image(document.forms[0].elements[\''.$name.'_fichier\'])\"><img src=./images/del.gif></a>";'."\n");
				}

				fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$name.'\'."-".$row['.$i.'];'."\n");
				fwrite_encode($fp,'   echo "&nbsp;<a target=_blank href=\"$fichier\">Charger</a><br />";'."\n");

				fwrite_encode($fp,"}\n");
				fwrite_encode($fp,"else{\n");
				fwrite_encode($fp,"   echo \"<input style=background-color:$couleur_protege; onFocus=blur() type=hidden ".'value=\"$row['.$i.']\"'." name=$name".'_image'.">\";\n");
				fwrite_encode($fp,"}\n");
				fwrite_encode($fp,"echo \"<input $attributs_edit[$i] type=file ".'value=\"$row['.$i.']\"'." name=$name>\";?>\n");

			}
			elseif (db_type($type,$flags)=='date'){
				fwrite_encode($fp,"<input $attributs_edit[$i] class='w16em dateformat-d-sl-m-sl-Y' id='$name' type=text size=12 maxlength=$len ".'value="<?php echo $row['.$i.']?>"'." name=$name>\n");
				fwrite_encode($fp,"\n".'<script type="text/javascript">'."\n");
				if (!empty($defauts[$i])){
					fwrite_encode($fp,"\n".'<?php'."\n");
					fwrite_encode($fp,'if (empty($row['.$i."])) echo \"document.forms[0].$name.value=".$defauts[$i].";\";\n");
//					fwrite_encode($fp,"if ((document.forms[0].$name.value=='0000-00-00')||(document.forms[0].$name.value=='')) document.forms[0].$name.value=".$defauts[$i].";\n");
					fwrite_encode($fp,"\n".'?>'."\n");
				}
				else{
					fwrite_encode($fp,"if ((document.forms[0].$name.value=='0000-00-00')||(document.forms[0].$name.value=='')) document.forms[0].$name.value=date_jour();\n");
				}
				fwrite_encode($fp,"</script>\n");
			}
			elseif (mb_stristr($flags, 'enum')){
				fwrite_encode($fp,"<?php\n");
				fwrite_encode($fp,'$attribut_html="'.$attributs_edit[$i]."\";\n");
				fwrite_encode($fp,"enum_option('$name','$table',\"".'$row['.$i."]\");\n");
				fwrite_encode($fp,'$attribut_html="";'."\n");
				fwrite_encode($fp,"?>\n");
			}
			elseif (mb_stristr($flags, 'set')){
				fwrite_encode($fp,"<?php\n");
				fwrite_encode($fp,'$attribut_html="'.$attributs_edit[$i]."\";\n");
				fwrite_encode($fp,"set_checkbox('$name','$table',".'explode(",",$row['.$i.']));'."\n");
				fwrite_encode($fp,'$attribut_html="";'."\n");
				fwrite_encode($fp,"?>\n");
			}
			elseif ($len<=60){
				fwrite_encode($fp,"<input $attributs_edit[$i] type=text  size=$len maxlength=$len value=\"<?php echo ret_base(".'$row'."[$i])?>\" name=$name>\n");
			}
			elseif (($len > 60)&&($len<=100)){
				fwrite_encode($fp,"<input $attributs_edit[$i] type=text  size=70 maxlength=$len value=\"<?php echo ret_base(".'$row'."[$i])?>\" name=$name>\n");
			}
			elseif (($len > 100)&&($len<=255)){
				fwrite_encode($fp,"<textarea $attributs_edit[$i] name=$name rows=3 cols=60><?php echo ret_base(".'$row'."[$i])?></textarea>\n");
			}
			else{
				fwrite_encode($fp,"<textarea $attributs_edit[$i] name=$name rows=5 cols=60><?php echo ret_base(".'$row'."[$i])?></textarea>\n");
			}
		}
		else {
			//gestion de l'affichage des popups
			$req="select * from $fk";
			$result1 = execute_sql($req);
			$nom_col1= db_field_direct_name($result1,0);
			$nom_col2= db_field_direct_name($result1,1);
			$nom_cols1= db_field_direct_name($result1,$cols1[$i]);
			$nom_cols2= db_field_direct_name($result1,$cols2[$i]);



			fwrite_encode($fp,"<?php\n" );
			fwrite_encode($fp,'$fk_tab=explode(".",$tables['.$i.']);'."\n" );
			fwrite_encode($fp,'$fk_table=$fk_tab[0];'."\n" );
			fwrite_encode($fp,'$attribut_html="'.$attributs_edit[$i]."\";\n");

			fwrite_encode($fp,'if ($affiche_popup==0)'."\n");
			fwrite_encode($fp, "   lister_table('$name',".'$fk_table,$cols1['.$i.'],$cols2['.$i.'],$row['.$i.'],1,stripslashes($req_fk['.$i."]));\n" );
			fwrite_encode($fp,'if ($affiche_popup==2){'."\n");

			fwrite_encode($fp,'    echo "<input style=\'background-color:$couleur_protege;\' type=text onFocus=blur() size=30 value=\"".lister_id_libelle(\''.$nom_col1.'\',\''.$fk.'\','.$cols1[$i].','.$cols2[$i].',"$row['.$i.']")."\" name=\"'.$name.'\">";'."\n");
			fwrite_encode($fp,'     echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$fk','$nom_cols1','$nom_cols2','1','','$name','$table'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
			if (!mb_stristr($flags,"not_null"))
				fwrite_encode($fp,'     echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$name.'\'])><img border=0 src=images/gomme.gif alt=Effacer width=15 height=15></a>";'."\n");
			fwrite_encode($fp,"}\n" );
			fwrite_encode($fp,"?>\n" );
		}
		fwrite_encode($fp,'</div></div>'."\n");
		fwrite_encode($fp,'<?php $attribut_html="";?>'."\n");

	}
	$i++;
}


$i=0;
$w=0;
for ($w=0;$w<5;$w++){
    if (!empty($table_fille[$w])){
        list($nom_table_relation,$col_relation_depart)=explode(".",$association[$w]);
        list($val,$col)=explode(".",$table_fille[$w]);
        list($val_tmp,$col_depart)=explode(".",$relation[$w]);
        $res = execute_sql("select * from $val");
        $nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
        
        $tab_liste_num_colonne2=explode(',',$num_colonne2[$w]);
        $tab_liste_num_colonne2_fk=explode(',',$num_colonne2_fk[$w]);

        $nom_col2= db_field_direct_name($res,$tab_liste_num_colonne2[0]);

        
        if (!empty($tab_liste_num_colonne2[1])){
            $nom_autre_colonne= db_field_direct_name($res,$tab_liste_num_colonne2[1]);
            fwrite_encode($fp,"<?php\n" );
            fwrite_encode($fp,'$num_autre_colonne="'.$num_colonne2[$z]."\";\n");
            fwrite_encode($fp,"?>\n" );
        }
        else{
            $nom_autre_colonne=$nom_col2;
        }					
        fwrite_encode($fp,'<div class=trform>'."\n" );
        fwrite_encode($fp, '<div class=tdform><?php echo ucfirst(mb_strtolower($relation_2pattes['.$i.']));?>'."</div>\n");
        fwrite_encode($fp,'<?php if (!isset($'.$nom_nan_id.')) $'.$nom_nan_id.'="";?>'."\n" );
        fwrite_encode($fp,'<div class="tdform tdfinform">'."\n");
        //gestion de l'affichage des popup avec checkbox
        fwrite_encode($fp,"<?php\n" );
        fwrite_encode($fp,'if ($affiche_popup==0){'."\n");
        fwrite_encode($fp,"\$reqini=\"select * from $val,$nom_table_relation where $val.$col=$nom_table_relation.$col_relation_depart and $nom_table_relation.$col_depart=\$id\";\n" );
        fwrite_encode($fp,"\$resultat_sql_ini=execute_sql(\$reqini);\n" );

        fwrite_encode($fp,"while(\$row_ini=mysqli_fetch_row(\$resultat_sql_ini)){\n" );
        fwrite_encode($fp,"   \$tab_ini[] = \$row_ini[0];\n" );
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,"\$list_ini = @implode(',',\$tab_ini);\n" );

        fwrite_encode($fp,"if (empty(\$list_ini)) \$list_ini = 0;\n");

        $num_tri=$num_colonne2[$w]+1;
        fwrite_encode($fp,"\$reql1=\"select * from $val where $col not in (\$list_ini) \$$col"."_clause order by $num_tri\";\n" );
        fwrite_encode($fp,"\$resultat_sql_l1=execute_sql(\$reql1);\n" );
        fwrite_encode($fp,"echo '<table border=\"0\"><tr><th>Liste des options</th><th></th><th>Options choisies</th></tr>';\n" );
        fwrite_encode($fp,"echo '<tr><td style=\"text-align:center\"><select name=l1_$col_relation_depart size=\"10\" multiple>';\n" );
        
        fwrite_encode($fp,"while(\$row_l1=mysqli_fetch_row(\$resultat_sql_l1)){\n" );
        fwrite_encode($fp,"   echo \"<option value='\$row_l1[0]'>\"" );
        for ($u=0;$u<count($tab_liste_num_colonne2);$u++){

            if (isset($tab_liste_num_colonne2_fk[$u])&&!empty($tab_liste_num_colonne2_fk[$u])){
                
                list($table_fk,$col_fk)=explode(".",$tab_liste_num_colonne2_fk[$u]);
                $req_fk="select * from $table_fk where $col_fk=\$row_l1[$tab_liste_num_colonne2[$u]]";
                fwrite_encode($fp,".tronquer(lister_col_num_lib(\"$req_fk\",1)).' '" );
                //num_col_depuis_nom($tab_colonnes,$nom_colonne)            
            }
            else {
                fwrite_encode($fp,".tronquer(\$row_l1[$tab_liste_num_colonne2[$u]]).' '" );
            }
            //fwrite_encode($fp,".tronquer(\$row_l1[$tab_liste_num_colonne2[$u]]).' '" );
            
        }
        fwrite_encode($fp,";\n" );                                        
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,"echo '</select></td>';\n" );
        fwrite_encode($fp,"echo '<td style=\"text-align:center\">';\n" );
        fwrite_encode($fp,"echo '<input type=\"button\" value=\">>\" onclick=\"soumettre_1liste(document.forms[0].l1_$col_relation_depart);deplacer(document.forms[0].l1_$col_relation_depart,document.forms[0].elements[\'$col_relation_depart"."[]\'])\"><br/><br/>';\n" );
        fwrite_encode($fp,"echo '<input type=\"button\" value=\">\" onclick=deplacer(document.forms[0].l1_$col_relation_depart,document.forms[0].elements[\'$col_relation_depart"."[]\'])><br/><br/>';\n" );
        fwrite_encode($fp,"echo '<input type=\"button\" value=\"<\" onclick=\"deplacer(document.forms[0].elements[\'$col_relation_depart"."[]\'],document.forms[0].l1_$col_relation_depart)\"><br/><br/>';\n" );
        fwrite_encode($fp,"echo '<input type=\"button\" value=\"<<\" onclick=\"soumettre_1liste(document.forms[0].elements[\'$col_relation_depart"."[]\']);deplacer(document.forms[0].elements[\'$col_relation_depart"."[]\'],document.forms[0].l1_$col_relation_depart)\"><br/>';\n" );
        fwrite_encode($fp,"echo '<td style=\"text-align:center\"><select name=$col_relation_depart"."[] size=\"10\" multiple>';\n" );
        fwrite_encode($fp,"\$reql2=\"select * from $val,$nom_table_relation where $val.$col=$nom_table_relation.$col_relation_depart and $nom_table_relation.$col_depart=\$id order by $num_tri\";\n" );
        fwrite_encode($fp,"\$resultat_sql_l2=execute_sql(\$reql2);\n" );
        
        fwrite_encode($fp,"while(\$row_l2=mysqli_fetch_row(\$resultat_sql_l2)){\n" );
        fwrite_encode($fp,"   echo \"<option value='\$row_l2[0]'>\"" );
        for ($u=0;$u<count($tab_liste_num_colonne2);$u++){
            if (isset($tab_liste_num_colonne2_fk[$u])&&!empty($tab_liste_num_colonne2_fk[$u])){
                
                list($table_fk,$col_fk)=explode(".",$tab_liste_num_colonne2_fk[$u]);
                $req_fk="select * from $table_fk where $col_fk=\$row_l2[$tab_liste_num_colonne2[$u]]";
                fwrite_encode($fp,".tronquer(lister_col_num_lib(\"$req_fk\",1)).' '" );
                //num_col_depuis_nom($tab_colonnes,$nom_colonne)            
            }
            else {
                fwrite_encode($fp,".tronquer(\$row_l2[$tab_liste_num_colonne2[$u]]).' '" );
            }        
        
        
            //fwrite_encode($fp,".tronquer(\$row_l2[$tab_liste_num_colonne2[$u]]).' '" );
        }
        fwrite_encode($fp,";\n" );                                        
        fwrite_encode($fp,"}\n" );					        
        fwrite_encode($fp,"echo '</select></td></tr></table>';\n" );
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
        fwrite_encode($fp,'   echo "<textarea style=\'background-color:$couleur_protege;\' rows=4 cols=40 name='.$col.'[] onClick=blur() onFocus=blur()>";'."\n" );
        fwrite_encode($fp,"   echo valeurs_nan(\$id,'$col_depart','$col_relation_depart','$col','$col','$nom_col2','$nom_table_relation','$val',$nom_autre_colonne);"."\n" );
        fwrite_encode($fp,'   echo "</textarea>";'."\n" );
        fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$val','$nom_nan_id','$nom_col2','2','','$nom_nan_id','$table','$nom_autre_colonne'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
        fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$nom_nan_id.'[]\'])><img border=0 src=images/poubelle.gif alt=Effacer width=15 height=15></a>";'."\n");
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,"?>\n" );
        fwrite_encode($fp,"</div></div>\n" );
        $i++;
    }
}


//insertion de la gestion de l etat de la fiche
if (isset($maj_cols)&&in_array($i_etat,$maj_cols)){
	/* Recuperation de l etat en cours */
	fwrite_encode($fp,'<?php '."\n");
	fwrite_encode($fp,'$etat_en_cours=$row['.$i_etat.'];'."\n");
	fwrite_encode($fp,'?>'."\n");
	// Affichage de tous les etats
	fwrite_encode($fp,'<div '.$div_attributs_edit[$i_etat].' class=trform>'."\n" );
	fwrite_encode($fp,'<div class="tdform">'."\n");
	fwrite_encode($fp,"Etat <font color=red>(*)</font>\n");
	fwrite_encode($fp,"</div>\n");
	fwrite_encode($fp,'<div class="tdform tdfinform tdfin'.$i_etat.'">'."\n");
	fwrite_encode($fp,'<?php enum_tous_etats("etat", $etat_en_cours,"'.$attributs_edit[$i_etat].'");?>'."\n");
	fwrite_encode($fp,"</div>\n");
	fwrite_encode($fp,"</div>\n");
}
//Fin du tableau
fwrite_encode($fp,'</div>'."\n" );

$req="select * from $table";
$result = execute_sql($req);
$nom_id  = db_field_direct_name($result, 0);

fwrite_encode($fp,"<input type=hidden name=id value=".'<?php echo $id?>'.">\n");
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto'))
	fwrite_encode($fp,"<input type=hidden name=$nom_id value=".'<?php echo $id?>'.">\n");

for ($i=0;$i<sizeof($relation);$i++){
	list($ma_table,$ma_colonne)=explode('.',$relation[$i]);
	if (($nom_id!=$ma_colonne)&&(!empty($ma_colonne))&&(!in_array($ma_colonne, $liste_des_colonnes_table)))
		fwrite_encode($fp,"<input type=hidden name=$ma_colonne value=".'<?php echo $id?>'.">\n");
}

$i=0;
if (!empty($CIF)&&($un_a_n_insertion=="1")){
	$CIF2=explode("\r\n",$CIF);
	if (!empty($CIF2[0])){
		for ($z=0;$z<count($CIF2);$z++){
			list($val,$col)=explode(".",$CIF2[$z]);
			fwrite_encode($fp,"<input type=hidden name=$col value=".'<?php echo $id?>'.">\n");
		}
	}
}

fwrite_encode($fp,'<br/><font color=red>(*) Zone obligatoire</font>'."\n" );

fwrite_encode($fp,'<center><input type=button onClick=document.location.replace("'.$table.'_rech.php") value="<?php echo $autre_rechercher;?>">&nbsp;<input type=button onClick=valider() value="<?php echo $updater;?>"></center>'."\n");
//affichage de l'objet cache contenant la where clause
fwrite_encode($fp,'<?php echo "<input type=hidden name=clause value=\"'.$maclause.'\">";?>'."\n" );
fwrite_encode($fp,"</form>\n");
fwrite_encode($fp,'<?php'."\n" );
/* Affichage du contenu des tables liees sous le formulaire de mise a jour
$i=0;
if (!empty($CIF)&&($un_a_n_maj=="1")){
	$CIF2=explode("\r\n",$CIF);
	if (!empty($CIF2[0])){
		for ($z=0;$z<count($CIF2);$z++){
			list($val,$col)=explode(".",$CIF2[$z]);
			$req="select * from $val";
			$result = execute_sql($req);
			$fields = mysqli_num_fields($result);
			$liste_col= $val.'.'.db_field_direct_name($result, 0);
			$f=1;
			while ($f < $fields) {
				$liste_col=$liste_col.','.$val.'.'.db_field_direct_name($result, $f);
				$f++;
			}
			fwrite_encode($fp,'$query= "select distinct '.$liste_col.' from '.$val.' where '.$val.'.'.$col.'=$id order by 1";'."\n");
			fwrite_encode($fp,'echo "<hr>";'.";\n");
			fwrite_encode($fp,'echo "<h2>$label_1an['.$i.']</h2>";'.";\n");
			fwrite_encode($fp,'$result = execute_select($query,2,0,"'.$id.'",\'\',0,0,1);'."\n");
			$i++;
		}
	}
}


$i=0;
$w=0;
$n=0;
for ($w=0;$w<5;$w++){
    if (!empty($table_fille[$w])){
        list($nom_table_relation_dep,$col_lien_dep)=explode(".",$relation[$w]);
        $req="select * from $nom_table_relation_dep";
        $result = execute_sql($req);
        $fields = mysqli_num_fields($result);
        $flags = db_field_direct_flags($result,0);
        fwrite_encode($fp,'if (is_array($pk_table))'."\n");
        fwrite_encode($fp,'   array_splice($pk_table,0)'.";\n");
        fwrite_encode($fp,'$pk_table["'.$col_lien_dep.'"]="'.$table.".".$nom_id."\";\n");
        list($tab_fille,$col_fille)=explode(".",$table_fille[$w]);
        list($nom_table_relation,$col_lien)=explode(".",$association[$w]);
        fwrite_encode($fp,'$pk_table["'.$col_lien.'"]="'.$tab_fille.".".$col_fille."\";\n");

        $f=0;
        if (!mb_stristr($flags,'auto')){
                fwrite_encode($fp,'if (is_array($colonnes_nan))'."\n");
                fwrite_encode($fp,'   array_splice($colonnes_nan,0)'.";\n");
                while ($f < $fields) {
                        $type  = db_field_direct_type($result, $f);
                        if (db_type($type,$flags)=='int'){
                                fwrite_encode($fp,'$colonnes_nan['.$f.']="'.db_field_direct_name($result, $f).'";'."\n");
                        }
                        $f++;
                }
        }

        $req="select * from $nom_table_relation_dep";
        $result = execute_sql($req);
        $fields = mysqli_num_fields($result);
        $liste_col= $nom_table_relation_dep.'.'.db_field_direct_name($result, 0);
        $f=0;
        while ($f < $fields) {
                        $liste_col=$liste_col.','.$nom_table_relation_dep.'.'.db_field_direct_name($result, $f);
                        $f++;
        }
        fwrite_encode($fp,'$query= "select distinct '.$liste_col.' from '.$nom_table_relation_dep.' where '.$nom_table_relation_dep.'.'.$col_lien_dep.'=$id order by 1";'."\n");
        fwrite_encode($fp,'echo "<hr>";'.";\n");
        fwrite_encode($fp,'echo "<h2>$ins_nan['.$n.']</h2>";'.";\n");
        fwrite_encode($fp,'$result = execute_select($query,2,0,"'.$nom_id.'",$pk_table,0,0,1);'."\n");
        $n++;
    }
}
*/

fwrite_encode($fp,'}'."\n" );
fwrite_encode($fp,'else{'."\n" );

$set="";
$req="select * from $table";
$result = execute_sql($req);
$fields = mysqli_num_fields($result);
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}

fwrite_encode($fp,'$req_update="update '.$table.' set ";'."\n");
fwrite_encode($fp,'$set="";'."\n");


while ($i < $fields) {
	if (isset($maj_cols)&&in_array($i,$maj_cols)){
		$name  = db_field_direct_name($result, $i);
		$type  = db_field_direct_type($result, $i);
		$flags = db_field_direct_flags($result, $i);
		if ((db_type($type,$flags)=='int')||(db_type($type,$flags)=='real')){
			fwrite_encode($fp,'   $critere_tab=explode("|",$'.$name.');'."\n");
			fwrite_encode($fp,'   $'.$name.'=$critere_tab[0];'."\n");
		}
		elseif (db_type($type,$flags)=='date'){
				fwrite_encode($fp,'   $'."$name=date_to_us(".'$'."$name);"."\n");
		}
		elseif (db_type($type,$flags)=='set'){
			fwrite_encode($fp,'   if (!empty($'.$name.'))'."\n");
			fwrite_encode($fp,'      $'.$name.'=implode(",",$'.$name.');'."\n");
		}

		if (isset($photos)&&in_array(($i),$photos)){
			fwrite_encode($fp,'   if (!empty($_FILES[\''.$name.'\'][\'name\'])) {'."\n");
			fwrite_encode($fp,'      //gestion des insertions des photos'."\n");
			fwrite_encode($fp,'      if (!empty($'.$name.'_photo)||($'.$name.'_photo==" ")) {'."\n");
			fwrite_encode($fp,'         $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$name.'\'."-".$'.$name.'_photo_sav;'."\n");
			fwrite_encode($fp,'         @unlink($rep."/".$nomDestination);'."\n");
			fwrite_encode($fp,'      }'."\n");
			fwrite_encode($fp,'      $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$name.'\'."-".nom_fichier($_FILES["'.$name.'"]["name"]);'."\n");
			fwrite_encode($fp,'      if (copy($_FILES[\''.$name.'\'][\'tmp_name\'], $rep."/".$nomDestination)) {'."\n");
			fwrite_encode($fp,'         //echo("<b>Fichier $nomDestination copie avec succes</b>");'."\n");
			fwrite_encode($fp,'         $'.$name.'_maj=nom_fichier($_FILES[\''.$name.'\'][\'name\']);'."\n");
			fwrite_encode($fp,'      } else {'."\n");
			fwrite_encode($fp,'         echo("<b>La copie du fichier $nomDestination a echoue...</b>");'."\n");
			fwrite_encode($fp,'      }'."\n");
			fwrite_encode($fp,'   }'."\n");
			fwrite_encode($fp,'   else{'."\n");
			fwrite_encode($fp,'      if ($'.$name.'_photo=="") {'."\n");
			fwrite_encode($fp,'         $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$name.'\'."-".$'.$name.'_photo_sav;'."\n");
			fwrite_encode($fp,'         @unlink($rep."/".$nomDestination);'."\n");
			fwrite_encode($fp,'         $'.$name.'_maj="";'."\n");
			fwrite_encode($fp,'      }'."\n");
			fwrite_encode($fp,'      if (!empty($'.$name.'_photo)&& ($'.$name.'_photo!=" ")) {'."\n");
			fwrite_encode($fp,'         $'.$name.'_maj=$'.$name.'_photo;'."\n");
			fwrite_encode($fp,'      }'."\n");
			fwrite_encode($fp,'   }'."\n");
			//fwrite_encode($fp,'   @unlink($_FILES["'.$name.'"]["tmp_name"]);'."\n");

			fwrite_encode($fp,'$set= $set."$virgule '.$name."='\$".$name.'_maj\'";'."\n");
			fwrite_encode($fp,'$virgule=\',\';'."\n");
		}
		elseif (isset($fichiers)&&in_array(($i),$fichiers)){

			fwrite_encode($fp,'   if (!empty($_FILES[\''.$name.'\'][\'name\'])) {'."\n");
			fwrite_encode($fp,'      //gestion des insertions des fichiers'."\n");
			fwrite_encode($fp,'      if (!empty($'.$name.'_fichier)||($'.$name.'_fichier==" ")) {'."\n");
			fwrite_encode($fp,'         $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$name.'\'."-".$'.$name.'_fichier_sav;'."\n");
			fwrite_encode($fp,'         @unlink($rep."/".$nomDestination);'."\n");
			fwrite_encode($fp,'      }'."\n");
			fwrite_encode($fp,'      $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$name.'\'."-".nom_fichier($_FILES["'.$name.'"]["name"]);'."\n");
			fwrite_encode($fp,'      if (copy($_FILES[\''.$name.'\'][\'tmp_name\'], $rep."/".$nomDestination)) {'."\n");
			fwrite_encode($fp,'         //echo("<b>Fichier $nomDestination copie avec succes</b>");'."\n");
			fwrite_encode($fp,'         $'.$name.'_maj=nom_fichier($_FILES[\''.$name.'\'][\'name\']);'."\n");
			fwrite_encode($fp,'      } else {'."\n");
			fwrite_encode($fp,'         echo("<b>La copie du fichier $nomDestination a echoue...</b>");'."\n");
			fwrite_encode($fp,'      }'."\n");
			fwrite_encode($fp,'   }'."\n");
			fwrite_encode($fp,'   else{'."\n");
			fwrite_encode($fp,'      if ($'.$name.'_fichier=="") {'."\n");
			fwrite_encode($fp,'         $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$name.'\'."-".$'.$name.'_fichier_sav;'."\n");
			fwrite_encode($fp,'         @unlink($rep."/".$nomDestination);'."\n");
			fwrite_encode($fp,'         $'.$name.'_maj="";'."\n");
			fwrite_encode($fp,'      }'."\n");
			fwrite_encode($fp,'      if (!empty($'.$name.'_fichier)&& ($'.$name.'_fichier!=" ")) {'."\n");
			fwrite_encode($fp,'         $'.$name.'_maj=$'.$name.'_fichier;'."\n");
			fwrite_encode($fp,'      }'."\n");
			fwrite_encode($fp,'   }'."\n");
			//fwrite_encode($fp,'   @unlink($_FILES["'.$name.'"]["tmp_name"]);'."\n");

			fwrite_encode($fp,'$set= $set."$virgule '.$name."='\$".$name.'_maj\'";'."\n");
			fwrite_encode($fp,'$virgule=\',\';'."\n");
		}
		else{
			fwrite_encode($fp,'$set= $set."$virgule '.$name."=\".quote($".$name.",'".$type."','".$flags."').slash(\$".$name.',\''.$type.'\',\''.$flags."').quote($".$name.",'".$type."','".$flags."');"."\n");
			fwrite_encode($fp,'$virgule=\',\';'."\n");
		}
	}
	$i++;
}

fwrite_encode($fp,'$req_update=$req_update.$set." where ".$clause'.";\n" );

//fwrite_encode($fp,'echo $req_update;'."\n" );
//fwrite_encode($fp,'exit();'."\n" );

fwrite_encode($fp,'execute_sql($req_update);'."\n" );


// redirection a gerer pour maj avec table fille affichee
if (!empty($CIF)&&($un_a_n_insertion=="1")){
	for ($i=0;$i<count($CIF);$i++){
		fwrite_encode($fp,'   if (mb_ereg(\''.$CIF[$i].'\',$url_retour))'."\n" );
		fwrite_encode($fp,'      $url_retour="'.$table.'_rech.php";'."\n" );
	}
}

/**************************** MAJ en cas de relation n a n a 2 pattes ************************/
for ($z=0;$z<5;$z++){
    if (!empty($table_fille[$z])){
        list($nom_table_relation,$col_asso)=explode(".",$association[$z]);
        list($nom_table_relation1,$col_asso1)=explode(".",$relation[$z]);   
        list($val_tmp,$col_depart)=explode(".",$relation[$z]);
        // supression des liens dans la table relation
        fwrite_encode($fp,'   $req="delete from '.$nom_table_relation.' where '.$col_depart.'=$id";'."\n" );
        fwrite_encode($fp,'   execute_sql($req);'."\n" );
        list($val,$col)=explode(".",$table_fille[$z]);
        $res = execute_sql("select * from $val");
        $nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
        $nom_col2= db_field_direct_name($res,1);
        fwrite_encode($fp,'   if ($affiche_popup==2)'."\n");
        fwrite_encode($fp,'       $liens=explode("\\n",$'.$col_asso.'[0]);'."\n" );
        fwrite_encode($fp,'   if ($affiche_popup==0)'."\n");
        fwrite_encode($fp,'      $liens=$'.$col_asso.';'."\n" );
        fwrite_encode($fp,'   if ($liens[0]!="")'."\n");
        fwrite_encode($fp,'   for ($i=0;$i<count($liens);$i++){'."\n" );
        fwrite_encode($fp,'      $tab=explode("|",$liens[$i]);'."\n");
        fwrite_encode($fp,'      $lien_id=$tab[0];'."\n");
        fwrite_encode($fp,'      if($lien_id!=""){'."\n");
        fwrite_encode($fp,'        $req="insert into '.$nom_table_relation.'('.$col_asso1.','.$col_asso.')'.' values($id,$lien_id)";'."\n" );
        fwrite_encode($fp,'         execute_sql($req);'."\n" );
        fwrite_encode($fp,'      }'."\n" );
        fwrite_encode($fp,'   }'."\n" );
    }
}


fwrite_encode($fp,'}'."\n" );

fwrite_encode($fp,'?>'."\n" );
//fwrite_encode($fp,'</form>'."\n" );

//inclusion de code specifique
fwrite_encode($fp,$insertion_fin_maj."\n" );

fwrite_encode($fp,'<?php'."\n" );
fwrite_encode($fp,'if (isset($suite)){'."\n" );
fwrite_encode($fp,'   echo "<script language=javascript>\n";'."\n" );
fwrite_encode($fp,'   echo "document.location.replace(\"'.$table.'_rech.php\");\n";'."\n" );
fwrite_encode($fp,'   echo "</script>\n";'."\n" );
fwrite_encode($fp,'}'."\n" );
fwrite_encode($fp,'include("piedpage.php");'."\n");
fwrite_encode($fp,'?>'."\n" );

?>
</body>
</html>
