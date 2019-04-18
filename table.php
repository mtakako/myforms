<?php
include_once("var.inc.php");
include_once("functions.inc.php");
?>
<html>
<head>
<title>MyForms</title>
<?php
include_once("encodage.inc.php");
include_once("stylef.php");
date_default_timezone_set('Europe/Paris');
?>
<script>
function valider_forms(){
	document.forms[0].action="colonne.php?simple=1";
	document.forms[0].submit();
}
function valider_workflow(){
	document.forms[0].action="gen_diag.php";
	document.forms[0].submit();
}
</script>
</head>
<body>

<form method="post">
<input type="hidden" name="database" value="<?php echo $_POST['database']?>">
<h2>Choix de la table :</h2>
<?php
   $con=mysqli_connect($host, $user, $password);
   mysqli_select_db($con,$_POST['database']);
   
   $req= "SHOW TABLES";
   $res=mysqli_query($con,$req);

   while ($row = mysqli_fetch_row($res)) {
      echo "<input type=\"radio\" name=\"table\" value=\"$row[0]\">$row[0]<br />";
   }
?>
<br /><hr />
<input type="button" onclick="valider_forms()" value="Gestion de Formulaire simple">
<input type="button" onclick="valider_workflow()" value="Gestion de Formulaire avec Workflow">
</form>
</body>
</html>
