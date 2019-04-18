<?php
//fichier en latin1
/* BASE encodagelatin1

CREATE TABLE IF NOT EXISTS `essailatin1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
INSERT INTO `essailatin1` (`id`, `desc`) VALUES
(1, 'rémy')
*/



// Affichage de l encodage par defaut de PHP
//mb_internal_encoding('UTF-8');
echo 'Encodage PHP : '.mb_internal_encoding().'<br />';
echo "déjà : mb_strlen doit afficher une longeur de 4 : ".mb_strlen("déjà")." et strlen : ".mb_strlen("déjà").'<br>';


//TEST AVEC BDD

$user="mdb";
$password="m1sevmeted.b";
$host="localhost";
$encodage_bdd="ISO-8859-1";
echo "Encodage BDD : ".$encodage_bdd.'<br>';

$bdd="encodagelatin1";

// connexion au serveur
	$connexion=mysqli_connect($host,$user,$password) or die("erreur de connexion au serveur $host");
	mysqli_select_db($bdd) or die("erreur de connexion a la base de donnees $bdd");
	mysqli_set_charset($encodage_bdd,$connexion);
	
	$req="select * from essailatin1";
	$res=mysqli_query($req);
	$row=mysqli_fetch_row($res);
	echo $row[1].' : mb_strlen '.mb_strlen($row[1]).' : strlen '.mb_strlen($row[1]);

?>
