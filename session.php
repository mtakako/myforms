<?php
define ("INACTIF_MAXI",10800);
session_start();

/*****EN TEST PAS DE SESSION *****/
   $_SESSION['temps']=time();
/*********************************/


/* Demarrage de la session */
if (isset($_SESSION['temps'])){
   if ((time()-$_SESSION['temps']) > INACTIF_MAXI){
      echo "<p><font color=red size=4><b>Duree de session depasse !";
      echo "Ouvrir cette page depuis le portail";

      echo time()-$_SESSION['temps']." secondes";
      session_destroy();
      exit();
   }
   $_SESSION['temps']=time();
}
else {
	echo "Ouvrir cette page depuis le portail";
	exit;
}
?>
