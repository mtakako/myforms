<?php
$ret_session=execute_sql($req);
$row_session = mysqli_fetch_array($ret_session);
if ((mb_stristr($_SERVER["SCRIPT_NAME"], 'workflow_ins.php') === FALSE) &&
(mb_stristr($_SERVER["SCRIPT_NAME"], 'workflow_edit.php') === FALSE) &&(mb_stristr($_SERVER["HTTP_REFERER"], '_rech.php') === FALSE))

{

// on n est pas dans workflow_ins.php, ni dans workflow_edit.php et l'appelant n'est pas un _rech.php

        if ((empty($secumail)) && (empty($to))) {
                echo "Ceci n'est pas un appel depuis un mail de validateur.";
                exit;
        }
        if((mb_stristr($row_session['liste_lecteurs'], $secumail) === FALSE)&& (mb_stristr($row_session['liste_lecteurs'], $to) === FALSE)) {
                echo "Appel de cette page depuis une url non authorisee.<br/>";
                exit;
        }
}
?>
