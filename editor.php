<?php
/**************************************************************************************************
Nom du programme : contrat_rech.php
Nom de la table gérée : contrat
Date de génération du programme :  17/10/2002
Heure de génération du programme : 00:46:02
Copyright : Ce script a été généré par PhpPro VERSION 3.2 , Générateur de logiciel en PHP. Tous droits réservés.
Auteur : Marc de Beaurecueil
e-mail : m.debeaurecueil@crpconsuting.net
Entreprise : Crp Consulting  17, avenue St-Martin de Boville  31138 Balma cedex  (www.crpconsulting.net)
****************************************************************************************************/
//Inclusion de la page entete qui inclue les variables et les fonctions.
include("entete.php");

?>
<form method="post" name="composef" action="editor_res.php">
<script src="editorlang.js"></script>
<script src="editor.js"></script>

<script language="JavaScript">
        var idGenerator = new IDGenerator(0);
        var editor = new Editor(idGenerator, './images');
        editor.ToolBar();
</script>
<textarea style="VISIBILITY: hidden" cols="1" rows="1" name="headtext"></textarea>

<script language="JavaScript">
        editor.InFrame(0, "headtext", "composef", "100%", "50");
</script>

<textarea style="VISIBILITY: hidden" cols="1" rows="1" name="bodytext"></textarea>

<script language="JavaScript">
        editor.InFrame(1, "bodytext", "composef", "100%", "100");
</script>

<SCRIPT language="JavaScript">
        editor.FinalInstantiate(0);
        editor.FinalInstantiate(1);
        editor.CloseInitSection();
</SCRIPT>
<INPUT TYPE=SUBMIT onClick="SetVals();">
</FORM>

<?
include("piedpage.php");
?>