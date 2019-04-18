<?php
//------------------------------------------------------------------
function connexion($bdd){
// variables de connexion
	global $user;
	global $password;
	global $host;
	global $encodage_bdd;

// connexion au serveur
	$connexion=mysqli_connect($host,$user,$password) or die("erreur de connexion au serveur $host");
	mysqli_select_db($connexion,$bdd) or die("erreur de connexion a la base de donnees $bdd");
	mysqli_set_charset($connexion,$encodage_bdd);
//	mysqli_set_charset("latin1",$connexion);
//	echo mysqli_client_encoding($connexion);
//	global $REQUEST_URI;
//	echo $REQUEST_URI;
//	echo mb_detect_encoding(urldecode($REQUEST_URI), 'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP, ISO-8859-1');
	return $connexion;
}

// Fonction de controle de date en PHP au format 00/00/0000
function isdate($madate) {
      $tab_dt = explode('/',$madate);
      if (mb_strlen(trim($madate))!=10 || count($tab_dt)!=3 ||$tab_dt[1]>12 || checkdate($tab_dt[1], $tab_dt[0], $tab_dt[2]) == FALSE  ) {
        echo "Erreur de format de date (00/00/0000) : $madate <br>";
        $msg="Erreur de format de date (00/00/0000) : $madate -".implode('|',$_POST).'\n----\n'.implode('|',$_SERVER);
        echo "<a href=javascript:history.back()>Retour</a>";
        exit;
      }
      //Retourne la date si besoin
      return $madate;
}

function generer_passwd () {
	$chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
	//nombre de caracteres dans le mot de passe
	$nb_caract = 8;
	$pwd ='';
	//on fait une boucle
	for($u = 1; $u <= $nb_caract; $u++) {
		
	//on compte le nombre de caracteres presents dans notre chaine
		$nb = mb_strlen($chaine);
		
	// on choisie un nombre au hasard entre 0 et le nombre de caracteres de la chaine
		$nb = mt_rand(0,($nb-1));
		
	// on ecrit  le resultat
		$pwd .= $chaine[$nb];
	}
	return $pwd;

}


//------------------------------------------------------------------
// fonction qui permet de recuperer les valeurs du champ n a n en edition en mod 2
function valeurs_nan($id,$cle1_nan,$cle2_nan,$cle3_fille,$nom_col1,$nom_col2,$table_nan,$table_fille,$nom_autre_colonne){
        $req="select * from $table_nan,$table_fille where $table_nan.$cle1_nan=$id and $table_nan.$cle2_nan=$table_fille.$cle3_fille";
        $resultat_sql=execute_sql($req);
        $flag=0;
        while($row=mysqli_fetch_array($resultat_sql)){
                if ($flag==1){
                        $res.="\n";
                }
                $flag=1;
                $res=$res.$row[$nom_col1].'|'.$row[$nom_col2].' '.$row[$nom_autre_colonne];
        }
        return $res;
}


//------------------------------------------------------------------
function num_col_depuis_nom($tab_colonnes,$nom_colonne){
	for ($i=0;$i<count($tab_colonnes);$i++){
		if ($tab_colonnes[$i]==$nom_colonne){
			return $i;
		}
	}
	return -1;
}

//------------------------------------------------------------------
function nom_fichier($fichier){
	$fichier=stripslashes($fichier);
	$fichier=strip_tags($fichier);  //retire les balises HTML
	$fichier=mb_ereg_replace('"','', $fichier);
	$fichier=mb_ereg_replace("'",'', $fichier);
	$fichier=mb_ereg_replace(" ",'', $fichier);
	return $fichier;
}


//------------------------------------------------------------------
function stripslashes_guillemets($string) {
// on ne veut des antislashs que devant chaque quote '
	if(!get_magic_quotes_gpc()){
	  //si magic_quotes_gpc est en arret, alors il faut le simuler 
	  $string=addslashes($string);
	}
	// retire les antislash devant chaque " et transforme les \\ en \
	// attention a laisser les \n
	$string = mb_ereg_replace("\\\"", "\"", $string);
	$string = mb_ereg_replace("\\\\\"", "\"", $string);
	$string = mb_ereg_replace("\\\\", "\\", $string);
	return $string;
}

//------------------------------------------------------------------
function field_defaut($num_col){
	global $table;
	global $connexion;
	$resultat = mysqli_query($connexion,"SHOW FIELDS FROM $table");
	$i = 0;
	while ($row = mysqli_fetch_array($resultat)) { //go through one field at a time
	if ($i==$num_col) return $row['Default'];
	$i++;
	}
}

//------------------------------------------------------------------
function fwrite_encode($fh,$myString){
	//global $encodage;	
	//Transformation des accents en HTML
//	fwrite($fh,htmlspecialchars_decode(htmlentities($myString, ENT_NOQUOTES, $encodage), ENT_NOQUOTES));
	//L'encodage se fait automatiquement en fonction de la page generate.php
	// qui prend le bon encodage en fonction du parametrage encodage.inc.php
	//Il faut tout de meme que les informations saisie dans colonne.php soient dans le bon encodage
	// et donc que les accents soient bien lisibles
        fwrite($fh,$myString);
}

//------------------------------------------------------------------
function format_tel($tel){
	if (mb_strlen($tel)==10)
		return wordwrap($tel, 2, '.', 1);
	else
		return $tel;
}

//------------------------------------------------------------------
// Met des antislash et renvoie la valeur NULL si le champ est vide et nullable
function slash($txt,$type,$flag){
        $type=db_type($type,$flags);
	//si la valeur est vide on peut forcer de la mettre a NULL en base
	if (($txt=='')||empty($txt)){
		if (($type=='string') || ($type=='blob')) {
			if (mb_stristr($flag,'not_null')===FALSE){
				$txt='NULL';
			}
			else{
				$txt='';
			}
		}	
		elseif ($type=='date') {
			if (mb_stristr($flag,'not_null')===FALSE){
				$txt='NULL'; //not_null non trouvé
			}
			else{
				$txt='IMPOSSIBLE CTRL JS : DATE OBLIGATOIRE';
			}
		}	
		elseif ($type=='int') {
			if (mb_stristr($flag,'not_null')===FALSE){
				//$txt=0;
				$txt='NULL'; //On choisi de mettre NULL par défaut et pas 0 si le champ est nullable
			}
		}
		else{ //si la colonne peut etre null alors on met NULL par defaut
			if (mb_stristr($flag,'not_null')===FALSE){
				$txt='NULL';
			}
		}
	}
	//Si magic_quotes_gpc est a off, alors
	//return addslashes($txt);	
	if(get_magic_quotes_gpc())
                return $txt;
	else //off
		return addslashes($txt);
		//mysqli_real_escape_string() serait encore mieux...
}
//------------------------------------------------------------------
function quote($txt,$type,$flag){
        $type=db_type($type,$flags);
	if ($type=='int') { //Pour le type int on n'encadre jamais par des quotes
		return "";
	}
	// si la valeur est vide et que par defaut c'est Null alors on peut ne pas mettre de quote
	if (($txt=='')||empty($txt)){
		if (($type=='string') || ($type=='blob')) {
			if (mb_stristr($flag,'not_null')===FALSE){
				return "";
			}
			else {
				return "'";
			}
		}
		elseif ($type=='date') {
			if (mb_stristr($flag,'not_null')===FALSE){
				return "";
			}
			else {
				return "";//IMPOSSIBLE CTRL JS : DATE OBLIGATOIRE => REQ SQL A FAIRE PLANTER
				//return "'";
			}
		}
		else{ //si la colonne peut etre null alors on met NULL par defaut
			if (mb_stristr($flag,'not_null')===FALSE){
				return "";
			}
		}
	}
	return "'";
}


//------------------------------------------------------------------
// Convertit une donnee en provenance de la base pour affichage dans un formulaire
function ret_base($valeur_base){
	global $encodage;
	//ENT_QUOTES : Convertit les guillemets doubles et les guillemets simples.
	return htmlspecialchars($valeur_base, ENT_QUOTES, $encodage);
	//return htmlspecialchars($valeur_base, ENT_QUOTES, 'ISO-8859-1');
}

//------------------------------------------------------------------
// Convertit une donnee pour affichage dans un formulaire
function echo_form($valeur){
	global $encodage;
	//ENT_QUOTES : Convertit les guillemets doubles et les guillemets simples.
	//return htmlspecialchars($valeur_base, ENT_QUOTES, 'ISO-8859-1');
	
	//Si magic_quotes_gpc est a on, alors
	//return stripslashes($txt);	
	if(get_magic_quotes_gpc())
        	return htmlspecialchars(stripslashes($valeur), ENT_QUOTES, $encodage);
	else //off
		return $valeur;
}


//------------------------------------------------------------------
// Convertit une donnee en provenance de la base pour affichage dans une page HTML
function ret_base_html($valeur_base){
	global $encodage;
	//ENT_QUOTES : Convertit les guillemets doubles et les guillemets simples.
	return nl2br(htmlentities($valeur_base, ENT_QUOTES, $encodage));
}

//------------------------------------------------------------------
// Convertit une donnee pour affichage dans une page HTML
function echo_html($valeur){
	global $encodage;
	//ENT_QUOTES : Convertit les guillemets doubles et les guillemets simples.
	return nl2br(htmlentities($valeur, ENT_QUOTES, $encodage));
}


//------------------------------------------------------------------
function erreur_sql($resultat_sql,$req){
	global $encodage;
	if (!$resultat_sql){
		echo "Requête : ".$req."<BR>\n";
		$error="Erreur : ".mysqli_errno()." : ".mysqli_error();
		echo $error."<BR>\n";
		$filename ="error_sql.log";
		$fp = fopen( $filename, "a+" ) or die("Impossible d'ouvrir $filename");
		$date=date("l dS of F Y h:i:s A");
		fwrite_encode( $fp,$date."\n");
		global $PHP_SELF;
		fwrite_encode( $fp,$PHP_SELF."\n");
		fwrite_encode( $fp,$req."\n");
		fwrite_encode( $fp,$error."\n");
		fwrite_encode( $fp,"\n");
		fclose( $fp );
		$msg="Erreur SQL : $req -".implode('|',$_POST).'\n----\n'.implode('|',$_SERVER);
        	echo "ERREUR SQL - <a href=javascript:history.back()>Retour</a>";
		exit;
	}
}

//------------------------------------------------------------------
function execute_sql($req){
        global $connexion;
	$resultat_sql=mysqli_query($connexion,$req);
	erreur_sql($resultat_sql,$req);
	return $resultat_sql;
}

// la fonction de redirection ------------
// Utiliser la redirection
//redirect("http://www.altavista.fr");
function redirection($where) {
	if ( $where <> '' ) {
		echo '<script language="javascript">'."\n";
		echo ' document.location.replace("'.$where.'")'."\n" ;
		echo '</script>'."\n";
		die();
	}
}

// Fonction d'ouverture d'une nouvelle page
function redirectOpener($where) {
	if ( $where <> '' ) {
		echo '<script language="javascript">'."\n";
		echo ' window.opener.location="'.$where.'"'."\n" ;
		echo ' window.close()'."\n" ;
		echo '</script>'."\n";
		die();
	}
}

//Pour tronquer une chaîne trop longue et mettre a la suite 3 points evoquateurs :
function tronquer($comment){
	global $lg_max;
	if (empty($lg_max)){
		$lg_max = 40;
	}

	$taille = mb_strlen($comment);

	if (is_numeric($comment)){
		return $comment;
	}
	
	if (empty($comment)){
		$comment="&nbsp;";
	}
	if ($taille > $lg_max){
		$comment=strip_tags($comment);  //retire les balises HTML
		$comment=mb_ereg_replace("\n",' ', $comment);
		$comment=mb_ereg_replace("\n",' ', $comment);
		$comment=mb_ereg_replace("-",' ', $comment);
		$comment = mb_substr($comment, 0, $lg_max);
		$last_space = mb_strrpos($comment, " ");
		$comment = mb_substr($comment, 0, $last_space)."...";
	}
	return $comment;
}

//Pour tronquer une chaîne trop longue et mettre a la suite 3 points evoquateurs :
function tronquer_taille($comment,$taille_max){
	if (empty($taille_max)){
		$taille_max = 40;
	}

	$taille = mb_strlen($comment);

	if (is_numeric($comment)){
		return $comment;
	}

	if ($taille > $taille_max){
		$comment = mb_substr($comment, 0, $taille_max);
		$last_space = mb_strrpos($comment, " ");
		$comment = mb_substr($comment, 0, $last_space)."...";
	}
	return $comment;
}

//------------------------------------------------------------------
function verif_email($str) {
	// Renvoie 1 si l'adresse est valide, 0 dans le cas contraire

	if (mb_ereg("^.+@.+\\..+$", $str)) {
		return 1;
	} else {
		return 0;
	}
}

//------------------------------------------------------------------
// fonction qui permet de lister une table dans une liste deroulante
function lister_table($nom_objet,$table,$col1,$col2,$defaut,$vide,$req_fk) {
	global $num_autre_colonne;
	global $attribut_html;
        $tab_liste_num_colonne2=@explode(',',$num_autre_colonne);
	
	// Renvoie 1 si l'adresse est valide, 0 dans le cas contraire
	// si $vide vaut 0 => alors on ne met pas d'element vide

	if (isset($req_fk)&&$req_fk!=''){
		$req=$req_fk;
	}
        else {
                if (!empty($tab_liste_num_colonne2[1])){
                        $req="select * from $table order by ".($col2+1).','.($tab_liste_num_colonne2[1]+1);
                }
                else{
                        $req="select * from $table order by ".($col2+1);
                }
        }


	$resultat_sql=execute_sql($req);
	$nbre_col=mysqli_num_fields($resultat_sql);
	echo "<select $attribut_html name=\"$nom_objet\">";
	if ($vide!=0)
		echo "<option value=''>";

	while($row=mysqli_fetch_row($resultat_sql)){
            $autre_colonne='';
            for ($u=1;$u<count($tab_liste_num_colonne2);$u++){
                    $num=$tab_liste_num_colonne2[$u];
                    $autre_colonne.=' '.tronquer($row[$num]);
            }
            if ($defaut==$row[$col1])
                    echo "<option selected value=\"$row[$col1]\">".tronquer($row[$col2]).$autre_colonne;
            else
                    echo "<option value=\"$row[$col1]\">".tronquer($row[$col2]).$autre_colonne;
	}
	echo "</select>";
}

//------------------------------------------------------------------
// fonction qui permet de creer la requete de recherche dans les popup
function req_popup($nom_objet,$table,$col1,$col2,$defaut,$vide,$req_fk) {
	// Renvoie 1 si l'adresse est valide, 0 dans le cas contraire
	// si $vide vaut 0 => alors on ne met pas d'element vide

	if (isset($req_fk)&&$req_fk!=''){
		$req=$req_fk;
	}
	else {
		$req="select * from $table order by ".($col2+1);
		//$req="select * from $table $clause order by ".($col2+1);
	}

	$resultat_sql=execute_sql($req);
	$nbre_col=mysqli_num_fields($resultat_sql);
	echo "<select name=$nom_objet>";
	if ($vide!=0)
		echo "<option value=''>";
	while($row=mysqli_fetch_row($resultat_sql)){
		if ($defaut==$row[$col1])
			echo "<option selected value=\"$row[$col1]\">".tronquer($row[$col2]);
		else
			echo "<option value=\"$row[$col1]\">".tronquer($row[$col2]);
	}
	echo "</select>";
}



//------------------------------------------------------------------
// fonction qui permet de lister un libelle a partir d'un id
function lister_id_libelle($nom_objet,$table,$col1,$col2,$defaut) {
	$req="select * from $table where $nom_objet=$defaut";
	$resultat_sql=execute_sql($req);
	$nbre_col=mysqli_num_fields($resultat_sql);
	$row=mysqli_fetch_row($resultat_sql);
	if (empty($col2)){	
		$i=1;
		while ((is_numeric($row[$i])||is_null($row[$i]))&&($i<=$nbre_col)){
			$i++;
		}
		if ($i<=$nbre_col)
			$col2=$i;
	}
	return $row[$col1].'|'.$row[$col2];
}

//------------------------------------------------------------------
// fonction qui permet de lister la colonne 2 d'une table pour le premier enregistrement
function lister_col2($req) {
	$resultat_sql=execute_sql($req);
	erreur_sql($resultat_sql,$req);

	$nbre_col=mysqli_num_fields($resultat_sql);
	$row=mysqli_fetch_row($resultat_sql);
	if (empty($row[1]))
		return "&nbsp;";
	else{
		$table = mysqli_fetch_field_direct($resultat_sql,0)->name;
		$i=1;
		while ((is_numeric($row[$i])||is_null($row[$i]))&&($i<=$nbre_col)){
			$i++;
		}
		if ($i>$nbre_col)
			$i=2;
		return tronquer($row[$i]);
	}
}


//------------------------------------------------------------------
// fonction qui permet de lister la colonne num
function lister_col_num_lib($req,$col) {
	global $affichage_id_etranger;
	$req_tab=explode('order',$req);
	$req= $req_tab[0];
	$resultat_sql=execute_sql($req);
	erreur_sql($resultat_sql,$req);
	$row=mysqli_fetch_row($resultat_sql);

	if (empty($row[$col]))
		if ($affichage_id_etranger=="1"){
			$req_tab=explode('=',$req);
			$tab_id=count($req_tab)-1;
			$retour=mb_ereg_replace("'","",$req_tab[$tab_id]);
			return $retour;
		}
		else
			return "";
	else{
		return $row[$col];
	}
}

//------------------------------------------------------------------
// fonction qui permet de transformer une date JJ/MM/YYYY en YYYY-MM-JJ
function date_to_us($date){
	if(!empty($date)){
		isdate($date);
		list($jour,$mois,$annee) = explode("/",$date);
		return "$annee-$mois-$jour";
	}
}

//------------------------------------------------------------------
// fonction qui permet de transformer une date YYYY-MM-JJ en JJ/MM/YYYY
function date_to_fr($date){
	if(!empty($date)&&($date=='0000-00-00')){
		return '';
	}
	if(!empty($date)){
		list($annee,$mois,$jour) = explode("-",$date);
		return "$jour/$mois/$annee";
	}
}

//------------------------------------------------------------------
// fonction qui permet de transformer une date YYYY-MM-JJ en jour mois annee
function date_to_france($date){
	if(!empty($date)&&($date=='0000-00-00')){
		return '';
	}
	if(!empty($date)){
		list($annee,$mois,$jour) = explode("-",$date);

		//Voici les deux tableaux des jours et des mois traduits en français
		$nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
		$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", 
        "septembre", "octobre", "novembre", "décembre");
		// on extrait la date du jour
		list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y",mktime(0, 0, 0, $mois, $jour, $annee)));
		return $nom_jour_fr[$nom_jour].' '.$jour.' '.$mois_fr[$mois].' '.$annee; 
	}
}

//------------------------------------------------------------------
// fonction qui permet de lister une table dans une liste deroulante a choix multiple pour relation n a n
function lister_table_multiple($nom_objet,$table,$nom_table_id,$col1,$col2,$defaut,$vide,$relation,$nom_tableini_id,$clause) {
	global $num_autre_colonne;

	// Renvoie 1 si l'adresse est valide, 0 dans le cas contraire
	// $vide vaut 0 -> alors on ne met pas d'element vide
	$tri=$col2+1;
	$req="select * from $table $clause order by $tri";
	$resultat_sql=execute_sql($req);
	$nbre_col=mysqli_num_fields($resultat_sql);
	echo "<select multiple size=6 name=".$nom_objet."[]>";
	if ($vide!=0){
		echo "<option value=''>";
	}
	while($row=mysqli_fetch_row($resultat_sql)){
		$nb_lien=0;
		if (!empty($defaut)&&!empty($nom_tableini_id)){
			$req2="select * from $relation where $nom_tableini_id=$defaut and $nom_table_id=$row[0]";
			$resultat_sql2=execute_sql($req2);
			$nb_lien=mysqli_num_rows($resultat_sql2);
		}
		if (!empty($defaut)&&empty($nom_tableini_id)&&($defaut==$row[$col1])){
			$nb_lien=1;
		}


		$i=1;
		while ((is_numeric($row[$i])||is_null($row[$i]))&&($i<=$nbre_col)){
			$i++;
		}
		if ($i>$nbre_col)
			$i=$col2;
		if ($i<$col2)
			$i=$col2;

		if ($nb_lien>0)
			echo "<option selected value=$row[$col1]>".tronquer($row[$i]).' '.tronquer($row[$num_autre_colonne]);
		else
			echo "<option value=$row[$col1]>".tronquer($row[$i]).' '.tronquer($row[$num_autre_colonne]);
	}
	echo "</select>";
	if (!empty($defaut)&&!empty($nom_tableini_id)){
		echo "Multiselection : Ctrl + Clic";
	}
}

//------------------------------------------------------------------
// fonction qui permet de lister une table a partir d'une FK pour remplir un textarea
function lister_liens_multiple($nom_objet,$table,$nom_table_id,$col1,$col2,$defaut,$relation,$nom_tableini_id) {
	$req="select * from $table,$relation where $table.$nom_table_id=$relation.$nom_table_id and $nom_tableini_id=$defaut";
	$resultat_sql=execute_sql($req);
	$nbre_col=mysqli_num_fields($resultat_sql);
	$i=1;
	while ((is_numeric($row[$i])||is_null($row[$i]))&&($i<=$nbre_col)){
			$i++;
	}
	if ($i>$nbre_col)
			$i=$col2;
	while($row=mysqli_fetch_row($resultat_sql)){
			echo "\n$row[$col1]-".tronquer($row[$col2]);
	}
}

function enum_option($field,$table,$valeur_defaut) {
	global $attribut_html;
	global $connexion;
	global $affichage_radio_horizontal;
	
	if ($affichage_radio_horizontal!="1"){
            $retour_ligne='<br/>';
	}
	$result=mysqli_query($connexion,"SHOW COLUMNS FROM `$table` LIKE '$field'");
	if(mysqli_num_rows($result)>0){
		$row=mysqli_fetch_row($result);
		$options=explode("','", preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $row[1]));
	}
	for ($i=0;$i<count($options);$i++){
		echo "<input $attribut_html type='radio' name='$field' value='$options[$i]'";
		if ($options[$i]==$valeur_defaut)
			echo " checked";
		echo ">$options[$i] $retour_ligne\n";
	}
}

function enum_etat($options,$nom_objet,$valeur_defaut) {
	echo "<select name='$nom_objet'>";
	echo "<option";
	if ('Tous'==$valeur_defaut) echo " selected";
	echo " value='Tous'>Tous";
	for ($i=0;$i<count($options);$i++){
		echo "<option";
		if ($options[$i]==$valeur_defaut) echo " selected";
		echo " value='$options[$i]'>".$options[$i];
	}
	echo "<option";
	if ('Aucun'==$valeur_defaut) echo " selected";
	echo " value='Aucun'>Aucun";
	echo "<option";
	if ('Invisible'==$valeur_defaut) echo " selected";
	echo " value='Invisible'>Invisible</select>";
}

function enum_etat_niveau($options,$nom_objet,$valeur_defaut) {
	echo "<select name='$nom_objet'>";
	echo "<option value='---'>---";
	for ($i=0;$i<count($options);$i++){
		echo "<option";
		if ($options[$i]==$valeur_defaut) echo " selected";
		echo " value='$options[$i]'>".$options[$i];
	}
	echo "</select>";
}


function enum_etats_suivants($nom_objet,$etat_en_cours,$attribut_input) {
	global $tabetats;
	$tabetats_suivants=explode('|',$tabetats[$etat_en_cours]);

	if ((count($tabetats_suivants)==1)&&($etat_en_cours=='START')){
		echo "<input type=text style='visibility:hidden;display:none' value=\"$tabetats_suivants[0]\"  name=\"$nom_objet\">";

	}
	else{

		for ($i=0;$i<count($tabetats_suivants);$i++){
			if (!empty($tabetats_suivants[$i])){
				echo "<input $attribut_input type='radio' name='$nom_objet' value=\"".$tabetats_suivants[$i]."\"";
				echo '>'.$tabetats_suivants[$i]."\n";
			}
		}
	}
	if ($etat_en_cours!='START') echo '<br/><font color=red>(Etat en cours : '.$etat_en_cours.')</font>';
}

function enum_tous_etats($nom_objet,$etat_en_cours,$attribut_input) {
	global $lesetats;
	for ($i=0;$i<count($lesetats);$i++){
		echo "<input $attribut_input type='radio' name='$nom_objet' value=\"".$lesetats[$i]."\"";
		if ($etat_en_cours==$lesetats[$i]) echo ' checked';
		echo '>'.$lesetats[$i]."\n";
	}
}

function diag_etat($options,$nom_etat,$valeur_defaut) {
	echo "<select name='$nom_etat'>";
	echo "<option value=''>";
	for ($i=0;$i<count($options);$i++){
		echo "<option";
		if ($options[$i]==$valeur_defaut) echo " selected";
		echo " value='$options[$i]'>".$options[$i];
	}
	echo "</select>";
}

/*
function tab_etat($table) {

	$result_etat=mysqli_query("SHOW COLUMNS FROM `$table` LIKE 'etat'");

	if(mysqli_num_rows($result_etat)>0){
		$row=mysqli_fetch_row($result_etat);
		$options=explode("','", preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $row[1]));
	}
	$options=$table;
	return $options;
}
*/

function set_checkbox($field,$table,$tab_valeur_defaut) {
	global $attribut_html;
	global $connexion;
	global $affichage_checkbox_horizontal;
	
	if ($affichage_checkbox_horizontal!="1"){
            $retour_ligne='<br/>';
	}
	$result=mysqli_query($connexion,"SHOW COLUMNS FROM `$table` LIKE '$field'");
	if(mysqli_num_rows($result)>0){
		$row=mysqli_fetch_row($result);
		$checkboxs=explode("','", preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $row[1]));
	}
	for ($i=0;$i<count($checkboxs);$i++){
		echo "<input $attribut_html type='checkbox' name='$field".'[]'."' value='$checkboxs[$i]'";
		for ($j=0;$j<count($tab_valeur_defaut);$j++){
				if ($checkboxs[$i]==$tab_valeur_defaut[$j])
					echo " checked";
		}
		echo ">$checkboxs[$i] $retour_ligne\n";
	}
}

function enum_select($field,$table,$valeur_defaut) {
        global $connexion;
	$result=mysqli_query($connexion,"SHOW COLUMNS FROM `$table` LIKE '$field'");
	if(mysqli_num_rows($result)>0){
		$row=mysqli_fetch_row($result);
		$options=explode("','", preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $row[1]));
	}
	echo "<select name=\"$field\"><option value=''>";

	for ($i=0;$i<count($options);$i++){

		if ($options[$i]==$valeur_defaut)
			echo "<option value='$options[$i]' selected>$options[$i] &nbsp;\n";
		else
			echo "<option value='$options[$i]'>$options[$i] &nbsp;\n";

	}
	echo "</select>";
}
function execute_select($req,$mod,$CIF,$name_ID,$pk_table,$popup,$mod_tabulaire,$all_lignes){
/* NOUVELLE GESTION DES DROITS
V => Voir, vue
M => MAJ
I => Ins
D => Del
W => Workflow
*/

//$CIF est un tableau qui contient le nom des tables vers lesquelles on affiche un lien
//$CIF vaut 0 si il n'y a pas de table
//$pk_table est un tableau associatif qui lie les pk et le nom de leur table, ce tableau peut être vide
//$popup indique si l'on doit afficher des radios (1) ou des cases a cocher (2)  ou rien (0)
//$mod_tabulaire vaut 0 pour un affichage au format tableau et 1 pour un affichage type formulaire
//si $all_lignes vaut 1 alors on affiche tous les enregistrements dans la page en cours
	global $page;
	global $nbLig;
	global $ecart_page; // nbre de pages en lien avant et apres la page en cours
	global $inserer_moteur;
	global $affiche_popup;
	global $fermeture;
	global $resultats;
	global $colonnes_nan; //tableau contenant la liste des colonnes en relation nan (pour les relations a + de 3 pattes)
	global $colonnes_2nan; //tableau contenant la liste des colonnes en relation nan (pour les relations a 2 pattes)
	global $table_2nan;
	global $tab_affichage; //liste des entetes de colonnes
	global $label; //liste des entetes de colonnes
	global $id_service;
	global $id_pole;
	global $req_fk;
	global $tab_colonnes;
	global $cols1;
	global $cols2;
	global $ascdesc;
	global $photos;
	global $rep;
	
	if (empty($all_lignes))
		$all_lignes=0;//page par page a afficher par defaut

	global $all_lignes_local;
	if ($all_lignes_local==1)   //demande locale d'afficher tous
		$all_lignes=1;

	if (empty($page))
		$page=1;//page a afficher par defaut

	if (empty($popup))
		$popup=0;//on n'affiche pas de radios ni de case a cocher, par defaut
	$resultat_sql=execute_sql($req);
	erreur_sql($resultat_sql,$req);
	$tmp_table = explode('from',$req);
	$tmp_table = explode(' ',$tmp_table[1]);
	$tmp_table = explode(',',$tmp_table[1]);
	$table=$tmp_table[0];
	
	$count=mysqli_num_rows($resultat_sql);

	if ($count==0){
		echo "<b>Aucun enregistrement !</b>\n";
		if (mb_strstr($mod, 'I')){
			echo "<script language=javascript>\n";
			echo "   function inserer_$table(){\n";
			// si la table est une relation a 2 pattes
			if ((isset($table_2nan))&&(!empty($table_2nan)))
				echo "            document.forms[0].action='".$table_2nan."_ins.php';\n";
			else
				echo "            document.forms[0].action='".$table."_ins.php';\n";
			echo "            document.forms[0].submit();\n";
			echo "   }\n";
			echo "</script>\n";
			echo "<a href=javascript:inserer_$table();>$inserer_moteur <img border=0 src=\"images/add.png\" ALT=\"Nouvel enregistrement\"></a>\n";
		}
		if ((($popup==1)||($popup==2))&&($affiche_popup!=0)){
			echo "<br /><center><a href=javascript:window.close();>$fermeture</a></center>\n";
		}
	}
	else {
		if (empty($nbLig))
			$nbLig=5;// on choisit le nbre de lignes a afficher par defaut
		if (empty($ecart_page))
			$ecart_page=2;// on choisit le nbre de page a afficher par defaut
		// calcule le nombre de pages a afficher
		if ($count%$nbLig==0){
			$nombre_pages=(int)($count/$nbLig);
		}else{
			$nombre_pages=(int)($count/$nbLig+1);
		}
		//affiche un formulaire pour valider la suppression Maj et insertion
		echo "\n<form name=$table method=post>\n";
		echo "<script language=javascript>\n";
		echo "function supprimer_$table(num){\n";
		echo "   var poursuivre = confirm('Voulez-vous supprimer cet enregistrement ?');\n";
		echo "   if (poursuivre == true){\n";
		echo "      if(isNaN(num)){\n";
		if ((isset($table_2nan))&&(!empty($table_2nan)))
			echo '         document.'.$table.'.action="'.$table_2nan.'_del.php?"+num;'."\n";    //chaine de caractere
		else
			echo '         document.'.$table.'.action="'.$table.'_del.php?"+num;'."\n";    //chaine de caractere
		echo "      }\n";
		echo "      else{\n";
		if ((isset($table_2nan))&&(!empty($table_2nan)))
			echo '         document.'.$table.'.action="'.$table_2nan.'_del.php?id_sup="+num;'."\n";  // passage de l'id numerique
		else
			echo '         document.'.$table.'.action="'.$table.'_del.php?id_sup="+num;'."\n";  // passage de l'id numerique

		echo "      }\n";
		echo '      document.'.$table.'.submit();'."\n";
		echo "   }\n";
		echo "}\n";


		echo "function maj_$table(num){\n";
		echo "   if(isNaN(num)){\n";
		echo '      document.'.$table.'.action="'.$table.'_edit.php?"+num;'."\n";    //chaine de caractere
		echo "   }\n";
		echo "   else{\n";
		echo '      document.'.$table.'.action="'.$table.'_edit.php?id="+num;'."\n";  // passage de l'id numerique
		echo "   }\n";
		echo '   document.'.$table.'.submit();'."\n";
		echo "}\n";
		echo "function view_$table(num){\n";
		echo "   if(isNaN(num)){\n";
		echo '      OuvrirFen("'.$table.'_view.php?"+num,720,500);'."\n";    //chaine de caractere
		echo "   }\n";
		echo "   else{\n";
		echo '      OuvrirFen("'.$table.'_view.php?id="+num,720,500);'."\n";    //chaine de caractere
		echo "   }\n";
		echo "}\n";
		echo "</script>\n";
		echo "<input type=hidden name=pour_netscape>\n";
		echo "</form>\n";
		//affiche la liste de liens

		if ($all_lignes==0)
			echo "<P>[$count enregistrement(s) / $nombre_pages page(s)]\n";
		if ($all_lignes==1)
			echo "<P>[$count enregistrement(s)]\n";
		if (mb_strstr($mod, 'I')){

			echo "<script language=javascript>\n";
			echo "   function inserer_$table(){\n";
			// si la table est une relation a 2 pattes
			if ((isset($table_2nan))&&(!empty($table_2nan)))
				echo "            document.forms[0].action='".$table_2nan."_ins.php';\n";
			else
				echo "            document.forms[0].action='".$table."_ins.php';\n";
			echo "            document.forms[0].submit();\n";
			echo "   }\n";
			echo "</script>\n";
			echo "<a href=javascript:inserer_$table();>$inserer_moteur <img border=0 src=\"images/add.png\" ALT=\"Nouvel enregistrement\"></a>\n";
		}

		echo "<script language=javascript>\n";
		echo "   tab_cbx=new Array();\n";
		global $PHP_SELF;
		echo "   function passer_page(num){\n";
		echo "      if (document.forms[0].id)\n";
		echo "         document.forms[0].action='".$PHP_SELF."'+'?page='+num+'&id='+document.forms[0].id.value+'&ascdesc=".$ascdesc."';\n";
		echo "      else\n";
		echo "         document.forms[0].action='".$PHP_SELF."'+'?page='+num+'&ascdesc=".$ascdesc."';\n";
		echo "      document.forms[0].submit();\n";
		echo "   }\n";

		echo "   function passer_toutes_page(){\n";
		echo "       document.forms[0].action='".$PHP_SELF."'+'?all_lignes_local=1&ascdesc=".$ascdesc."';\n";
		echo "       document.forms[0].submit();\n";
		echo "   }\n";

		echo "   function Reporter_radio(r) {\n";
		echo "      if (window.opener.document.forms[0].elements['".$name_ID."'].type=='text'){\n";
		echo "         selection=r.value+'|'+document.formpopup.elements['LIB_'+r.value].value;\n";
		echo "         window.opener.document.forms[0].elements['".$name_ID."'].value=selection;\n";
		echo "      }\n";
		echo "      else{\n";
		echo "           longueur=window.opener.document.forms[0].elements['".$name_ID."'].options.length;\n";
		echo "           for(var i=0;i<longueur;i++){\n";
		echo "              if (window.opener.document.forms[0].elements['".$name_ID."'].options[i].value==r.value){\n";
		echo "                 window.opener.document.forms[0].elements['".$name_ID."'].options[i].selected=true;\n";
		echo "              }\n";
		echo "           }\n";
		echo "       }\n";
		echo "       window.close();\n";
		echo "   }\n";
		$nom_liste=$name_ID."[]";
		echo "   function Reporter_checkbox(r) {\n";
		echo "      if (window.opener.document.forms[0].elements['".$nom_liste."'].type=='select-multiple'){\n";
		echo "         longueur=window.opener.document.forms[0].elements['".$nom_liste."'].options.length;\n";
		echo "         if (r.checked==true) {\n";
		echo "            for(var i=0;i<longueur;i++){\n";
		echo "               if (window.opener.document.forms[0].elements['".$nom_liste."'].options[i].value==r.value){\n";
		echo "                  window.opener.document.forms[0].elements['".$nom_liste."'].options[i].selected=true;\n";
		echo "               }\n";
		echo "           }\n";
		echo "         }\n";
		echo "         else{\n";
		echo "            for(var i=0;i<longueur;i++){\n";
		echo "               if (window.opener.document.forms[0].elements['".$nom_liste."'].options[i].value==r.value){\n";
		echo "                  window.opener.document.forms[0].elements['".$nom_liste."'].options[i].selected=false;\n";
		echo "               }\n";
		echo "            }\n";
		echo "         }\n";
		echo "      }\n";
		echo "      if (window.opener.document.forms[0].elements['".$nom_liste."'].type=='textarea'){\n";    // si textarea
		echo "         if (r.checked==true){\n";
		echo "            tab_cbx[tab_cbx.length]=r.value+'|'+document.formpopup.elements['LIB_'+r.value].value;\n";
		echo "         }\n";
		echo "         else{\n";
		echo "            for(var i=0;i<tab_cbx.length;i++){\n";
		echo "               fin=tab_cbx[i].indexOf('|',0);\n";



		echo "               if (r.value==tab_cbx[i].substring(0,fin)) {\n";
		echo "                  tab_cbx.splice(i,1);\n";
		echo "               }\n";
		echo "            }\n";
		echo "         }\n";
		echo "         window.opener.document.forms[0].elements['".$nom_liste."'].value=tab_cbx.join('\\n')\n";
		echo "      }\n";
		echo "   }\n";
		echo "   function Init_checkbox(){\n";
		echo "      if (window.opener.document.forms[0].elements['".$nom_liste."'].type=='select-multiple'){\n";
		echo "         longueur_opener=window.opener.document.forms[0].elements['".$nom_liste."'].options.length;\n";
		echo "         longueur_formpopup=window.document.formpopup.choix.length;\n";
		echo "         for(var i=0;i<longueur_formpopup;i++){\n";
		echo "            for(var j=0;j<longueur_opener;j++){\n";
		echo "               if ((window.opener.document.forms[0].elements['".$nom_liste."'].options[j].value==window.document.formpopup.choix[i].value)&&(window.opener.document.forms[0].elements['".$name_ID."[]'].options[j].selected==true)){\n";
		echo "                  window.document.formpopup.choix[i].checked=true;\n";
		echo "               }\n";
		echo "            }\n";
		echo "         }\n";
		echo "      }\n";
		echo "      else{\n";  // si textarea
		echo "         if (window.opener.document.forms[0].elements['".$nom_liste."'].value!='')\n";
		echo "            tab_cbx=window.opener.document.forms[0].elements['".$nom_liste."'].value.split('\\n');\n";
		echo "            longueur_formpopup=window.document.formpopup.choix.length;\n";
		echo "            if (longueur_formpopup==undefined){\n";
		echo "               if (tab_cbx.length!=0)\n";
		echo "                  window.document.formpopup.choix.checked=true;\n";
		echo "               return;\n";
		echo "            }\n";
		echo "            for(var j=0;j<longueur_formpopup;j++){\n";
		echo "               for(var i=0;i<tab_cbx.length;i++){\n";
		echo "                  fin=tab_cbx[i].indexOf('|',0);\n";
		echo "                  if (window.document.formpopup.choix[j].value==tab_cbx[i].substring(0,fin)) {\n";
		echo "                     window.document.formpopup.choix[j].checked=true;\n";
		echo "                  }\n";
		echo "               }\n";
		echo "            }\n";
		echo "      }\n";
		echo "   }\n";
	
	echo "   function maj_ordre(){\n";
		echo "      document.forms['formpopup'].action='maj_ordre.php';\n";
		echo "      document.forms['formpopup'].submit();\n";
		echo "   }\n";

	
		echo "</script>\n";

		if ($all_lignes==0) { // si on affiche les enregistrements page par page
			echo "<br />Pages : ";
			$min=$page-$ecart_page;
			if ($min<1)
				$min=1;
			if ($min>1) { // n'affiche ce lien que si la page n'est pas affichee
			echo "<a href='javascript:passer_page(1)'>&lt;&lt;</a>&nbsp;";
			}
			$max=$page+$ecart_page;
			if ($max>$nombre_pages)
				$max=$nombre_pages;
			for ($i=$min;$i<=$max;$i++){
				if ($page==$i)
					echo "<b>$i&nbsp;</b>";
				else
				echo "<a href='javascript:passer_page($i)'>$i</a>&nbsp;";
			}
			if ($max<$nombre_pages){ // n'affiche ce lien que si la page du nombre total de page n'est pas affichee
			echo "&nbsp;<a href='javascript:passer_page($nombre_pages)'>&gt;&gt;</a>";
			}
			global $lister_tous;
			if ($nombre_pages>1)
				echo "&nbsp;<a href='javascript:passer_toutes_page()'>$lister_tous</a>";
		}


		echo "</p>";

		//affiche un formulaire pour afficher les options et cases a cocher dans les popup
		echo "\n<form name=formpopup method=post>\n";
		//affiche le resultat de la requete
		echo "<table border=0>\n";

		if ($mod_tabulaire==0){
			echo "<tr>\n";
			if ((($popup==1)||($popup==2))&&($affiche_popup!=0)){
				//Ne pas afficher de titres de colonne
				//echo "<th colspan=3>&nbsp;</th>";
			}
			elseif (isset($tab_affichage)&&(!empty($resultats))){
				for ($i = 0; $i < count($tab_affichage); $i++) {
					$num=$tab_affichage[$i];
					echo "<th>".tronquer_taille($label[$num],50)."</th>";
				}
			}
			elseif (empty($resultats)){
				for ($i = 1; $i < mysqli_num_fields($resultat_sql); $i++) {
					echo "<th>".tronquer_taille(ucfirst(mb_strtolower(db_field_direct_name($resultat_sql,$i))),50)."</th>";
				}
			}
			echo "</tr>\n";
		}

		if ($all_lignes==0)
			$max_ligne=$nbLig*$page;
		if ($all_lignes==1)
			$max_ligne=$count;

		for ($i = 0; $i < $max_ligne; $i++) {
			$row_array = mysqli_fetch_row($resultat_sql);

			if ($all_lignes==1)  //on affiche tout dans la page
				$debut=0;
			else
				$debut=($nbLig*($page-1));

			if (($i >= $debut)&&($row_array)){
				if ($mod_tabulaire==0){
					if ($i%2==0)
						echo "<tr class=lig0>\n";
					else
						echo "<tr class=lig1>\n";
				}
				$autre_colonne='';
				if (!empty($row_array[3])){	
					$autre_colonne=' '.$row_array[3];
				}
				if (($popup==1)&&($affiche_popup!=0))
					echo "<td><input type=hidden name=LIB_$row_array[0] value=\"".strip_tags($row_array[2]).$autre_colonne."\"><input type=RADIO name=choix value=$row_array[0] onClick=Reporter_radio(this)></td>";
				if (($popup==2)&&($affiche_popup!=0))
					echo "<td><input type=hidden name=LIB_$row_array[0] value=\"".strip_tags($row_array[2]).$autre_colonne."\"><input type=CHECKBOX name=choix value=$row_array[0] onClick=Reporter_checkbox(this)></td>";
				$depart=1;
				if ((isset($colonnes_2nan))&&(!empty($colonnes_2nan)))
					$depart=2;
				for ($j=$depart; $j < mysqli_num_fields($resultat_sql); $j++) {
					$type  = db_field_direct_type($resultat_sql, $j);
					if ($mod_tabulaire==0)
						echo "<td>";
					else{
						echo "<tr><td>";
						if ($j==1)
							echo "<b>";
					}
                                        $z = num_col_depuis_nom($tab_colonnes,db_field_direct_name($resultat_sql,$j));

					if (mb_stristr($type,'date')){
						echo date_to_fr($row_array[$j]);
					}
					// si photo mettre une vignette
					elseif (isset($photos)&&in_array($z,$photos)){
                                            $nom_col  = db_field_direct_name($resultat_sql, $j);
                                            echo "<img src=\"$rep/$table-$row_array[0]-$nom_col-$row_array[$j]\" class=\"output_image_rech\"/>";
					}					
					else {
						if (!empty($pk_table[db_field_direct_name($resultat_sql,$j)])) {
							list($nom_table_pk,$nom_col_pk)=explode(".",$pk_table[db_field_direct_name($resultat_sql,$j)]);
// MdB Gestion des cles etrangeres
							if ($z>=0){
								if (!empty($req_fk[$z])){
									if (mb_stristr($req_fk[$z],'where')){
										$requete_tab=explode('order',$req_fk[$z]);
										$requete= $requete_tab[0]." and ".$nom_col_pk."='$row_array[$j]'";
									}
									else{
										$requete_tab=explode('order',$req_fk[$z]);
										$requete= $requete_tab[0]." where ".$nom_col_pk."='$row_array[$j]'";
									}
								}
								else {
									$requete="select * from ".$nom_table_pk." where ".$nom_col_pk."='$row_array[$j]'";
								}
								echo lister_col_num_lib($requete,$cols2[$z]);
							}
							else
								echo 'Colonne inconnue';

						}
						else { // MDB 20/08/2010 Gestion de l'ordre d'affichage des coordonnees pour un service
				
							if ((!empty($id_service))&&(db_field_direct_name($resultat_sql,$j)=='ordre_coordonnee')) {
								echo "<input name=ordre_affichage[] type=text value=\"".$row_array[$j]."\" size=3>";		
								echo "<input name=id_affichage[] type=hidden value=\"".$row_array[0]."\" size=3>";								
							}
							elseif ((!empty($id_pole))&&(db_field_direct_name($resultat_sql,$j)=='ordre_service')) {
								echo "<input name=ordre_affichage[] type=text value=\"".$row_array[$j]."\" size=3>";		
								echo "<input name=id_affichage[] type=hidden value=\"".$row_array[0]."\" size=3>";								
							}
							else
								echo tronquer($row_array[$j]);	
						}
					}
					if ($mod_tabulaire==0)
						echo "</td>";
					else{
						if ($j==1)
							echo "</b>";
						echo "</td></tr>";
					}
				}
				if ($mod_tabulaire==1)
						echo "<tr><td>\n";

				// si la table est une relation a 2 pattes
				if ((isset($colonnes_2nan))&&(!empty($colonnes_2nan))){
					reset($colonnes_2nan);
					$parametres="";
					while(list($num_col,$nom_col)=each($colonnes_2nan)){
						if (empty($parametres)){
							$parametres=$nom_col.'='.$row_array[$num_col];
						}
						else{
							$parametres=$parametres.'&'.$nom_col.'='.$row_array[$num_col];
						}
					}
				}

				// si la table est une relation a + de 2 pattes
				/*
				if ((isset($colonnes_nan))&&(!empty($colonnes_nan))){
					reset($colonnes_nan);
					$parametres="";
					while(list($num_col,$nom_col)=each($colonnes_nan)){
						if (empty($parametres)){
							$parametres=$nom_col.'='.$row_array[$num_col+1];
						}
						else{
							$parametres=$parametres.'&'.$nom_col.'='.$row_array[$num_col+1];
						}
					}
				}
				*/

				if (mb_strstr($mod, 'V')){
					if ($mod_tabulaire==0)
						echo "<td>\n";
					if ((isset($colonnes_nan))&&(!empty($colonnes_nan)))
						echo "<a href=javascript:view_$table('".$parametres.'\')><img border=0 src="images/eye.png" ALT="Detailler"></a>';
					else
						echo "<a href=javascript:view_$table(".$row_array[0].')><img border=0 src="images/eye.png" ALT="Detailler"></a>';
					if ($mod_tabulaire==0)
						echo "</td>\n";
				}

				if (mb_strstr($mod, 'W')){
					if ($mod_tabulaire==0)
						echo "<td>\n";
					if ((isset($colonnes_nan))&&(!empty($colonnes_nan)))
						echo "<a href=".$table."_workflow_edit.php?id=".$parametres.' target="_blank"><img border=0 src="images/b_tbloptimize.png" ALT="Fiche"></a>';
					else
						echo "<a href=".$table."_workflow_edit.php?id=".$row_array[0].' target="_blank"><img border=0 src="images/b_tbloptimize.png" ALT="Fiche"></a>';
					if ($mod_tabulaire==0)
						echo "</td>\n";
				}

				if (mb_strstr($mod, 'M')){
					if ($mod_tabulaire==0)
						echo "<td>\n";
					else
						echo "&nbsp;";
					if ((isset($colonnes_nan))&&(!empty($colonnes_nan)))
						echo "<a href=javascript:maj_$table('".$parametres.'\')><img border=0 src="images/b_edit.png" ALT="Modifier"></a>';
					else
						echo "<a href=javascript:maj_$table(".$row_array[0].')><img border=0 src="images/b_edit.png" ALT="Modifier"></a>';
					if ($mod_tabulaire==0)
						echo "</td>\n";
				}

				if (mb_strstr($mod, 'D')){
					if ($mod_tabulaire==0)
						echo "<td>\n";
					else
						echo "&nbsp;";
					if ((isset($colonnes_nan))&&(!empty($colonnes_nan)))
						echo '<a href=javascript:supprimer_'.$table.'(\''.$parametres.'\')><img border=0 src="images/b_drop.png"  ALT="Supprimer"></a>';
					elseif ((isset($colonnes_2nan))&&(!empty($colonnes_2nan)))
						echo '<a href=javascript:supprimer_'.$table.'(\''.$parametres.'\')><img border=0 src="images/b_drop.png"  ALT="Supprimer"></a>';
					else
						echo '<a href=javascript:supprimer_'.$table.'('.$row_array[0].')><img border=0 src="images/b_drop.png"  ALT="Supprimer"></a>';
					if ($mod_tabulaire==0)
						echo "</td>\n";
				}
				if (is_array($CIF)){
					if ($mod_tabulaire==0)
						echo "<td>\n";
					for ($j=0;$j<count($CIF);$j++){
						list($nom_table,$nom_col)=explode(".",$CIF[$j]);
						echo " <a href=$nom_table"."_rech.php?$nom_col=".$row_array[0]."&lancer_rech=1>".ucfirst(mb_strtolower($nom_table))."</a> ";
					}
					if ($mod_tabulaire==0)
						echo "</td>\n";
				}
				elseif (isset($CIF)&&!empty($CIF)){
					if ($mod_tabulaire==0)
						echo "<td>\n";
					list($nom_table,$nom_col)=explode(".",$CIF);
					echo " <a href=$nom_table"."_rech.php?$nom_col=".$row_array[0]."&lancer_rech=1>".ucfirst(mb_strtolower($nom_table))."</a> ";
					if ($mod_tabulaire==0)
						echo "</td>\n";
				}


				if ($mod_tabulaire==1)
						echo "</td>\n";
				echo "</tr>\n";
				if ($mod_tabulaire==1)
						echo "<tr><td>&nbsp;</td></tr>\n";
			}
		}
		echo "</table>\n";
		if (($popup==2)&&($affiche_popup!=0)){
			echo "<script language=Javascript>\n";
			echo "Init_checkbox();\n";
			echo "</script>\n";
		}
		if ((($popup==1)||($popup==2))&&($affiche_popup!=0)){
			echo "<center><a href=javascript:window.close();>$fermeture</a></center>\n";
		}

	// MDB 20/08/2010 Gestion de l'ordre d'affichage des coordonnees pour un service
	if (!empty($id_service)) {
		echo "<input type=hidden name=id_service value=".$id_service.">";
		echo "<input type=button onclick=maj_ordre() value=\"Mise a jour de l'ordre d'affichage\">";
	}
	elseif (!empty($id_pole)) {
		echo "<input type=hidden name=id_pole value=".$id_pole.">";
		echo "<input type=button onclick=maj_ordre() value=\"Mise a jour de l'ordre d'affichage\">";
	}
		echo "</form>\n";
	}
	return $resultat_sql;
}


function mail_encodage($to,$subject,$message,$type){
	/*
	Type : type de message à envoyer :
	- modifier : lien pour une mise à jour
	- voir : lien pour une vue sur la fiche
	*/
	global $table;
	global $id;
	global $clause;
	global $encodage;
	global $messagerie;
	if (!empty($to)){
		$headers = "From: ne-pas-repondre@portail.prv\n" .
			"MIME-Version: 1.0\n" .
			"Content-Type: text/html; charset=$encodage\n" .
			"Content-Transfer-Encoding: 8bit\n";
		$pwd=generer_passwd();
		$url='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
		$rep_tab=explode('/',$_SERVER['SCRIPT_NAME']);
		$rep='';
		for ($k=1;$k<count($rep_tab)-1;$k++){			
			$rep.=$rep_tab[$k].'/';		
		}
		$tab_mail=explode(',',$to);
		for ($i=0;$i<count($tab_mail);$i++){
			if ($type=='modifier'){
				$message2 = $message."<br/>Vous pouvez traiter la demande en cliquant ici: ";
				$message2 = $message2.'<a target=_blank href='.$url.'/'.$rep.$table.'_workflow_edit.php?id='.$id.'&secumail='.$pwd.'>Traiter la demande</a>'."\n";
				$message2 = $message2.' <a target=_blank href='.$url.'/'.$rep.$table.'_vue.php?id='.$id.'&secumail='.$pwd.'>Voir la demande</a>'."\n";
			}
			elseif ($type=='voir'){
				$message2 = $message."<br/>Vous pouvez consulter la demande en cliquant ici: ";
				$message2 = $message.'<a target=_blank href='.$url.'/'.$rep.$table.'_vue.php?id='.$id.'&secumail='.$pwd.'>Voir la demande</a>'."\n";

			}
			$message2 .= "<br/>Cordialement.\n";
			
			// Gestion du mail
			// #####TEST a supprimer en prod #####
			if ($messagerie==1) {
			  mail($tab_mail[$i], $subject, $message2, $headers);
			}
			else {
			  echo "<br>mail(".$tab_mail[$i].", $subject, $message2, $headers)";
			}

		}
		if ($type=='modifier'){
			$req_modif = 'update '.$table.' set liste_validateurs="'.$pwd.'" where '.$clause;
			//echo $req_modif;
			execute_sql($req_modif);
		}
		//en modif ou lecture tous peuvent consulter
		$req_modif = 'update '.$table.' set liste_lecteurs=CONCAT(IFNULL(liste_lecteurs,""),"-","'.$pwd.'") where '.$clause;
		//echo $req_modif;
		execute_sql($req_modif);
	}
}




/***************** DB FUNCTIONS **********************/

function db_type2txt($type_id) {
    static $types;

    if (!isset($types)) {
        $types = array();
        $constants = get_defined_constants(true);
        foreach ($constants['mysqli'] as $c => $n) if (preg_match('/^MYSQLI_TYPE_(.*)/', $c, $m)) $types[$n] = $m[1];
    }

    return array_key_exists($type_id, $types)? $types[$type_id] : NULL;
}

function db_flags2txt($flags_num) {
    static $flags;

    if (!isset($flags)){
        $flags = array();
        $constants = get_defined_constants(true);
        foreach ($constants['mysqli'] as $c => $n) if (preg_match('/MYSQLI_(.*)_FLAG$/', $c, $m)) if (!array_key_exists($n, $flags)) $flags[$n] = $m[1];
    }

    $result = array();
    foreach ($flags as $n => $t) if ($flags_num & $n) $result[] = $t;
    return implode(' ', $result);
}
function db_field_direct_name($result, $i) {
    return mysqli_fetch_field_direct($result, $i)->name;
}
function db_field_direct_type($result, $i) {
    return db_type2txt(mysqli_fetch_field_direct($result, $i)->type);
}
function db_field_direct_len($result, $i) {
    global $encodage;
    global $type;
    global $flags;
    if (($encodage=="UTF-8")&&((db_type($type,$flags)=='string')||(db_type($type,$flags)=='blob'))){
        return mysqli_fetch_field_direct($result, $i)->length / 3;

    }
    else
        return mysqli_fetch_field_direct($result, $i)->length;
}
function db_field_direct_flags($result, $i) {
    return db_flags2txt(mysqli_fetch_field_direct($result, $i)->flags);
}
function db_type($type,$flags){

    if (($type=='DECIMAL')||($type=='FLOAT')||($type=='DOUBLE')||($type=='REAL')){
        return 'real';
    }
    elseif (($type=='SHORT')||($type=='LONG')||($type=='LONGLONG')||($type=='INT24')){
        return 'int';
    }
    elseif (($type=='STRING')&&(mb_stristr($flags, 'SET'))) {
        return 'set';
    }
    elseif (($type=='STRING')&&(mb_stristr($flags, 'ENUM'))) {
        return 'enum';
    }    
    elseif (($type=='CHAR')||($type=='VAR_STRING')||($type=='STRING')){
        return 'string';
    }
    elseif (($type=='TINY_BLOB')||($type=='MEDIUM_BLOB')||($type=='LONG_BLOB')||($type=='BLOB')){
        return 'blob';
    }
    elseif (($type=='DATE')||($type=='NEWDATE')||($type=='LONG_BLOB')||($type=='BLOB')){
        return 'date';
    }
    elseif ($type=='SET'){
        return 'set';
    }
    
}
?>
