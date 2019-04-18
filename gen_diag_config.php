<?php
include_once("var.inc.php");
include_once("encodage.inc.php");
?>

<?php
include_once("functions.inc.php");
?>

<?php
$filename = $_POST['table'].".json";
if (!empty($_POST["myforms_workflow"])){
	$fp = fopen($filename, 'w');
	if(get_magic_quotes_gpc())
        	$_POST["myforms_workflow"]=stripslashes($_POST["myforms_workflow"]);

	fwrite_encode($fp, $_POST["myforms_workflow"]);
	fclose($fp);
}

$filename_diag = $_POST['table']."_diag.php";
if (!empty($_POST["myforms_workflow"])){
	$fp = fopen($filename_diag, 'w');
	fwrite_encode($fp, "<?php\n" );
	fwrite_encode($fp, '$lesetapes=array();'."\n");
	fwrite_encode($fp, '$lesetats=array();'."\n");
	fwrite_encode($fp, '$tabetats=array();'."\n");
	fwrite_encode($fp, '$tabetatstache=array();'."\n");
	$tmp_tab=explode('|',$_POST["lesetapes"]);
	foreach ($tmp_tab as $key => $value) {
		fwrite_encode($fp,'$lesetapes[]="'.$value.'";'."\n");
	}
	$tmp_tab=explode('|',$_POST["lesetats"]);
	foreach ($tmp_tab as $key => $value) {
		fwrite_encode($fp,'$lesetats[]="'.$value.'";'."\n");
	}
	$tmp_tab=explode('|',$_POST["tabetats"]);
	foreach ($tmp_tab as $key => $value) {
		$tab_valeur=explode('=>',$value);
		$indice=array_shift($tab_valeur);
		fwrite_encode($fp,'$tabetats["'.$indice.'"]="'.implode('|',$tab_valeur).'";'."\n");
		
	}
	$tmp_tab=explode('|',$_POST["tabetatstache"]);
	foreach ($tmp_tab as $key => $value) {
		$tab_valeur=explode('=>',$value);
		$indice=array_shift($tab_valeur);
		fwrite_encode($fp,'$tabetatstache["'.$indice.'"]="'.implode('|',$tab_valeur).'";'."\n");
		
	}



	fwrite_encode($fp, "?>\n" );
	fclose($fp);
}

?>

