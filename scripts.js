//Affichage de photos en upload
function preview_image(event, nom) {
 var reader = new FileReader();
 reader.onload = function() {
  var output = document.getElementById(nom.name);
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}

function del_image(elt, img){
   elt.value=' ';
   document.getElementById(img).src='';
   return;
}

//Selectionne l option du select en fonction de valeur texte
function selectOptionValText(selectOptionName,valText) {
   var rads = document.forms[0].elements[selectOptionName];
   for (var i=0; i < rads.options.length; i++){
      if (rads.options[i].text==valText){
          rads.selectedIndex=i;
	}
   }
}

//Selectionne l option du select en fonction de valeur
function selectOptionValValeur(selectOptionName,valeur) {
   var rads = document.forms[0].elements[selectOptionName];
   for (var i=0; i < rads.options.length; i++){
      if (rads.options[i].value==valeur){
          rads.selectedIndex=i;
	}
   }
}

//Verifie si la valeur est un entier
function isNotInteger(value) {
	if (value==''){
		return false
	}
	return !(value == parseInt(value));
}

//Recupere la valeur d un objet de type radio
function getCheckedRadioValue(radioGroupName) {
   var rads = document.getElementsByName(radioGroupName);
   for (var i=0; i < rads.length; i++)
      if (rads[i].checked)
          return rads[i].value;
   return null; // or undefined, or your preferred default for none checked
}

function validation_heure(obj) {
   if (obj.value=="00:00"){
		alert("Heure invalide. Merci de saisir une heure au format 00:00");
		return true;
   }
   if (obj.value!=""){
	reg = new RegExp("^(([0-1][0-9])|([2][0-3])):([0-5][0-9])(:([0-5][0-9]))?$");
	if(!obj.value.match(reg)){
		alert("Heure invalide. Merci de la mettre au format 00:00");
		return true;
	}
   }
   return false;
}

function inArray(array, p_val) {
    var l = array.length;
    for(var i = 0; i < l; i++) {
        if(array[i] == p_val) {
            return true;
        }
    }
    return false;
}

function OuvrirPopup(bdd,table,nom_col1,nom_col2,mode,clause,nom_objet,table_encours,autre_colonne) {
  fille=window.open('popup.php?bdd='+bdd+'&table='+table+'&nom_col1='+nom_col1+'&nom_col2='+nom_col2+'&mode='+mode+'&clause='+clause+'&nom_objet='+nom_objet+'&table_encours='+table_encours+'&autre_colonne='+autre_colonne,'popupchoix','width=300,height=500,resizable=yes,dependent=yes,scrollbars=yes,menubar=no,location=no,status=no');
}       
function OuvrirPopupNan(bdd,table_relation,table_encours,objet,titre) {
  fille=window.open(table_encours+'_'+table_relation+'.php?bdd='+bdd+'&objet='+objet+'&titre='+titre,'popupchoix','width=400,height=250,resizable=yes,dependent=yes,scrollbars=yes,menubar=no,location=no,status=no');
}
function OuvrirPopupTable(bdd,nom_objet,mode) {
  fille=window.open('table_lie.php?bdd='+bdd+'&name_ID='+nom_objet+'&popup='+mode,'popupchoix','width=500,height=400,resizable=yes,dependent=yes,scrollbars=yes,menubar=no,location=no,status=no');
//  fille=window.open('table_lie.php?bdd='+bdd+'&name_ID='+nom_objet+'&popup='+mode,'popupchoix','width=500,height=400,resizable=yes,dependent=yes,scrollbars=yes,menubar=yes,location=yes,status=yes');
}
function OuvrirPopupRelation(bdd,nom_objet,mode,table) {
  fille=window.open('table_relation.php?bdd='+bdd+'&name_ID='+nom_objet+'&popup='+mode+'&table='+table,'popupchoix','width=500,height=400,resizable=yes,dependent=yes,scrollbars=yes,menubar=no,location=no,status=no');
//  fille=window.open('table_lie.php?bdd='+bdd+'&name_ID='+nom_objet+'&popup='+mode,'popupchoix','width=500,height=400,resizable=yes,dependent=yes,scrollbars=yes,menubar=yes,location=yes,status=yes');
}
function OuvrirFen(nomFen,w,h) {
  fille=window.open(nomFen,'Popup','width='+w+',height='+h+',resizable=yes,dependent=yes,scrollbars=yes,menubar=no,location=no,status=no');
}

function raz(elt) {
   elt.focus();
   elt.select();
   var poursuivre = confirm('Voulez-vous effacer le contenu de la zone ?');
   if (poursuivre == true){
      elt.value='';
   }
}


function raz_nan(elt) {
   //elt.focus();
   //elt.select();

   theSelection = document.selection.createRange().text;
   alert(theSelection);

   var poursuivre = confirm('Voulez-vous effacer la ligne de la zone ?');
   if (poursuivre == true){
      elt.value='';
   }
}

function CheckDate(d) {
        // Cette fonction verifie le format JJ/MM/AAAA saisi et la validite de la date.
        // Le separateur est defini dans la variable separateur
        if (d=="") return true;
        var amin=1900;  // annee mini
        var amax=2100;  // annee maxi
        var ok=true;

		if (d.length!=10) {
                alert("Erreur sur le format de date 00/00/0000");
                ok=false;
                return ok;
        }

        var separateur="/"; // separateur entre jour/mois/annee
        var sep1=d.indexOf("/",0);
        if (sep1==-1) {
                alert("Les separateurs de la date doivent etre des "+separateur);
                ok=false;
                return ok;
        }
        var sep2=d.indexOf("/",sep1+1);
        if (sep2==-1) {
                alert("Les separateurs de la date doivent etre des "+separateur);
                ok=false;
                return ok;
        }
        var longueur=d.length;
        var j=(d.substring(0,sep1));
        var m=(d.substring(sep1+1,sep2));
        var a=(d.substring(sep2+1,longueur));

        if ( ((isNaN(j))||(j<1)||(j>31)) && (ok==1) ) {
                alert("Le jour n'est pas correct.");
                ok=false;
                return ok;
        }
        if ( ((isNaN(m))||(m<1)||(m>12)) && (ok==1) ) {
                alert("Le mois n'est pas correct.");
                ok=false;
                return ok;
        }
        if ( ((isNaN(a))||(a<amin)||(a>amax)) && (ok==1) ) {
                alert("L'annee n'est pas correcte.");
                ok=false;
                return ok;
        }

        if (ok==1) {
                var d2=new Date(a,m-1,j);
                j2=d2.getDate();
                m2=d2.getMonth()+1;
                a2=d2.getFullYear();
                if ( (j!=j2)||(m!=m2)||(a!=a2) ) {
                        alert("La date "+d+" n'existe pas !");
                        ok=false;
                        return ok;
                }
        }
        return ok;

}

function verifiermail(mail) {
//Cette fonction verifie la presence du caractere @ et du . pour verifier la
//validite du mail. Si ces 2 caracteres sont trouves, la fonction retourne true
//sinon, elle affiche un message et  retourne false
        if ((mail.indexOf("@")>=0)&&(mail.indexOf(".")>=0)) {
                return true
        } else {
                alert("Mail invalide !");
                return false
        }
}


function date_jour(){
   Today = new  Date  ()
   jour=Today.getDate()+"/"+(Today.getMonth()+1)+"/"+Today.getFullYear();
   return jour;
}

/*
  deplacer( liste_depart, liste_arrivee )
  Déplace depuis la liste de départ (argument 1) et à destination de la liste d'arrivée (argument 2) le ou les éléments sélectionnés par l'utilisateur, l'ajout se faisant à la suite des éléments déjà présents dans la liste d'arrivée.
*/
function deplacer( liste_depart, liste_arrivee ) {
  if (liste_depart.options.selectedIndex>=0) {
    for( i = 0; i < liste_depart.options.length; i++ ) {
      if( liste_depart.options[i].selected && liste_depart.options[i] != "" ) {
        o = new Option( liste_depart.options[i].text, liste_depart.options[i].value );
        liste_arrivee.options[liste_arrivee.options.length] = o;
        liste_depart.options[i] = null;
        i = i - 1 ;
      }
    }
  }
  else {
    alert( "aucun element selectionne" );
  }
}
  
  
/*
  soumettre_1liste( liste )
  Au moment de la soumission du formulaire, sélectionne automatiquement toutes les valeurs de la liste donnée indiquée dans l'argument, afin que les valeurs choisies soit récupérées dans le script de traitement.
*/
function soumettre_1liste( liste ) {
    var listelen = liste.length;
    for( i = 0; i < listelen; i++ ) {
      liste.options[i].selected = true;
    }
}
