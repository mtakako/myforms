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
$connexion=connexion($database);

$filename = $table."_ins.".$extension;
print "Ecriture du fichier <a href=$filename>$filename</a> <br />";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");

fwrite_encode($fp, "<?php\n" );
fwrite_encode($fp,'include("session.php");'."\n");
fwrite_encode($fp,'include("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode($fp,'@include("'.$table.'_diag.'.$extension.'");'."\n");
fwrite_encode($fp,"//Inclusion de la page entete qui inclue les variables et les fonctions.\n");
fwrite_encode($fp,'include("entete.php");'."\n");
fwrite_encode($fp,'$connexion=connexion($bdd);'."\n");
fwrite_encode($fp,'if (!empty($mode_affichage_popup)) $affiche_popup=$mode_affichage_popup;'."\n");

fwrite_encode($fp, "?>\n" );

fwrite_encode($fp,'<meta http-equiv="X-UA-Compatible" content="IE=8" />'."\n");
fwrite_encode($fp,'<script type="text/javascript">'."\n");
fwrite_encode($fp,$js_fonction_ins."\n" );
fwrite_encode($fp,'</script>'."\n");

fwrite_encode($fp, '<?php if (!isset($suite)){'."\n" );
fwrite_encode($fp, 'echo "<h2>$titreInsert $titre_formulaire </h2>";'."\n" );
fwrite_encode($fp, '?>'."\n" );

fwrite_encode($fp,"<form name=formulaire method=\"post\" enctype=\"multipart/form-data\">\n" );
fwrite_encode($fp,$insertion_deb_ins."\n" );

$req="select * from $table";

$result = execute_sql($req);
$fields = mysqli_num_fields($result);

fwrite_encode($fp,'<div class="tableform">'."\n");

fwrite_encode($fp,'<script type="text/javascript">'."\n");
fwrite_encode($fp,'function valider(){'."\n");
//if (!isset($editeur)){
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
		if (isset($ins_cols)&&in_array($i,$ins_cols)){
			//Gestion de la colonne etat en cas de workflow
			//Cette colone est obligatoire
			if ($nom_de_colonne=='etat'){
				// recup du numero de colonne de etat
				$i_etat=$i;
				$i++;
				fwrite_encode($fp,'   if (getCheckedRadioValue("etat")==null){'."\n");
				fwrite_encode($fp,'       alert("Indiquer un Etat de validation.");'."\n");
				fwrite_encode($fp,'       document.forms[0].elements["etat"].focus();'."\n");
				fwrite_encode($fp,'       return;'."\n");
				fwrite_encode($fp,'     }'."\n");
			}
			elseif (db_type($type,$flags)=='int'){
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
			else if (db_type($type,$flags)=='date'){
				if (mb_stristr($flags,'not_null'))
					fwrite_encode($fp,'      if ((document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value=="")||(CheckDate(document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value)==0)){'."\n");
				else
					fwrite_encode($fp,'      if (CheckDate(document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value)==0){'."\n");
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
//}

fwrite_encode($fp,$js_deb_ins."\n" );

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
		fwrite_encode($fp,'	var oFCKeditor'.$l.' = new FCKeditor("'.$tab_colonnes[$editeur[$l]].'","'.$largeur_editeur[$editeur[$l]].'","'.$hauteur_editeur[$editeur[$l]].'","Default","'.$defaut_editeur[$editeur[$l]].'");'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.BasePath	= sBasePath ;'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.ToolbarSet	= "Basic" ;'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.ReplaceTextarea() ;'."\n");
	}
	fwrite_encode($fp,'}'."\n");
	fwrite_encode($fp,'</script>'."\n");
}

//fwrite_encode($fp,'<table> '."\n");
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}
$num_gen=0; //numero de la zone de saisie pour l'editeur html
while ($i < $fields) {
	if (isset($ins_cols)&&in_array($i,$ins_cols)){

		$type  = db_field_direct_type($result, $i);
		$nom  = db_field_direct_name($result, $i);
		$len   = db_field_direct_len($result, $i);
				
		//$len++; //on augmente un peu la taille par precaution
		$flags = db_field_direct_flags($result, $i);

		// Gestion des labels
		if ($nom=='etat'){
			// ne rien faire
			$i++;
			continue;
		}
		fwrite_encode($fp,"<div $div_attributs[$i] class=trform>"."\n" );
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
		
		fwrite_encode($fp,'<div class="tdform tdfinform">'."\n");

		if (empty($fk)){
			if (isset($photos)&&in_array($i,$photos)){
				//MdB gestion de photos 02/07/03
				fwrite_encode($fp,"<input $attributs[$i] accept='image/*' onchange='preview_image(event,this)' type=file name='$nom'>\n");
				fwrite_encode($fp,"<img class='output_image' id='$nom'/>\n");	
			}
			elseif (isset($fichiers)&&in_array($i,$fichiers)){
				//MdB gestion des fichiers 13/10/12
				fwrite_encode($fp,"<input $attributs[$i] type=file name='$nom'>\n");
			}
			elseif (db_type($type,$flags)=='date'){
				fwrite_encode($fp,"<input $attributs[$i] class=\"w16em dateformat-d-sl-m-sl-Y\" type=text size=12 id='$nom' name='$nom'>\n");
				fwrite_encode($fp,'<script type="text/javascript">'."\n");
				if (!empty($defauts[$i])){
					fwrite_encode($fp,"document.forms[0].$nom.value=".$defauts[$i].";\n");
				}
				else{
					fwrite_encode($fp,"document.forms[0].$nom.value=date_jour();\n");
				}			
				fwrite_encode($fp,"</script>\n");
			}
			elseif (db_type($type,$flags)=='enum'){
				$valeur_defaut=field_defaut($i);
				fwrite_encode($fp,"<?php\n");
				fwrite_encode($fp,'$attribut_html="'.$attributs[$i]."\";\n");
				fwrite_encode($fp,"enum_option('$nom','$table',\"$valeur_defaut\");\n");
				fwrite_encode($fp,"?>\n");
			}
			elseif (db_type($type,$flags)=='set'){
				fwrite_encode($fp,"<?php\n");
				fwrite_encode($fp,'$attribut_html="'.$attributs[$i]."\";\n");
				fwrite_encode($fp,'$tab_valeur_defaut=array("'.field_defaut($i)."\");\n");
				fwrite_encode($fp,"set_checkbox('$nom','$table',".'$tab_valeur_defaut'.");\n");
				fwrite_encode($fp,"?>\n");
			}
			elseif ($len<=60){
			fwrite_encode($fp,"<input $attributs[$i] type=text  size=$len maxlength=$len name=$nom>\n");
			}
			elseif (($len > 60)&&($len<=100)){
			fwrite_encode($fp,"<input $attributs[$i] type=text  size=70 maxlength=$len name=$nom>\n");
			}
			elseif (($len > 100)&&($len<=255)){
				if (empty($defauts[$i])){
					fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=3 cols=60></textarea>\n");
				}
				else{
					fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=3 cols=60><?php echo $defauts[$i]?></textarea>\n");
				}
			}
			else{
				if (empty($defauts[$i])){
					fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=5 cols=60></textarea>\n");
				}
				else{
					fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=5 cols=60><?php echo $defauts[$i]?></textarea>\n");
				}
			}
		}
		else{
			fwrite_encode($fp,'<?php if (!isset($'.$nom.')) $'.$nom.'="";?>'."\n");
			//gestion de l'affichage des popups
			$req="select * from $fk";
			$result1 = execute_sql($req);
			$nom_col1= db_field_direct_name($result1,$cols1[$i]);
			$nom_col2= db_field_direct_name($result1,$cols2[$i]);


			fwrite_encode($fp,"<?php\n" );
			fwrite_encode($fp,'$fk_tab=explode(".",$tables['.$i.']);'."\n" );
			fwrite_encode($fp,'$fk_table=$fk_tab[0];'."\n" );
			fwrite_encode($fp,'$attribut_html="'.$attributs[$i]."\";\n");

			fwrite_encode($fp,'if ($affiche_popup==0)'."\n");
			fwrite_encode($fp, "   lister_table('$nom',".'$fk_table,$cols1['.$i.'],$cols2['.$i.'],$'.$nom.',1,stripslashes($req_fk['.$i."]));\n" );

			fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
			fwrite_encode($fp,'   echo "<input style=\'background-color:$couleur_protege;\' type=text onFocus=blur() size=30 value=\"$'.$nom.'\" name=\"'.$nom.'\">";'."\n");
			fwrite_encode($fp,'   echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$fk','$nom_col1','$nom_col2','1','','$nom','$table'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
			if (!mb_stristr($flags,"not_null"))
				fwrite_encode($fp,'     echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$nom.'\'])><img border=0 src=images/poubelle.gif alt=Effacer width=15 height=15></a>";'."\n");

			fwrite_encode($fp,"}\n" );
			fwrite_encode($fp,"?>\n" );
		}
		fwrite_encode($fp,"</div></div>\n" );
		fwrite_encode($fp,'<?php $attribut_html="";?>'."\n");
	}
	$i++;
}



$i=0;
if (!empty($CIF)&&($un_a_n_insertion=="1")){
		$CIF2=explode("\r\n",$CIF);

		if (!empty($CIF2[0])){
			for ($z=0;$z<count($CIF2);$z++){
				list($val,$col)=explode(".",$CIF2[$z]);
				$req="select * from $val";
				$res = execute_sql($req);
				$fields = mysqli_num_fields($res);
				$nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
				$nom_col2= db_field_direct_name($res,1);
				$f=0;
				while ($f < $fields) {
					$flags = db_field_direct_flags($res, $f);
					$nom  = db_field_direct_name($res, $f);
					if ($nom==$col){
						break;
					}
					$f++;
				}

				fwrite_encode($fp, '<div class=trform><div class=tdform><?php echo ucfirst(mb_strtolower($label_1an['.$i.']));?>'."</div>\n");
				fwrite_encode($fp,'<?php if (!isset($'.$nom_nan_id.')) $'.$nom_nan_id.'="";?>'."\n" );
//   lister_table_multiple($nom_objet,$table,$nom_table_id,$col1,$col2,$defaut,$vide,$relation,$nom_tableini_id)
				fwrite_encode($fp,"<div class=tdform>\n");
				//gestion de l'affichage des popup avec checkbox

				fwrite_encode($fp,"<?php\n" );
				fwrite_encode($fp,'if ($affiche_popup==0){'."\n");
				if (mb_stristr($flags,'not_null'))
					fwrite_encode($fp,"   lister_table_multiple('$nom_nan_id','$val','$nom_nan_id',0,1,'',0,'$cle','','');\n" );
		
                                else
					fwrite_encode($fp,"   lister_table_multiple('$nom_nan_id','$val','$nom_nan_id',0,1,'',1,'$cle','','');\n" );
				fwrite_encode($fp,"}\n" );
				fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
				fwrite_encode($fp,'   echo "<textarea style=\'background-color:$couleur_protege;\' rows=4 cols=40 name='.$nom_nan_id.'[] onClick=blur() onFocus=blur()></textarea>";'."\n" );
				if (mb_stristr($flags,'not_null'))
					fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$val','$nom_nan_id','$nom_col2','2','','$nom_nan_id','$table'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
				else
					fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$val','$nom_nan_id','$nom_col2','2','".urlencode("where $col is null")."','$nom_nan_id','$table'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
				fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$nom_nan_id.'[]\'])><img border=0 src=images/poubelle.gif alt=Effacer width=15 height=15></a>";'."\n");
				fwrite_encode($fp,"}\n" );
				fwrite_encode($fp,"?>\n" );

				fwrite_encode($fp,"</div></div>\n" );
				$i++;
			}
		}
}


$p=0;
$w=0; // GESTION des relations n a n avec 2 pattes
for ($z=0;$z<5;$z++){
    if (!empty($table_fille[$z])){
        list($nom_table_relation,$col_relation_depart)=explode(".",$association[$z]);
        list($val,$col)=explode(".",$table_fille[$z]);
        $res = execute_sql("select * from $val");
        $nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
        
        $tab_liste_num_colonne2=explode(',',$num_colonne2[$z]);
        $tab_liste_num_colonne2_fk=explode(',',$num_colonne2_fk[$z]);
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

        fwrite_encode($fp, '<div class=trform><div class=tdform><?php echo ucfirst(mb_strtolower($relation_2pattes['.$p.']));?>'."</div>\n");
        fwrite_encode($fp,'<?php if (!isset($'.$nom_nan_id.')) $'.$nom_nan_id.'="";?>'."\n" );
//   lister_table_multiple($nom_objet,$table,$nom_table_id,$col1,$col2,$defaut,$vide,$relation,$nom_tableini_id)
        fwrite_encode($fp,"<div class=tdform>\n");
        //gestion de l'affichage des popup avec checkbox
        fwrite_encode($fp,"<?php\n" );
        fwrite_encode($fp,'if ($affiche_popup==0){'."\n");
        
        if (!empty($tab_liste_num_colonne2[1])){
            $num_tri=($tab_liste_num_colonne2[0]+1).','.($tab_liste_num_colonne2[1]+1);
        }
        else{
            $num_tri=$tab_liste_num_colonne2[0]+1;                                           
        }
        fwrite_encode($fp,"\$reql1=\"select * from $val where 1=1 \$$col"."_clause order by $num_tri\";\n" );
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
        fwrite_encode($fp,"echo '</select></td></tr></table>';\n" );				
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
        fwrite_encode($fp,'   echo "<textarea style=\'background-color:$couleur_protege;\' rows=4 cols=40 name='.$col.'[] onClick=blur() onFocus=blur()></textarea>";'."\n" );
        fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$val','$nom_nan_id','$nom_col2','2','','$nom_nan_id','$table','$nom_autre_colonne'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
        fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$nom_nan_id.'[]\'])><img border=0 src=images/poubelle.gif alt=Effacer width=15 height=15></a>";'."\n");
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,"?>\n" );
        fwrite_encode($fp,"</div></div>\n" );
        $p++;
    }
}


//insertion de la gestion de l etat de la fiche
if (isset($ins_cols)&&in_array($i_etat,$ins_cols)){
        fwrite_encode($fp,'<div '.$div_attributs_edit[$i_etat].' class=trform>'."\n" );
        fwrite_encode($fp,'<div class="tdform">'."\n");
        fwrite_encode($fp,"Etat <font color=red>(*)</font>\n");
        fwrite_encode($fp,"</div>\n");
        fwrite_encode($fp,'<div class="tdform tdfinform tdfin'.$i_etat.'">'."\n");
        // Liste dtous les etats de la fiche
        fwrite_encode($fp,'<?php enum_tous_etats("etat", "START", "'.$attributs_edit[$i_etat].'");?>'."\n");
        fwrite_encode($fp,"</div>\n");
        fwrite_encode($fp,"</div>\n");
}

//Fin du tableau
fwrite_encode($fp,'</div>'."\n" );

/*
fwrite_encode($fp,'<?php'."\n" );
fwrite_encode($fp,'echo "<input type=hidden value=".$_SERVER[\'HTTP_REFERER\']." name=url_retour>";'."\n" );
fwrite_encode($fp,'?>'."\n" );
*/
fwrite_encode($fp,'</form>'."\n" );
fwrite_encode($fp,'<br/><font color=red>(*) Zone obligatoire</font>'."\n" );

fwrite_encode($fp,'<center><input type=button onClick=document.location.replace("<?php echo $_SERVER[\'HTTP_REFERER\']?>") value="<?php echo $autre_rechercher;?>">&nbsp;<input type=button onClick=valider() value="<?php echo $inserer;?>"></center>'."\n");
fwrite_encode($fp,'<?php'."\n" );
fwrite_encode($fp,'}'."\n" );
fwrite_encode($fp,'else{'."\n" );
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}

$values="";
$cols="";
$num_fields = mysqli_num_fields($result);
while ($i < $num_fields) {
	$nom  = db_field_direct_name($result, $i);
	$type  = db_field_direct_type($result, $i);
	$flags = db_field_direct_flags($result, $i);
	if (isset($ins_cols)&&in_array($i,$ins_cols)){
		if ((db_type($type,$flags)=='int')||(db_type($type,$flags)=='real')){
			fwrite_encode($fp,'   $critere_tab=explode("|",$'.$nom.');'."\n");
			fwrite_encode($fp,'   $'.$nom.'=$critere_tab[0];'."\n");
		}
		elseif (db_type($type,$flags)=='set'){
			fwrite_encode($fp,'   if (!empty($'.$nom.'))'."\n");
			fwrite_encode($fp,'      $'.$nom.'=implode(",",$'.$nom.');'."\n");
		}
		elseif (db_type($type,$flags)=='date'){
			fwrite_encode($fp,'   $'."$nom=date_to_us(".'$'."$nom);"."\n");
		}

		if (empty($cols))
			$cols= $nom;
		else
			$cols=$cols.','.$nom;

		if (empty($values)){
                    $values='"';
		}
		else{
                    $values.=".','";		
		}

		if (isset($photos)&&in_array($i,$photos)){
			$values.=".\"'\"".'.nom_fichier($_FILES[\''.$nom.'\'][\'name\'])'.".\"'\""; //MdB gestion de l'insertion de la photo
		}
		elseif (isset($fichiers)&&in_array($i,$fichiers)){
			$values.=".\"'\"".'.nom_fichier($_FILES[\''.$nom.'\'][\'name\'])'.".\"'\""; //MdB gestion de l'insertion du fichier
		}
                elseif (isset($editeur)&&in_array($i,$editeur)){
//                        $values.=".\"'\"".'.mysqli_real_escape_string($connexion,$nom)'.".\"'\""; //MdB gestion de l'insertion du fichier
			$values.='.quote($'.$nom.',\''.$type.'\',\''.$flags.'\')';
			$values.='.slash($'.$nom.',\''.$type.'\',\''.$flags.'\')';
			$values.='.quote($'.$nom.',\''.$type.'\',\''.$flags.'\')';
		}
		else {
			//$values= $values.','\'".slash($'.$nom.',\''.$type.'\',\''.$flags.'\')."\'';
			//$values.='.\',\'.quote($'.$nom.',\''.$type.'\',\''.$flags.'\').';
			$values.='.quote($'.$nom.',\''.$type.'\',\''.$flags.'\')';
			$values.='.slash($'.$nom.',\''.$type.'\',\''.$flags.'\')';
			$values.='.quote($'.$nom.',\''.$type.'\',\''.$flags.'\')';	 
		}
		
	}
	$i++;
}

$req="insert into $table ($cols) values($values".'.")"';
fwrite_encode($fp,'   $req="'.$req.';'."\n" );
fwrite_encode($fp,'   execute_sql($req);'."\n" );
fwrite_encode($fp,'   $dernier_id=mysqli_insert_id($connexion);'."\n" );

// MdB 03/07/03 Gestion des photos
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}
$num_fields = mysqli_num_fields($result);
while ($i < $num_fields) {
	$nom  = db_field_direct_name($result, $i);
	//MdB gestion de l'insertion de la photo
	if (isset($ins_cols)&&in_array($i,$ins_cols)){
		if (isset($photos)&&in_array($i,$photos)){
			fwrite_encode($fp,'   //gestion des insertions des photos'."\n");
			fwrite_encode($fp,'   $nomDestination=\''.$table.'-\'.$dernier_id.\'-\'.\''.$nom.'\'."-".nom_fichier($_FILES["'.$nom.'"]["name"]);'."\n");
			fwrite_encode($fp,'   if (@copy($_FILES[\''.$nom.'\'][\'tmp_name\'], $rep."/".$nomDestination)) {'."\n");
			fwrite_encode($fp,'      echo("<b>Fichier $nomDestination copie avec succes</b>");'."\n");
			fwrite_encode($fp,'   } else {'."\n");
			//fwrite_encode($fp,'      echo("<b>La copie du fichier $nomDestination a echoue...</b>");'."\n");
			fwrite_encode($fp,'   }'."\n");
			fwrite_encode($fp,'   @unlink($_FILES["'.$nom.'"]["tmp_name"]);'."\n");
		}
		if (isset($fichiers)&&in_array($i,$fichiers)){
			fwrite_encode($fp,'   //gestion des insertions des fichiers'."\n");
			fwrite_encode($fp,'   $nomDestination=\''.$table.'-\'.$dernier_id.\'-\'.\''.$nom.'\'."-".nom_fichier($_FILES["'.$nom.'"]["name"]);'."\n");
			fwrite_encode($fp,'   if (@copy($_FILES[\''.$nom.'\'][\'tmp_name\'], $rep."/".$nomDestination)) {'."\n");
			fwrite_encode($fp,'      echo("<b>Fichier $nomDestination copie avec succes</b>");'."\n");
			fwrite_encode($fp,'   } else {'."\n");
			//fwrite_encode($fp,'      echo("<b>La copie du fichier $nomDestination a echoue...</b>");'."\n");
			fwrite_encode($fp,'   }'."\n");
			fwrite_encode($fp,'   @unlink($_FILES["'.$nom.'"]["tmp_name"]);'."\n");
		}
	}
	$i++;
}
/**************************** MAJ en cas de relation 1 a n ************************/

if (!empty($CIF)&&($un_a_n_insertion=="1")){
		$CIF2=explode("\r\n",$CIF);
		if (!empty($CIF2[0])){
			for ($z=0;$z<count($CIF2);$z++){
				list($val,$col)=explode(".",$CIF2[$z]);
				$req="select * from $val";
				$res = execute_sql($req);
				$nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
				$nom_col2= db_field_direct_name($res,1);
				fwrite_encode($fp,'   if ($affiche_popup==2)'."\n");
				fwrite_encode($fp,'       $liens=explode("\\n",$'.$nom_nan_id.'[0]);'."\n" );
				fwrite_encode($fp,'   if ($affiche_popup==0)'."\n");
				fwrite_encode($fp,'      $liens=$'.$nom_nan_id.';'."\n" );
				fwrite_encode($fp,'   if ($liens[0]!="")'."\n");
				fwrite_encode($fp,'   for ($i=0;$i<count($liens);$i++){'."\n" );
				fwrite_encode($fp,'      $tab=explode("|",$liens[$i]);'."\n");
				fwrite_encode($fp,'      $lien_id=$tab[0];'."\n");
				fwrite_encode($fp,'      if($lien_id!=""){'."\n");
				fwrite_encode($fp,'         $req="update '.$val.' set '.$col.'=$dernier_id where '.$nom_nan_id.'=$lien_id";'."\n" );
				fwrite_encode($fp,'         execute_sql($req);'."\n" );
				fwrite_encode($fp,'      }'."\n" );
				fwrite_encode($fp,'   }'."\n" );
			}
		}
}


/**************************** MAJ en cas de relation n a n ************************/
for ($z=0;$z<5;$z++){
    if (!empty($table_fille[$z])){
        list($nom_table_relation,$col_asso)=explode(".",$association[$z]);
        list($nom_table_relation1,$col_asso1)=explode(".",$relation[$z]);
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
        fwrite_encode($fp,'        $req="insert into '.$nom_table_relation.'('.$col_asso1.','.$col_asso.')'.' values($dernier_id,$lien_id)";'."\n" );
        fwrite_encode($fp,'         execute_sql($req);'."\n" );
        fwrite_encode($fp,'      }'."\n" );
        fwrite_encode($fp,'   }'."\n" );
    }
}


fwrite_encode($fp,'}'."\n" );
fwrite_encode($fp,'?>'."\n" );

//inclusion de code specifique
fwrite_encode($fp,$insertion_fin_ins."\n" );
fwrite_encode($fp,'<?php'."\n" );
fwrite_encode($fp,'if (isset($suite)){'."\n" );
fwrite_encode($fp,'   echo "<script language=javascript>\n";'."\n" );
fwrite_encode($fp,'   echo "document.location.replace(\"'.$table.'_rech.php\");\n";'."\n" );
fwrite_encode($fp,'   echo "</script>\n";'."\n" );
fwrite_encode($fp,'}'."\n" );
fwrite_encode($fp,'include("piedpage.php");'."\n");
fwrite_encode($fp,'?>'."\n" );
fclose( $fp );
?>
</body>
