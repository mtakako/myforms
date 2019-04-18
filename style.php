<style type="text/css" media="all">

.tableform {
        display:table;
        border-collapse:collapse;
        width: 180mm;
        /*border:2px solid black;*/
        font-family : <?php echo $font?>;
        font-size : 8pt;
}

.trform {
        display:table-row;
        font-family : <?php echo $font?>;
        font-size : 8pt;
}
.tdform {
        display:table-cell;
        border:1px solid black;
        padding:5px;
        padding-top:5px;
        width:24.5%;
        font-family : <?php echo $font?>;
        font-size : 8pt;
        vertical-align : top;
}
.tdfinform {
        width:auto;
        font-family : <?php echo $font?>;
        font-size : 8pt;
}


.chmformulaire h2 {
    font-family :<?php echo $font?>;
    font-size: <?php echo $font_size+6?>pt;
    font-style: normal;
    font-weight: bold;
    color: <?php echo $couleur_page?>
    }

body {
      font-family : <?php echo $font?>;
      font-size : <?php echo $font_size?>;
      background-color: <?php echo $couleur_fond_page?>;
      color: #000000;
     }

.div_form{
	border-bottom-style:solid;
	border-color:#377BA8;
}

.div_form_label{
	width : 300px;
}

.div_form_base{
	float : left;

}
.chmformulaire img {
     border:0;
     }

.chmformulaire a:link {
    font-family :<?php echo $font?>;
    color: <?php echo $couleur_liens?>
    }
.chmformulaire a:visited {
    font-family : <?php echo $font?>;
    color: <?php echo $couleur_liens?>
    }
.chmformulaire a:active {
    font-family : <?php echo $font?>;
    color: <?php echo $couleur_liens?>
    }
.chmformulaire a:hover {
    font-family : <?php echo $font?>;
    color: <?php echo $couleur_liens?>
    }

.chmformulaire th {
    background-color: <?php echo $couleur_page?>;
    font-family : <?php echo $font?>;
    font-size : <?php echo $font_size?>;
    color: #ffffff;
    text-align : center ;
    font-weight: bold;
}

.chmformulaire td {
    font-family : <?php echo $font?>;
    font-size : <?php echo $font_size?>;
    text-align : left;
    font-weight: normal;
    padding-top: 2px;
    padding-bottom: 2px;
}

.chmformulaire p {
    font-family : <?php echo $font?>;
    font-size : <?php echo $font_size?>;
    }
    
.chmformulaire table {
   border:0;
   width:100%
   cellspacing:0;
   }


.chmformulaire .entete {
    color: #ffffff;
    font-family : <?php echo $font?>;
    font-size : <?php echo $font_size?>;
}

.chmformulaire .lig1 {
    background-color: <?php echo $couleur_ligne1?>;
    font-family: <?php echo $font?>;
    font-size: <?php echo $font_size-2?>pt;
    }

.chmformulaire .lig0 {
    background-color: <?php echo $couleur_ligne0?>;
    font-family: <?php echo $font?>;
    font-size: <?php echo $font_size-2?>pt;
   }

.chmformulaire textarea {
          font-family : <?php echo $font?>;
          font-size : <?php echo $font_size?>;
          color : #000000;
          border-width : 1px;
          border-style : solid;
          background-color : <?php echo $couleur_objets?>;
          border-color : #000000;
         }

.chmformulaire select {
        font-family : <?php echo $font?>;
        font-size : <?php echo $font_size?>;
        color : #000000;
        border-width : 2p1;
        border-width : 1px;
        border-style : solid;
        background-color : <?php echo $couleur_objets?>;
        border-color : #000000;
       }

.chmformulaire input {
       font-family : <?php echo $font?>;
       font-size : <?php echo $font_size?>;
       text-decoration: none;
       color: #000000;
       background-color : <?php echo $couleur_objets?>;
       border : 1px solid #000000;
      } 
 
.output_image{
   max-width:200px;
}
.output_image_rech{
   max-width:80px;
}
	  
/**** SCRIPT FOR FORMATTING MESSAGES WYSIWYG ********************/

.ButtonNormal {

   BORDER-RIGHT: buttonface 1px solid; BORDER-TOP: buttonface 1px solid;
   BORDER-LEFT: buttonface 1px solid; BORDER-BOTTOM: buttonface 1px solid;
   BACKGROUND-COLOR: #CCCCCC }

.ButtonPressed {

   BORDER-RIGHT: buttonhighlight 1px solid; BORDER-TOP: buttonshadow 1px solid;
   BORDER-LEFT: buttonshadow 1px solid; BORDER-BOTTOM: buttonhighlight 1px solid;
   BACKGROUND-COLOR: #CCCCCC }

.ButtonMouseOver {

   BORDER-RIGHT: buttonshadow 1px solid; BORDER-TOP: buttonhighlight 1px solid;
   BORDER-LEFT: buttonhighlight 1px solid; BORDER-BOTTOM: buttonshadow 1px solid;
   BACKGROUND-COLOR: #CCCCCC }

.ButtonDisabled {

   BORDER-RIGHT: buttonface 1px solid; BORDER-TOP: buttonface 1px solid;
   BORDER-LEFT: buttonface 1px solid; BORDER-BOTTOM: buttonface 1px solid;
   BACKGROUND-COLOR: #CCCCCC }

.Image {

   WIDTH: 22px; HEIGHT: 22px }

.Toolbar {

   BORDER-RIGHT: buttonshadow 1px solid; BORDER-TOP: buttonhighlight 1px solid;
   BORDER-LEFT: buttonhighlight 1px solid; BORDER-BOTTOM: buttonshadow 1px solid;
   HEIGHT: 30px;background: #CCCCCC }

.Divider {

   BORDER-RIGHT: buttonhighlight 1px solid; BORDER-TOP: buttonshadow 1px solid;
   BORDER-LEFT: buttonshadow 1px solid; WIDTH: 2px;
   BORDER-BOTTOM: buttonhighlight 1px solid; HEIGHT: 24px;background: #CCCCCC }

.Swatch {

   BORDER-RIGHT: buttonshadow 1px solid; BORDER-TOP: buttonhighlight 1px solid;
   BORDER-LEFT: buttonhighlight 1px solid; WIDTH: 3px;
   BORDER-BOTTOM: buttonshadow 1px solid; HEIGHT: 24px;background: #CCCCCC }

.Space {

   WIDTH: 0px; HEIGHT: 24px;background: buttonface }

.List {

   BACKGROUND: #FFFFFF; COLOR: #000000; FONT: 8px Verdana, Arial, sans-serif  }

.Text {

   FONT: 8pt Verdana, Arial, sans-serif }

.Heading {

   BACKGROUND: #FFFFFF; COLOR: #000000 }

/**** END Classes USED BY THE SCRIPT FOR FORMATTING MESSAGES WYSIWYG */


</style>
