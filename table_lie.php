<html>
<head>
<?php
include_once("var.inc.php");
include_once("functions.inc.php");
include("encodage.inc.php");
include ("stylef.php");

$bdd=$_GET["bdd"];
$name_ID=$_GET["name_ID"];
$popup=$_GET["popup"];
?>
</head>
<body>
<?php
      echo "<script type=\"text/javascript\">\n";
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
      echo "</script>\n";

$connexion=connexion($bdd);
?>
<form action="" name="formpopup" method="post">
<h3>Selectionnez la table.colonne :</h3>
<?php
$req= "SHOW TABLES";
$res=mysqli_query($connexion,$req);
while ($row = mysqli_fetch_row($res)) {
   if ($popup==1)
      echo "<input type='hidden' name='nom_table_$i' value='$row[0]'><input type='RADIO' name='choix' value='$i' onClick=Reporter_radio(this)>$row[0].\n";
   if ($popup==2)
      echo "<input type='hidden' name='nom_table_$i' value='$row[0]'><input type='CHECKBOX' name='choix' value='$i' onClick=Reporter_checkbox(this)>$row[0].\n";

   $j=0;
   $result2 = execute_sql("select * from $row[0]");
   $fields = mysqli_num_fields($result2);

   echo "<select name=nom_col_$i>\n";
   echo "<option value=''>\n";
   while ($j < $fields) {
      $name  = db_field_direct_name($result2, $j);
      echo "<option value='$name'>$name</option>\n";
      $j++;
   }
   echo "</select><br/>\n";
   $i++;
}

?>
<br/>
</form>
</body>
</html>