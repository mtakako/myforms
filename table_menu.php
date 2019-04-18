<html>
<head>
<?php
include_once("var.inc.php");
include_once("encodage.inc.php");
?>
</head>
<?php
include_once("functions.inc.php");
include_once ("stylef.php");
?>
<body bgcolor="#ffcc99">
<form action=gen_menu.php method=post>
<h2>Selectionnez les tables qui seront dans votre menu :</h2>


<?php

$con=mysqli_connect($host, $user, $password);
mysqli_select_db($con,$_POST['database']);

$req= "SHOW TABLES";
$res=mysqli_query($con,$req);



while ($row = mysqli_fetch_row($res)) {
   echo "<input type=checkbox name=tables[] value='$row[0]'>$row[0] <br>";
}

?>
<br><hr>
<input type=submit value="Generer le fichier menu !">
</form>
</body>
</html>