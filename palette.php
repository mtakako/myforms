<HTML><HEAD><TITLE>Palette Map</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<SCRIPT language=JavaScript>
var myColor, decColor, pctColor="" ;

function GetColor( myColor, decColor, pctColor ) {

      document.forms[0].hex_value.value=myColor ;
      document.forms[0].dec_value.value=decColor ;
      document.forms[0].pct_value.value=pctColor ;
      document.forms[0].myformat.value= " \<font color=\"#" + document.forms[0].hex_value.value + "\"\>"

}

function GetClick( ) {
   document.forms[0].myformat.value= " \<font color=\"#" + document.forms[0].hex_value.value + "\"\>"
<?
echo "   window.opener.document.forms[0].elements['".$retour."'].value='#' + document.forms[0].hex_value.value;\n";
?>
   window.close();
}

</SCRIPT>

<META content="MSHTML 5.50.4134.600" name=GENERATOR></HEAD>
<BODY text=#000000 vLink=#000000 aLink=#000000 link=#000000 bgColor=#ffffff
onload="document.forms[0].hex_value.value=''; &#10;document.forms[0].dec_value.value='';&#10;document.forms[0].pct_value.value='';&#10;document.forms[0].reset_button.value='Reset';&#10;document.forms[0].myformat.value=''; &#10;document.forms[0].setColor.value=''">
<CENTER>
  <FORM name=COLORS>
    <INPUT onclick="document.forms[0].hex_value.value=''; &#10;document.forms[0].dec_value.value='';&#10;document.forms[0].pct_value.value='';&#10;document.forms[0].myformat.value=''; &#10;document.forms[0].setColor.value=''" type=hidden value=Reset name=reset_button>

<TABLE>
  <TBODY>
  <TR>
    <TH>Hex Value</TH>
    <TH>Decimal</TH>
    <TH>Percent</TH>
    <TH>Example Code</TH></TR>
  <TR>
    <TD><INPUT
      onclick="document.forms[0].hex_value.value='Not Set'; document.forms[0].myformat.value=''; document.forms[0].setColor.value=''"
      size=9 name=hex_value> </TD>
    <TD><INPUT
      onclick="document.forms[0].dec_value.value='Not Set'; document.forms[0].myformat.value=''; document.forms[0].setColor.value=''"
      size=12 name=dec_value> </TD>
    <TD><INPUT
      onclick="document.forms[0].pct_value.value='Not Set'; document.forms[0].myformat.value=''; document.forms[0].setColor.value=''"
      size=11 name=pct_value> </TD>
    <TD><INPUT size=25 name=myformat> </TD></TR></TBODY></TABLE><INPUT type=hidden
name=setColor> </FORM><IMG src="images/netcolpc.gif"
useMap=#NETCOLPC><BR><MAP name=NETCOLPC><AREA
  onmouseover="GetColor('FF0033','255,0,51','100,00,20')" shape=POLY
  coords=47,162,53,162,56,167,53,172,47,172,44,167
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC0066','204,0,102','80,00,40')" shape=POLY
  coords=70,162,76,162,79,167,76,172,70,172,67,167
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('990099','153,0,153','60,00,60')" shape=POLY
  coords=93,162,99,162,102,167,99,172,93,172,90,167
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6600CC','102,0,204','40,00,80')" shape=POLY
  coords=116,162,122,162,125,167,122,172,116,172,113,167
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3300FF','51,0,255','20,00,100')" shape=POLY
  coords=139,162,145,162,148,167,145,172,139,172,136,167
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCC33','204,204,51','80,80,20')" shape=POLY
  coords=299,2,305,2,308,7,305,12,299,12,296,7
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCC66','204,204,102','80,80,40')" shape=POLY
  coords=287,9,293,9,296,14,293,19,287,19,284,14
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCC99','204,204,153','80,80,60')" shape=POLY
  coords=276,16,282,16,285,21,282,26,276,26,273,21
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99CC33','153,204,51','60,80,20')" shape=POLY
  coords=299,16,305,16,308,21,305,26,299,26,296,21
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCCCC','204,204,204','80,80,80')" shape=POLY
  coords=264,23,270,23,273,28,270,33,264,33,261,28
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99CC66','153,204,102','60,80,40')" shape=POLY
  coords=287,23,293,23,296,28,293,33,287,33,284,28
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99CC99','153,204,153','60,80,60')" shape=POLY
  coords=276,30,282,30,285,35,282,40,276,40,273,35
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66CC33','102,204,51','40,80,20')" shape=POLY
  coords=299,30,305,30,308,35,305,40,299,40,296,35
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99CCCC','153,204,204','60,80,80')" shape=POLY
  coords=264,37,270,37,273,42,270,47,264,47,261,42
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66CC66','102,204,102','40,80,40')" shape=POLY
  coords=287,37,293,37,296,42,293,47,287,47,284,42
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66CC99','102,204,153','40,80,60')" shape=POLY
  coords=276,44,282,44,285,49,282,54,276,54,273,49
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CC33','51,204,51','20,80,20')" shape=POLY
  coords=299,44,305,44,308,49,305,54,299,54,296,49
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66CCCC','102,204,204','40,80,80')" shape=POLY
  coords=264,51,270,51,273,56,270,61,264,61,261,56
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CC66','51,204,102','20,80,40')" shape=POLY
  coords=287,51,293,51,296,56,293,61,287,61,284,56
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CC99','51,204,153','20,80,60')" shape=POLY
  coords=276,58,282,58,285,63,282,68,276,68,273,63
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CCCC','51,204,204','20,80,80')" shape=POLY
  coords=264,65,270,65,273,70,270,75,264,75,261,70
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCC33','204,204,51','80,80,20')" shape=POLY
  coords=392,100,398,100,401,105,398,110,392,110,389,105
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCC66','204,204,102','80,80,40')" shape=POLY
  coords=404,107,410,107,413,112,410,117,404,117,401,112
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC9933','204,153,51','80,60,20')" shape=POLY
  coords=392,114,398,114,401,119,398,124,392,124,389,119
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCC99','204,204,153','80,80,60')" shape=POLY
  coords=415,114,421,114,424,119,421,124,415,124,412,119
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC9966','204,153,102','80,60,40')" shape=POLY
  coords=404,121,410,121,413,126,410,131,404,131,401,126
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCCCC','204,204,204','80,80,80')" shape=POLY
  coords=427,121,433,121,436,126,433,131,427,131,424,126
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC6633','204,102,51','80,40,20')" shape=POLY
  coords=392,128,398,128,401,133,398,138,392,138,389,133
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC9999','204,153,153','80,60,60')" shape=POLY
  coords=415,128,421,128,424,133,421,138,415,138,412,133
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC6666','204,102,102','80,40,40')" shape=POLY
  coords=404,135,410,135,413,140,410,145,404,145,401,140
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC99CC','204,153,204','80,60,80')" shape=POLY
  coords=427,135,433,135,436,140,433,145,427,145,424,140
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC3333','204,51,51','80,20,20')" shape=POLY
  coords=392,142,398,142,401,147,398,152,392,152,389,147
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC6699','204,102,153','80,40,60')" shape=POLY
  coords=415,142,421,142,424,147,421,152,415,152,412,147
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC3399','204,51,153','80,20,60')" shape=POLY
  coords=415,156,421,156,424,161,421,166,415,166,412,161
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC33CC','204,51,204','80,20,80')" shape=POLY
  coords=427,163,433,163,436,168,433,173,427,173,424,168
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CC33','51,204,51','20,80,20')" shape=POLY
  coords=201,78,207,78,210,83,207,88,201,88,198,83
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CC66','51,204,102','20,80,40')" shape=POLY
  coords=189,85,195,85,198,90,195,95,189,95,186,90
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CC99','51,204,153','20,80,60')" shape=POLY
  coords=178,92,184,92,187,97,184,102,178,102,175,97
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('339933','51,153,51','20,60,20')" shape=POLY
  coords=201,92,207,92,210,97,207,102,201,102,198,97
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CCCC','51,204,204','20,80,80')" shape=POLY
  coords=166,99,172,99,175,104,172,109,166,109,163,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('339966','51,153,102','20,60,40')" shape=POLY
  coords=189,99,195,99,198,104,195,109,189,109,186,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('339999','51,153,153','20,60,60')" shape=POLY
  coords=178,106,184,106,187,111,184,116,178,116,175,111
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('336633','51,102,51','20,40,20')" shape=POLY
  coords=201,106,207,106,210,111,207,116,201,116,198,111
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3399CC','51,153,204','20,60,80')" shape=POLY
  coords=166,113,172,113,175,118,172,123,166,123,163,118
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('336666','51,102,102','20,40,40')" shape=POLY
  coords=189,113,195,113,198,118,195,123,189,123,186,118
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('336699','51,102,153','20,40,60')" shape=POLY
  coords=178,120,184,120,187,125,184,130,178,130,175,125
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333333','51,51,51','20,20,20')" shape=POLY
  coords=201,120,207,120,210,125,207,130,201,130,198,125
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3366CC','51,102,204','20,40,80')" shape=POLY
  coords=166,127,172,127,175,132,172,137,166,137,163,132
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333366','51,51,102','20,20,40')" shape=POLY
  coords=189,127,195,127,198,132,195,137,189,137,186,132
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333399','51,51,153','20,20,60')" shape=POLY
  coords=178,134,184,134,187,139,184,144,178,144,175,139
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3333CC','51,51,204','20,20,80')" shape=POLY
  coords=166,141,172,141,175,146,172,151,166,151,163,146
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC3333','204,51,51','80,20,20')" shape=POLY
  coords=39,176,45,176,48,181,45,186,39,186,36,181
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC3366','204,51,102','80,20,40')" shape=POLY
  coords=51,183,57,183,60,188,57,193,51,193,48,188
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('993333','153,51,51','60,20,20')" shape=POLY
  coords=39,190,45,190,48,195,45,200,39,200,36,195
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC3399','204,51,153','80,20,60')" shape=POLY
  coords=62,190,68,190,71,195,68,200,62,200,59,195
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('993366','153,51,102','60,20,40')" shape=POLY
  coords=51,197,57,197,60,202,57,207,51,207,48,202
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC33CC','204,51,204','80,20,80')" shape=POLY
  coords=74,197,80,197,83,202,80,207,74,207,71,202
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('663333','102,51,51','40,20,20')" shape=POLY
  coords=39,204,45,204,48,209,45,214,39,214,36,209
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('993399','153,51,153','60,20,60')" shape=POLY
  coords=62,204,68,204,71,209,68,214,62,214,59,209
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('663366','102,51,102','40,20,40')" shape=POLY
  coords=51,211,57,211,60,216,57,221,51,221,48,216
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9933CC','153,51,204','60,20,80')" shape=POLY
  coords=74,211,80,211,83,216,80,221,74,221,71,216
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333333','51,51,51','20,20,20')" shape=POLY
  coords=39,218,45,218,48,223,45,228,39,228,36,223
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('663399','102,51,153','40,20,60')" shape=POLY
  coords=62,218,68,218,71,223,68,228,62,228,59,223
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333399','51,51,153','20,20,60')" shape=POLY
  coords=62,232,68,232,71,237,68,242,62,242,59,237
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3333CC','51,51,204','20,20,80')" shape=POLY
  coords=74,239,80,239,83,244,80,249,74,249,71,244
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('669966','102,153,102','40,60,40')" shape=POLY
  coords=378,188,384,188,387,193,384,198,378,198,375,193
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('669999','102,153,153','40,60,60')" shape=POLY
  coords=366,195,372,195,375,200,372,205,366,205,363,200
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('999966','153,153,102','60,60,40')" shape=POLY
  coords=389,195,395,195,398,200,395,205,389,205,386,200
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('000000','0,0,0','00,00,00')" shape=POLY
  coords=378,202,384,202,387,207,384,212,378,212,375,207
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('666699','102,102,153','40,40,60')" shape=POLY
  coords=366,209,372,209,375,214,372,219,366,219,363,214
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('996666','153,102,102','60,40,40')" shape=POLY
  coords=389,209,395,209,398,214,395,219,389,219,386,214
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('996699','153,102,153','60,40,60')" shape=POLY
  coords=378,216,384,216,387,221,384,226,378,226,375,221
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3333CC','51,51,204','20,20,80')" shape=POLY
  coords=265,177,271,177,274,182,271,187,265,187,262,182
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3366CC','51,102,204','20,40,80')" shape=POLY
  coords=253,184,259,184,262,189,259,194,253,194,250,189
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6633CC','102,51,204','40,20,80')" shape=POLY
  coords=276,184,282,184,285,189,282,194,276,194,273,189
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3399CC','51,153,204','20,60,80')" shape=POLY
  coords=242,191,248,191,251,196,248,201,242,201,239,196
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6666CC','102,102,204','40,40,80')" shape=POLY
  coords=265,191,271,191,274,196,271,201,265,201,262,196
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9933CC','153,51,204','60,20,80')" shape=POLY
  coords=288,191,294,191,297,196,294,201,288,201,285,196
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CCCC','51,204,204','20,80,80')" shape=POLY
  coords=230,198,236,198,239,203,236,208,230,208,227,203
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6699CC','102,153,204','40,60,80')" shape=POLY
  coords=253,198,259,198,262,203,259,208,253,208,250,203
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9966CC','153,102,204','60,40,80')" shape=POLY
  coords=276,198,282,198,285,203,282,208,276,208,273,203
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC33CC','204,51,204','80,20,80')" shape=POLY
  coords=299,198,305,198,308,203,305,208,299,208,296,203
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66CCCC','102,204,204','40,80,80')" shape=POLY
  coords=242,205,248,205,251,210,248,215,242,215,239,210
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9999CC','153,153,204','60,60,80')" shape=POLY
  coords=265,205,271,205,274,210,271,215,265,215,262,210
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC66CC','204,102,204','80,40,80')" shape=POLY
  coords=288,205,294,205,297,210,294,215,288,215,285,210
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99CCCC','153,204,204','60,80,80')" shape=POLY
  coords=253,212,259,212,262,217,259,222,253,222,250,217
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC99CC','204,153,204','80,60,80')" shape=POLY
  coords=276,212,282,212,285,217,282,222,276,222,273,217
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCCCC','204,204,204','80,80,80')" shape=POLY
  coords=265,219,271,219,274,224,271,229,265,229,262,224
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333333','51,51,51','20,20,20')" shape=POLY
  coords=40,23,46,23,49,28,46,33,40,33,37,28 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('663333','102,51,51','40,20,20')" shape=POLY
  coords=28,30,34,30,37,35,34,40,28,40,25,35 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('336633','51,102,51','20,40,20')" shape=POLY
  coords=51,30,57,30,60,35,57,40,51,40,48,35 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('993333','153,51,51','60,20,20')" shape=POLY
  coords=17,37,23,37,26,42,23,47,17,47,14,42 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('666633','102,102,51','40,40,20')" shape=POLY
  coords=40,37,46,37,49,42,46,47,40,47,37,42 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('339933','51,153,51','20,60,20')" shape=POLY
  coords=63,37,69,37,72,42,69,47,63,47,60,42 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC3333','204,51,51','80,20,20')" shape=POLY
  coords=5,44,11,44,14,49,11,54,5,54,2,49 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('996633','153,102,51','60,40,20')" shape=POLY
  coords=28,44,34,44,37,49,34,54,28,54,25,49 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('669933','102,153,51','40,60,20')" shape=POLY
  coords=51,44,57,44,60,49,57,54,51,54,48,49 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CC33','51,204,51','20,80,20')" shape=POLY
  coords=74,44,80,44,83,49,80,54,74,54,71,49 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC6633','204,102,51','80,40,20')" shape=POLY
  coords=17,51,23,51,26,56,23,61,17,61,14,56 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('999933','153,153,51','60,60,20')" shape=POLY
  coords=40,51,46,51,49,56,46,61,40,61,37,56 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66CC33','102,204,51','40,80,20')" shape=POLY
  coords=63,51,69,51,72,56,69,61,63,61,60,56 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC9933','204,153,51','80,60,20')" shape=POLY
  coords=28,58,34,58,37,63,34,68,28,68,25,63 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99CC33','153,204,51','60,80,20')" shape=POLY
  coords=51,58,57,58,60,63,57,68,51,68,48,63 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCC33','204,204,51','80,80,20')" shape=POLY
  coords=40,65,46,65,49,70,46,75,40,75,37,70 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('996699','153,102,153','60,40,60')" shape=POLY
  coords=170,37,176,37,179,42,176,47,170,47,167,42
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('996666','153,102,102','60,40,40')" shape=POLY
  coords=158,44,164,44,167,49,164,54,158,54,155,49
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('666699','102,102,153','40,40,60')" shape=POLY
  coords=181,44,187,44,190,49,187,54,181,54,178,49
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFFFF','255,255,255','100,100,100')" shape=POLY
  coords=170,51,176,51,179,56,176,61,170,61,167,56
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('999966','153,153,102','60,60,40')" shape=POLY
  coords=158,58,164,58,167,63,164,68,158,68,155,63
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('669999','102,153,153','40,60,60')" shape=POLY
  coords=181,58,187,58,190,63,187,68,181,68,178,63
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('669966','102,153,102','40,60,40')" shape=POLY
  coords=170,65,176,65,179,70,176,75,170,75,167,70
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FF00','0,255,0','00,100,00')" shape=POLY
  coords=94,50,100,50,103,55,100,60,94,60,91,55
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33FF00','51,255,0','20,100,00')" shape=POLY
  coords=82,57,88,57,91,62,88,67,82,67,79,62 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FF33','0,255,51','00,100,20')" shape=POLY
  coords=105,57,111,57,114,62,111,67,105,67,102,62
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66FF00','102,255,0','40,100,00')" shape=POLY
  coords=71,64,77,64,80,69,77,74,71,74,68,69 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00CC00','0,204,0','00,80,00')" shape=POLY
  coords=94,64,100,64,103,69,100,74,94,74,91,69
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FF66','0,255,102','00,100,40')" shape=POLY
  coords=117,64,123,64,126,69,123,74,117,74,114,69
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99FF00','153,255,0','60,100,00')" shape=POLY
  coords=59,71,65,71,68,76,65,81,59,81,56,76 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CC00','51,204,0','20,80,00')" shape=POLY
  coords=82,71,88,71,91,76,88,81,82,81,79,76 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00CC33','0,204,51','00,80,20')" shape=POLY
  coords=105,71,111,71,114,76,111,81,105,81,102,76
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FF99','0,255,153','00,100,60')" shape=POLY
  coords=128,71,134,71,137,76,134,81,128,81,125,76
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCFF00','204,255,0','80,100,00')" shape=POLY
  coords=48,78,54,78,57,83,54,88,48,88,45,83 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66CC00','102,204,0','40,80,00')" shape=POLY
  coords=71,78,77,78,80,83,77,88,71,88,68,83 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('009900','0,153,0','00,60,00')" shape=POLY
  coords=94,78,100,78,103,83,100,88,94,88,91,83
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00CC66','0,204,102','00,80,40')" shape=POLY
  coords=117,78,123,78,126,83,123,88,117,88,114,83
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FFCC','0,255,204','00,100,80')" shape=POLY
  coords=140,78,146,78,149,83,146,88,140,88,137,83
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFF00','255,255,0','100,100,00')" shape=POLY
  coords=36,85,42,85,45,90,42,95,36,95,33,90 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99CC00','153,204,0','60,80,00')" shape=POLY
  coords=59,85,65,85,68,90,65,95,59,95,56,90 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('339900','51,153,0','20,60,00')" shape=POLY
  coords=82,85,88,85,91,90,88,95,82,95,79,90 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('009933','0,153,51','00,60,20')" shape=POLY
  coords=105,85,111,85,114,90,111,95,105,95,102,90
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00CC99','0,204,153','00,80,60')" shape=POLY
  coords=128,85,134,85,137,90,134,95,128,95,125,90
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FFFF','0,255,255','00,100,100')" shape=POLY
  coords=151,85,157,85,160,90,157,95,151,95,148,90
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCC00','204,204,0','80,80,00')" shape=POLY
  coords=48,92,54,92,57,97,54,102,48,102,45,97
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('669900','102,153,0','40,60,00')" shape=POLY
  coords=71,92,77,92,80,97,77,102,71,102,68,97
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('006600','0,102,0','00,40,00')" shape=POLY
  coords=94,92,100,92,103,97,100,102,94,102,91,97
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('009966','0,153,102','00,60,40')" shape=POLY
  coords=117,92,123,92,126,97,123,102,117,102,114,97
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00CCCC','0,204,204','00,80,80')" shape=POLY
  coords=140,92,146,92,149,97,146,102,140,102,137,97
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFCC00','255,204,0','100,80,00')" shape=POLY
  coords=36,99,42,99,45,104,42,109,36,109,33,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('999900','153,153,0','60,60,00')" shape=POLY
  coords=59,99,65,99,68,104,65,109,59,109,56,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('336600','51,102,0','20,40,00')" shape=POLY
  coords=82,99,88,99,91,104,88,109,82,109,79,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('006633','0,102,51','00,40,20')" shape=POLY
  coords=105,99,111,99,114,104,111,109,105,109,102,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('009999','0,153,153','00,60,60')" shape=POLY
  coords=128,99,134,99,137,104,134,109,128,109,125,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00CCFF','0,204,255','00,80,100')" shape=POLY
  coords=151,99,157,99,160,104,157,109,151,109,148,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC9900','204,153,0','80,60,00')" shape=POLY
  coords=48,106,54,106,57,111,54,116,48,116,45,111
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('666600','102,102,0','40,40,00')" shape=POLY
  coords=71,106,77,106,80,111,77,116,71,116,68,111
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('003300','0,51,0','00,20,00')" shape=POLY
  coords=94,106,100,106,103,111,100,116,94,116,91,111
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('006666','0,102,102','00,40,40')" shape=POLY
  coords=117,106,123,106,126,111,123,116,117,116,114,111
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0099CC','0,153,204','00,60,80')" shape=POLY
  coords=140,106,146,106,149,111,146,116,140,116,137,111
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF9900','255,153,0','100,60,00')" shape=POLY
  coords=36,113,42,113,45,118,42,123,36,123,33,118
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('996600','153,102,0','60,40,00')" shape=POLY
  coords=59,113,65,113,68,118,65,123,59,123,56,118
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333300','51,51,0','20,20,00')" shape=POLY
  coords=82,113,88,113,91,118,88,123,82,123,79,118
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('003333','0,51,51','00,20,20')" shape=POLY
  coords=105,113,111,113,114,118,111,123,105,123,102,118
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('006699','0,102,153','00,40,60')" shape=POLY
  coords=128,113,134,113,137,118,134,123,128,123,125,118
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0099FF','0,153,255','00,60,100')" shape=POLY
  coords=151,113,157,113,160,118,157,123,151,123,148,118
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC6600','204,102,0','80,40,00')" shape=POLY
  coords=48,120,54,120,57,125,54,130,48,130,45,125
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('663300','102,51,0','40,20,00')" shape=POLY
  coords=71,120,77,120,80,125,77,130,71,130,68,125
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('000000','0,0,0','00,00,00')" shape=POLY
  coords=94,120,100,120,103,125,100,130,94,130,91,125
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('003366','0,51,102','00,20,40')" shape=POLY
  coords=117,120,123,120,126,125,123,130,117,130,114,125
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0066CC','0,102,204','00,40,80')" shape=POLY
  coords=140,120,146,120,149,125,146,130,140,130,137,125
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF6600','255,102,0','100,40,00')" shape=POLY
  coords=36,127,42,127,45,132,42,137,36,137,33,132
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('993300','153,51,0','60,20,00')" shape=POLY
  coords=59,127,65,127,68,132,65,137,59,137,56,132
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('330000','51,0,0','20,00,00')" shape=POLY
  coords=82,127,88,127,91,132,88,137,82,137,79,132
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('000033','0,0,51','00,00,20')" shape=POLY
  coords=105,127,111,127,114,132,111,137,105,137,102,132
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('003399','0,51,153','00,20,60')" shape=POLY
  coords=128,127,134,127,137,132,134,137,128,137,125,132
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0066FF','0,102,255','00,40,100')" shape=POLY
  coords=151,127,157,127,160,132,157,137,151,137,148,132
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC3300','204,51,0','80,20,00')" shape=POLY
  coords=48,134,54,134,57,139,54,144,48,144,45,139
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('660000','102,0,0','40,00,00')" shape=POLY
  coords=71,134,77,134,80,139,77,144,71,144,68,139
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('330033','51,0,51','20,00,20')" shape=POLY
  coords=94,134,100,134,103,139,100,144,94,144,91,139
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('000066','0,0,102','00,00,40')" shape=POLY
  coords=117,134,123,134,126,139,123,144,117,144,114,139
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0033CC','0,51,204','00,20,80')" shape=POLY
  coords=140,134,146,134,149,139,146,144,140,144,137,139
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF3300','255,51,0','100,20,00')" shape=POLY
  coords=36,141,42,141,45,146,42,151,36,151,33,146
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('990000','153,0,0','60,00,00')" shape=POLY
  coords=59,141,65,141,68,146,65,151,59,151,56,146
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('660033','102,0,51','40,00,20')" shape=POLY
  coords=82,141,88,141,91,146,88,151,82,151,79,146
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('330066','51,0,102','20,00,40')" shape=POLY
  coords=105,141,111,141,114,146,111,151,105,151,102,146
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('000099','0,0,153','00,00,60')" shape=POLY
  coords=128,141,134,141,137,146,134,151,128,151,125,146
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0033FF','0,51,255','00,20,100')" shape=POLY
  coords=151,141,157,141,160,146,157,151,151,151,148,146
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC0000','204,0,0','80,00,00')" shape=POLY
  coords=48,148,54,148,57,153,54,158,48,158,45,153
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('990033','153,0,51','60,00,20')" shape=POLY
  coords=71,148,77,148,80,153,77,158,71,158,68,153
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('660066','102,0,102','40,00,40')" shape=POLY
  coords=94,148,100,148,103,153,100,158,94,158,91,153
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('330099','51,0,153','20,00,60')" shape=POLY
  coords=117,148,123,148,126,153,123,158,117,158,114,153
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0000CC','0,0,204','00,00,80')" shape=POLY
  coords=140,148,146,148,149,153,146,158,140,158,137,153
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF0000','255,0,0','100,00,00')" shape=POLY
  coords=36,155,42,155,45,160,42,165,36,165,33,160
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC0033','204,0,51','80,00,20')" shape=POLY
  coords=59,155,65,155,68,160,65,165,59,165,56,160
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('990066','153,0,102','60,00,40')" shape=POLY
  coords=82,155,88,155,91,160,88,165,82,165,79,160
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('660099','102,0,153','40,00,60')" shape=POLY
  coords=105,155,111,155,114,160,111,165,105,165,102,160
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3300CC','51,0,204','20,00,80')" shape=POLY
  coords=128,155,134,155,137,160,134,165,128,165,125,160
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0000FF','0,0,255','00,00,100')" shape=POLY
  coords=151,155,157,155,160,160,157,165,151,165,148,160
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF0066','255,0,102','100,00,40')" shape=POLY
  coords=59,169,65,169,68,174,65,179,59,179,56,174
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC0099','204,0,153','80,00,60')" shape=POLY
  coords=82,169,88,169,91,174,88,179,82,179,79,174
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9900CC','153,0,204','60,00,80')" shape=POLY
  coords=105,169,111,169,114,174,111,179,105,179,102,174
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6600FF','102,0,255','40,00,100')" shape=POLY
  coords=128,169,134,169,137,174,134,179,128,179,125,174
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF0099','255,0,153','100,00,60')" shape=POLY
  coords=71,176,77,176,80,181,77,186,71,186,68,181
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC00CC','204,0,204','80,00,80')" shape=POLY
  coords=94,176,100,176,103,181,100,186,94,186,91,181
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9900FF','153,0,255','60,00,100')" shape=POLY
  coords=117,176,123,176,126,181,123,186,117,186,114,181
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF00CC','255,0,204','100,00,80')" shape=POLY
  coords=82,183,88,183,91,188,88,193,82,193,79,188
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC00FF','204,0,255','80,00,100')" shape=POLY
  coords=105,183,111,183,114,188,111,193,105,193,102,188
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF00FF','255,0,255','100,00,100')" shape=POLY
  coords=94,190,100,190,103,195,100,200,94,200,91,195
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FF00','0,255,0','00,100,00')" shape=POLY
  coords=318,51,324,51,327,56,324,61,318,61,315,56
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FF33','0,255,51','00,100,20')" shape=POLY
  coords=307,58,313,58,316,63,313,68,307,68,304,63
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33FF00','51,255,0','20,100,00')" shape=POLY
  coords=330,58,336,58,339,63,336,68,330,68,327,63
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FF66','0,255,102','00,100,40')" shape=POLY
  coords=295,65,301,65,304,70,301,75,295,75,292,70
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33FF33','51,255,51','20,100,20')" shape=POLY
  coords=318,65,324,65,327,70,324,75,318,75,315,70
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66FF00','102,255,0','40,100,00')" shape=POLY
  coords=341,65,347,65,350,70,347,75,341,75,338,70
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FF99','0,255,153','00,100,60')" shape=POLY
  coords=284,72,290,72,293,77,290,82,284,82,281,77
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33FF66','51,255,102','20,100,40')" shape=POLY
  coords=307,72,313,72,316,77,313,82,307,82,304,77
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66FF33','102,255,51','40,100,20')" shape=POLY
  coords=330,72,336,72,339,77,336,82,330,82,327,77
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99FF00','153,255,0','60,100,00')" shape=POLY
  coords=353,72,359,72,362,77,359,82,353,82,350,77
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FFCC','0,255,204','00,100,80')" shape=POLY
  coords=272,79,278,79,281,84,278,89,272,89,269,84
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33FF99','51,255,153','20,100,60')" shape=POLY
  coords=295,79,301,79,304,84,301,89,295,89,292,84
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66FF66','102,255,102','40,100,40')" shape=POLY
  coords=318,79,324,79,327,84,324,89,318,89,315,84
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99FF33','153,255,51','60,100,20')" shape=POLY
  coords=341,79,347,79,350,84,347,89,341,89,338,84
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCFF00','204,255,0','80,100,00')" shape=POLY
  coords=364,79,370,79,373,84,370,89,364,89,361,84
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00FFFF','0,255,255','00,100,100')" shape=POLY
  coords=261,86,267,86,270,91,267,96,261,96,258,91
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33FFCC','51,255,204','20,100,80')" shape=POLY
  coords=284,86,290,86,293,91,290,96,284,96,281,91
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66FF99','102,255,153','40,100,60')" shape=POLY
  coords=307,86,313,86,316,91,313,96,307,96,304,91
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99FF66','153,255,102','60,100,40')" shape=POLY
  coords=330,86,336,86,339,91,336,96,330,96,327,91
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCFF33','204,255,51','80,100,20')" shape=POLY
  coords=353,86,359,86,362,91,359,96,353,96,350,91
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFF00','255,255,0','100,100,00')" shape=POLY
  coords=376,86,382,86,385,91,382,96,376,96,373,91
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33FFFF','51,255,255','20,100,100')" shape=POLY
  coords=272,93,278,93,281,98,278,103,272,103,269,98
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66FFCC','102,255,204','40,100,80')" shape=POLY
  coords=295,93,301,93,304,98,301,103,295,103,292,98
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99FF99','153,255,153','60,100,60')" shape=POLY
  coords=318,93,324,93,327,98,324,103,318,103,315,98
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCFF66','204,255,102','80,100,40')" shape=POLY
  coords=341,93,347,93,350,98,347,103,341,103,338,98
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFF33','255,255,51','100,100,20')" shape=POLY
  coords=364,93,370,93,373,98,370,103,364,103,361,98
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('00CCFF','0,204,255','00,80,100')" shape=POLY
  coords=261,100,267,100,270,105,267,110,261,110,258,105
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66FFFF','102,255,255','40,100,100')" shape=POLY
  coords=284,100,290,100,293,105,290,110,284,110,281,105
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99FFCC','153,255,204','60,100,80')" shape=POLY
  coords=307,100,313,100,316,105,313,110,307,110,304,105
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCFF99','204,255,153','80,100,60')" shape=POLY
  coords=330,100,336,100,339,105,336,110,330,110,327,105
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFF66','255,255,102','100,100,40')" shape=POLY
  coords=353,100,359,100,362,105,359,110,353,110,350,105
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFCC00','255,204,0','100,80,00')" shape=POLY
  coords=376,100,382,100,385,105,382,110,376,110,373,105
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('33CCFF','51,204,255','20,80,100')" shape=POLY
  coords=272,107,278,107,281,112,278,117,272,117,269,112
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99FFFF','153,255,255','60,100,100')" shape=POLY
  coords=295,107,301,107,304,112,301,117,295,117,292,112
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCFFCC','204,255,204','80,100,80')" shape=POLY
  coords=318,107,324,107,327,112,324,117,318,117,315,112
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFF99','255,255,153','100,100,60')" shape=POLY
  coords=341,107,347,107,350,112,347,117,341,117,338,112
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFCC33','255,204,51','100,80,20')" shape=POLY
  coords=364,107,370,107,373,112,370,117,364,117,361,112
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0099FF','0,153,255','00,60,100')" shape=POLY
  coords=261,114,267,114,270,119,267,124,261,124,258,119
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('66CCFF','102,204,255','40,80,100')" shape=POLY
  coords=284,114,290,114,293,119,290,124,284,124,281,119
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCFFFF','204,255,255','80,100,100')" shape=POLY
  coords=307,114,313,114,316,119,313,124,307,124,304,119
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFFCC','255,255,204','100,100,80')" shape=POLY
  coords=330,114,336,114,339,119,336,124,330,124,327,119
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFCC66','255,204,102','100,80,40')" shape=POLY
  coords=353,114,359,114,362,119,359,124,353,124,350,119
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF9900','255,153,0','100,60,00')" shape=POLY
  coords=376,114,382,114,385,119,382,124,376,124,373,119
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3399FF','51,153,255','20,60,100')" shape=POLY
  coords=272,121,278,121,281,126,278,131,272,131,269,126
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('99CCFF','153,204,255','60,80,100')" shape=POLY
  coords=295,121,301,121,304,126,301,131,295,131,292,126
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFFFF','255,255,255','100,100,100')" shape=POLY
  coords=318,121,324,121,327,126,324,131,318,131,315,126
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFCC99','255,204,153','100,80,60')" shape=POLY
  coords=341,121,347,121,350,126,347,131,341,131,338,126
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF9933','255,153,51','100,60,20')" shape=POLY
  coords=364,121,370,121,373,126,370,131,364,131,361,126
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0066FF','0,102,255','00,40,100')" shape=POLY
  coords=261,128,267,128,270,133,267,138,261,138,258,133
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6699FF','102,153,255','40,60,100')" shape=POLY
  coords=284,128,290,128,293,133,290,138,284,138,281,133
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCCFF','204,204,255','80,80,100')" shape=POLY
  coords=307,128,313,128,316,133,313,138,307,138,304,133
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFCCCC','255,204,204','100,80,80')" shape=POLY
  coords=330,128,336,128,339,133,336,138,330,138,327,133
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF9966','255,153,102','100,60,40')" shape=POLY
  coords=353,128,359,128,362,133,359,138,353,138,350,133
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF6600','255,102,0','100,40,00')" shape=POLY
  coords=376,128,382,128,385,133,382,138,376,138,373,133
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3366FF','51,102,255','20,40,100')" shape=POLY
  coords=272,135,278,135,281,140,278,145,272,145,269,140
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9999FF','153,153,255','60,60,100')" shape=POLY
  coords=295,135,301,135,304,140,301,145,295,145,292,140
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFCCFF','255,204,255','100,80,100')" shape=POLY
  coords=318,135,324,135,327,140,324,145,318,145,315,140
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF9999','255,153,153','100,60,60')" shape=POLY
  coords=341,135,347,135,350,140,347,145,341,145,338,140
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF6633','255,102,51','100,40,20')" shape=POLY
  coords=364,135,370,135,373,140,370,145,364,145,361,140
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0033FF','0,51,255','00,20,100')" shape=POLY
  coords=261,142,267,142,270,147,267,152,261,152,258,147
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6666FF','102,102,255','40,40,100')" shape=POLY
  coords=284,142,290,142,293,147,290,152,284,152,281,147
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC99FF','204,153,255','80,60,100')" shape=POLY
  coords=307,142,313,142,316,147,313,152,307,152,304,147
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF99CC','255,153,204','100,60,80')" shape=POLY
  coords=330,142,336,142,339,147,336,152,330,152,327,147
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF6666','255,102,102','100,40,40')" shape=POLY
  coords=353,142,359,142,362,147,359,152,353,152,350,147
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF3300','255,51,0','100,20,00')" shape=POLY
  coords=376,142,382,142,385,147,382,152,376,152,373,147
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3333FF','51,51,255','20,20,100')" shape=POLY
  coords=272,149,278,149,281,154,278,159,272,159,269,154
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9966FF','153,102,255','60,40,100')" shape=POLY
  coords=295,149,301,149,304,154,301,159,295,159,292,154
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF99FF','255,153,255','100,60,100')" shape=POLY
  coords=318,149,324,149,327,154,324,159,318,159,315,154
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF6699','255,102,153','100,40,60')" shape=POLY
  coords=341,149,347,149,350,154,347,159,341,159,338,154
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF3333','255,51,51','100,20,20')" shape=POLY
  coords=364,149,370,149,373,154,370,159,364,159,361,154
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('0000FF','0,0,255','00,00,100')" shape=POLY
  coords=261,156,267,156,270,161,267,166,261,166,258,161
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6633FF','102,51,255','40,20,100')" shape=POLY
  coords=284,156,290,156,293,161,290,166,284,166,281,161
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC66FF','204,102,255','80,40,100')" shape=POLY
  coords=307,156,313,156,316,161,313,166,307,166,304,161
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF66CC','255,102,204','100,40,80')" shape=POLY
  coords=330,156,336,156,339,161,336,166,330,166,327,161
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF3366','255,51,102','100,20,40')" shape=POLY
  coords=353,156,359,156,362,161,359,166,353,166,350,161
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF0000','255,0,0','100,00,00')" shape=POLY
  coords=376,156,382,156,385,161,382,166,376,166,373,161
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('3300FF','51,0,255','20,00,100')" shape=POLY
  coords=272,163,278,163,281,168,278,173,272,173,269,168
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9933FF','153,51,255','60,20,100')" shape=POLY
  coords=295,163,301,163,304,168,301,173,295,173,292,168
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF66FF','255,102,255','100,40,100')" shape=POLY
  coords=318,163,324,163,327,168,324,173,318,173,315,168
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF3399','255,51,153','100,20,60')" shape=POLY
  coords=341,163,347,163,350,168,347,173,341,173,338,168
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF0033','255,0,51','100,00,20')" shape=POLY
  coords=364,163,370,163,373,168,370,173,364,173,361,168
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6600FF','102,0,255','40,00,100')" shape=POLY
  coords=284,170,290,170,293,175,290,180,284,180,281,175
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC33FF','204,51,255','80,20,100')" shape=POLY
  coords=307,170,313,170,316,175,313,180,307,180,304,175
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF33CC','255,51,204','100,20,80')" shape=POLY
  coords=330,170,336,170,339,175,336,180,330,180,327,175
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF0066','255,0,102','100,00,40')" shape=POLY
  coords=353,170,359,170,362,175,359,180,353,180,350,175
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('9900FF','153,0,255','60,00,100')" shape=POLY
  coords=295,177,301,177,304,182,301,187,295,187,292,182
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF33FF','255,51,255','100,20,100')" shape=POLY
  coords=318,177,324,177,327,182,324,187,318,187,315,182
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF0099','255,0,153','100,00,60')" shape=POLY
  coords=341,177,347,177,350,182,347,187,341,187,338,182
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC00FF','204,0,255','80,00,100')" shape=POLY
  coords=307,184,313,184,316,189,313,194,307,194,304,189
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF00CC','255,0,204','100,00,80')" shape=POLY
  coords=330,184,336,184,339,189,336,194,330,194,327,189
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FF00FF','255,0,255','100,00,100')" shape=POLY
  coords=318,191,324,191,327,196,324,201,318,201,315,196
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333333','51,51,51','20,20,20')" shape=POLY
  coords=88,109,92,103,100,103,104,109,112,109,117,116,112,125,116,132,112,138,104,140,100,146,91,148,86,139,80,139,76,133,80,126,77,118,81,110,89,109,92,103
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('666666','102,102,102','40,40,40')" shape=POLY
  coords=92,89,101,89,104,96,112,96,117,102,123,103,129,110,125,118,128,125,125,132,128,139,125,147,116,148,112,154,104,154,102,162,92,162,88,155,80,155,75,147,76,148,67,147,63,138,67,132,65,124,68,118,64,111,69,102,77,102,80,95,88,94,91,88
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('999999','153,153,153','60,60,60')" shape=POLY
  coords=92,75,57,96,54,103,54,146,56,153,92,176,101,176,135,155,140,147,139,104,138,97,100,74
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCCCC','204,204,204','80,80,80')" shape=POLY
  coords=94,60,44,90,41,96,41,154,46,161,92,190,101,190,148,162,150,156,151,98,151,95,147,90,100,60,96,60
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCCCC','204,204,204','80,80,80')" shape=POLY
  coords=220,100,218,106,221,111,227,112,230,105,226,99,222,99
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('999999','153,153,153','60,60,60')" shape=POLY
  coords=221,114,218,119,221,126,227,125,230,119,227,114,220,114
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('666666','102,102,102','40,40,40')" shape=POLY
  coords=220,127,217,133,222,139,226,138,230,132,227,126
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333333','51,51,51','20,20,20')" shape=POLY
  coords=220,142,218,147,221,152,227,152,230,146,226,141
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('666666','102,102,102','40,40,40')" shape=POLY
  coords=152,63,155,56,152,50,155,41,164,41,168,34,177,34,181,41,188,41,193,49,190,56,193,62,189,72,181,72,177,79,168,78,164,72,156,71
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CCCCCC','204,204,204','80,80,80')" shape=POLY
  coords=317,104,306,110,301,119,300,133,305,142,316,149,326,149,337,142,342,133,342,119,337,109,326,103,316,104
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('999999','153,153,153','60,60,60')" shape=POLY
  coords=316,90,293,104,289,110,290,143,293,148,318,163,326,163,349,149,354,139,354,111,349,103,325,89
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('666666','102,102,102','40,40,40')" shape=POLY
  coords=316,76,282,96,277,105,278,148,281,155,316,176,326,177,360,155,365,146,365,104,360,96,325,75
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333333','51,51,51','20,20,20')" shape=POLY
  coords=316,62,270,90,265,97,266,154,270,162,316,190,326,190,371,161,375,155,376,97,372,89,325,60
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('999999','153,153,153','60,60,60')" shape=POLY
  coords=375,186,372,192,363,192,359,202,362,207,360,215,363,223,371,223,376,230,385,230,389,222,396,223,401,214,397,206,401,201,397,192,389,192,385,185,374,185
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('6633CC','102,51,204','40,20,80')" shape=POLY
  coords=73,225,80,225,82,230,80,235,73,235,71,230
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('333366','51,51,102','20,20,40')" shape=POLY
  coords=50,236,47,230,50,224,56,225,59,230,56,236
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC3366','204,51,102','80,20,40')" shape=POLY
  coords=403,149,410,149,413,154,411,160,403,160,400,155
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('CC66CC','204,102,204','80,40,80')" shape=POLY
  coords=426,148,432,148,435,154,432,160,426,160,423,154
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('000000','0,0,0','00,00,00')" shape=POLY
  coords=232,80,224,79,224,0,436,0,437,253,224,253,224,173,233,173
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFFFF','255,255,255','100,100,100')" shape=POLY
  coords=224,86,220,87,218,92,219,97,225,97 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('000000','0,0,0','00,00,00')" shape=POLY
  coords=224,174,216,174,216,80,224,80 href="javascript:GetClick()"><AREA
  onmouseover="GetColor('000000','0,0,0','00,00,00')" shape=POLY
  coords=226,166,230,162,227,156,220,157,219,162,221,166
  href="javascript:GetClick()"><AREA
  onmouseover="GetColor('FFFFFF','255,255,255','100,100,100')" shape=RECT
  coords=0,0,437,253 href="javascript:GetClick()"></MAP></CENTER>
</BODY></HTML>