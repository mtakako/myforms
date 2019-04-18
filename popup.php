<meta http-equiv="X-UA-Compatible" content="IE=8" />
<?php
//Inclusion de la page entete qui inclue les variables et les fonctions.
include("entete.php");
include($table_encours."_parametres.php");
if (!empty($mode_affichage_popup)) $affiche_popup=$mode_affichage_popup;

?>
<title>popup <?php echo $table?></title>
<script language="javascript" src="scripts.js"></script>
<?php
include_once("style.php");
include_once("functions.inc.php");
?>
<?php
if (empty($_GET['page'])){
	echo '<script type="text/javascript">';
        echo 'window.moveTo(500,100);';
	echo '</script>';
}
?>

</head>
<body>
<div class="chmformulaire">
<!-- Formulaire de saisie des critères de recherche-->
<form name="recherche" action=<?php echo $_SERVER['PHP_SELF'];?> method="post">
<table>
<?php if (!isset($identifiant)) $identifiant="";?>
<tr><td><input type=text onkeypress="if (event.keyCode == 13) document.recherche.submit()" size=8 maxlength=100 name=identifiant value="<?php echo $identifiant?>"></td>
<?php if (!isset($libelle)) $libelle="";?>
<td><input type=text onkeypress="if (event.keyCode == 13) document.recherche.submit()" size=20 maxlength=200 name=libelle value="<?php echo $libelle?>"></tr>
</table>
<script language=javascript>
function raz(){
	document.recherche.identifiant.value="";
	document.recherche.libelle.value="";
}</script>
<center><a href=javascript:document.recherche.submit();><?php echo $rechercher;?></a>&nbsp;<a href=javascript:raz();><?php echo $reset;?></a>&nbsp;</center>

<input type="hidden" name="bdd" value="<?php echo $bdd?>">
<input type="hidden" name="nom_col2" value="<?php echo $nom_col2?>">
<input type="hidden" name="nom_col1" value="<?php echo $nom_col1?>">
<input type="hidden" name="table" value="<?php echo $table?>">
<input type="hidden" name="mode" value="<?php echo $mode?>">
<input type="hidden" name="nom_objet" value="<?php echo $nom_objet?>">
<input type="hidden" name="clause" value="<?php echo $clause?>">
<input type="hidden" name="table_encours" value="<?php echo $table_encours?>">
<input type="hidden" name="autre_colonne" value="<?php echo $autre_colonne?>">
</form>

<?php
$connexion=connexion($bdd);

//Création dynamique de la requete SQL en fonction des critères de recherche
if (!empty($libelle))
   if ($clause=="")
      $clause = "where $nom_col2 like '%$libelle%'";
   else
      $clause = "$clause and $nom_col2 like '%$libelle%'";

if (!empty($identifiant))
   if ($clause=="")
      $clause = "where $nom_col1=$identifiant";
   else
      $clause = "$clause and $nom_col1=$identifiant";

$req= "select * from $table $clause";
$resultat_sql=execute_sql($req);
$row=mysqli_fetch_row($resultat_sql);
$col2=$nom_col2;
if (empty($nom_col2)){
	$nbre_col=mysqli_num_fields($resultat_sql);
	$i=1;
	while (is_numeric($row[$i])&&($i<=$nbre_col)){
		$i++;
	}
	if ($i>$nbre_col)
		$col2=$col2;
	else
		$col2=db_field_direct_name($resultat_sql,$i);
}
if (!empty($autre_colonne)){
	$query= "select $nom_col1,$nom_col1,$col2,$autre_colonne from $table $clause order by 3";
}
else{
	$query= "select $nom_col1,$nom_col1,$col2 from $table $clause order by 3";
}
$pk_table="";

$nbLig=10;
$result = execute_select($query,0,0,$nom_objet,$pk_table,$mode,0,0);
?>
</div>
</body>
</html>
