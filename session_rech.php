<?php
define ("INACTIF_MAXI",3200);
session_start();

/*
if ((!mb_stristr($_SERVER["HTTP_REFERER"], 'http://portail/') === FALSE) || (!mb_stristr($_SERVER["HTTP_REFERER"], 'http://localhost') === FALSE)) {
   $_SESSION['temps']=time(); //premiere entree en session depuis Intranet
}
elseif (isset($_SESSION['temps'])){
   if ((time()-$_SESSION['temps']) > INACTIF_MAXI){
      echo "<p><font color=red size=4><b>Durée de session dépassé ! ";
      echo "Ouvrir une session depuis le portail.";
      //echo time()-$_SESSION['temps']." secondes";
      session_destroy();
      exit();
   }
   $_SESSION['temps']=time();
}
else {
      echo "Ouvrir une session depuis le portail.";
      session_destroy();
      exit();
}
*/
$_SESSION['temps']=time();

/************ PHP5 VAR GLOBALS *****/
$PHP_SELF=$_SERVER['PHP_SELF'];
extract($_GET, EXTR_SKIP);
extract($_POST, EXTR_SKIP);
?>
