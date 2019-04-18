<?
fwrite( $fp, "/**************************************************************************************************\n" );
fwrite( $fp, "Nom du programme : $filename\n" );
fwrite( $fp, "Nom de la table gérée : $table\n" );
fwrite( $fp, "Date de génération du programme : ".date(" d/m/Y")." \n" );
fwrite( $fp, "Heure de génération du programme :".date(" H:i:s")."\n" );
fwrite( $fp, "Copyright : Ce script a été généré par PhpPro VERSION 3.4 , Générateur de logiciel en PHP. Tous droits réservés.\n" );
fwrite( $fp, "Auteur : Marc de Beaurecueil\n" );
fwrite( $fp, "e-mail : m.debeaurecueil@crpconsuting.net\n" );
fwrite( $fp, "Entreprise : Crp Consulting  17, avenue St-Martin de Boville  31138 Balma cedex  (www.crpconsulting.net)\n" );
fwrite( $fp, "****************************************************************************************************/\n" );

?>