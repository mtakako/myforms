<html>
<head>
<title>MyForms</title>
<?php
include_once("var.inc.php");
include_once("functions.inc.php");
include_once("encodage.inc.php");
include_once("stylef.php");
date_default_timezone_set('Europe/Paris');
?>

<script type="text/javascript">
function tables(){
   document.formulaire.action="table.php";
   document.formulaire.submit();
}
function menu(){
   document.formulaire.action="table_menu.php";
   document.formulaire.submit();
}
function parametres(){
   document.formulaire.action="var_read.php";
   document.formulaire.submit();
}
</script>
</head>
<body>
<form name="formulaire" method="post">
<div align="center"><h1>Gestion de formulaire</h1></div>
<br />
<h2>Choisir la base pour laquelle vous allez travailler</h2>
<select name="database" size="1">
<?php
   $connection=mysqli_connect($host, $user, $password);
   $sql = "SHOW DATABASES";
   $result = mysqli_query($connection, $sql);
   while ($row=mysqli_fetch_array($result)) {
      echo "<option value=\"$row[0]\">".$row[0]."</option>";
   }
?>
</select>&nbsp;
<a href="aide.php">Aide</a>
<br /><hr />
<input type="button" value="Modifier la configuration" onClick="parametres()"><br /><br />
<input type="button" value="Gestion des tables" onClick="tables()"><br /><br />
<input type="button" value="Gestion du menu" onClick="menu()"><br /><br />
</form>
</body>
</html>
