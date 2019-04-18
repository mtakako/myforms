<html>
<?php
$bdd=$_GET["bdd"];
$name_ID=$_GET["name_ID"];
$popup=$_GET["popup"];
$table=$_GET["table"];

      echo "<SCRIPT LANGUAGE=javascript>\n";
      echo "   tab_cbx=new Array();\n";
      echo "   function Reporter_radio(r) {\n";
      echo "      if(document.formpopup.elements['nom_col_'+r.value].value==''){\n";
      echo "         r.checked=false;\n";
      echo "         return;\n";
      echo "      }\n";
      echo "      if (window.opener.document.forms[0].elements['".$name_ID."'].type=='text'){\n";
      echo "         selection=document.formpopup.elements['nom_table_'+r.value].value+'.'+document.formpopup.elements['nom_col_'+r.value].value;\n";
      echo "         window.opener.document.forms[0].elements['".$name_ID."'].value=selection;\n";
      echo "      }\n";
      echo "       window.close();\n";
      echo "   }\n";
      echo "   function Reporter_checkbox(r) {\n";
      echo "      if(document.formpopup.elements['nom_col_'+r.value].value==''){\n";
      echo "         r.checked=false;\n";
      echo "         return;\n";
      echo "      }\n";
      echo "      selection=document.formpopup.elements['nom_table_'+r.value].value+'.'+document.formpopup.elements['nom_col_'+r.value].value;\n";
      echo "      if (window.opener.document.forms[0].elements['".$name_ID."'].type=='textarea'){\n";    // si textarea
      echo "         if (r.checked==true){\n";
      echo "            tab_cbx[tab_cbx.length]=selection;\n";
      echo "         }\n";
      echo "         else{\n";
      echo "            for(var i=0;i<tab_cbx.length;i++){\n";
      echo "               if (selection==tab_cbx[i]) {\n";
      echo "                  tab_cbx.splice(i,1);\n";
      echo "               }\n";
      echo "            }\n";
      echo "         }\n";
      echo "         window.opener.document.forms[0].elements['".$name_ID."'].value=tab_cbx.join('\\n')\n";
      echo "      }\n";
      echo "   }\n";
      echo "</SCRIPT>\n";
?>


<body>
<?
include("var.inc.php");
include("functions.inc.php");

$connexion=connexion($bdd);
?>
<form action="" NAME=formpopup METHOD=POST>

<?php

list($table,$colonne)=explode(".",$table);

if (!isset($table)||($table=="")){
   echo "Vous devez choisir une table et une colonne auparavant.";
   exit;
}

echo "<H3>Sélectionnez les colonnes de la table : $table</H3>";
$result=execute_sql("SELECT * FROM $table");
$count=mysqli_num_fields($result);
$i=0;
while ($i < $count) {
   //$tb_names = @mysqli_tablename ($result, $i);
   //echo "<INPUT TYPE=RADIO NAME=table VALUE='$tb_names'>$tb_names.";

   if ($popup==1)
      echo "<INPUT TYPE=hidden NAME=nom_table_$i VALUE='$table'><INPUT TYPE=RADIO NAME=choix VALUE=$i onClick=Reporter_radio(this)>$table.\n";
   if ($popup==2)
      echo "<INPUT TYPE=hidden NAME=nom_table_$i VALUE='$table'><INPUT TYPE=CHECKBOX NAME=choix VALUE=$i onClick=Reporter_checkbox(this)>$table.\n";

   $j=0;
   $result2 = execute_sql("SELECT * FROM $table");
   $fields = mysqli_num_fields($result2);

   echo "<SELECT NAME=nom_col_$i>\n";
   echo "<OPTION VALUE=''>\n";
   while ($j < $fields) {
      $name  = db_field_direct_name($result2, $j);
      echo "<OPTION VALUE='$name'>$name</OPTION>\n";
      $j++;
   }
   echo "</SELECT><BR>\n";
   $i++;
}
?>
<br/>
</form>
</body>
</html>
