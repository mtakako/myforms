<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $encodage?>; Cache-Control: no-cache">
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="-1" />
<meta charset="<?php echo $encodage?>">
<?php
// Gestion de l encodage par defaut de PHP
//mb_internal_encoding('UTF-8');
//mb_internal_encoding('ISO-8859-1');
mb_internal_encoding($encodage);
//echo 'Encodage actuel : '.mb_internal_encoding().'<br />';
//echo "déjà : mb_strlen doit afficher une longeur de 4 : ".mb_strlen("déjà")." et strlen : ".strlen("déjà").'<br>';
?>