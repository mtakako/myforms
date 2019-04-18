<?php
$ret_session=execute_sql($req);
$row_session = mysqli_fetch_array($ret_session);

if (mb_stristr($_SERVER["HTTP_REFERER"], '_rech.php') === FALSE){
// si ce n'est pas un appel depuis la page de recherche
        // si le param $to est vide => pas un appel de validateur ou de demandeur
        if ((empty($secumail)) && (empty($to))) {
                echo "Ceci n'est pas un appel depuis un mail de validateur.";
                exit;
        }
        if((mb_stristr($row_session['liste_validateurs'], $secumail) === FALSE)&& (mb_stristr($row_session['liste_validateurs'], $to) === FALSE)) {
                echo "Validateur inconnu au niveau actuel de la fiche. Vous ne pouvez pas modifier la fiche.<br/>";
                exit;
        }
}
?>
