<?
fwrite( $fp, "/**************************************************************************************************\n" );
fwrite( $fp, "Nom du programme : $filename\n" );
fwrite( $fp, "Nom de la table g�r�e : $table\n" );
fwrite( $fp, "Date de g�n�ration du programme : ".date(" d/m/Y")." \n" );
fwrite( $fp, "Heure de g�n�ration du programme :".date(" H:i:s")."\n" );
fwrite( $fp, "Copyright : Ce script a �t� g�n�r� par PhpPro VERSION 3.4 , G�n�rateur de logiciel en PHP. Tous droits r�serv�s.\n" );
fwrite( $fp, "Auteur : Marc de Beaurecueil\n" );
fwrite( $fp, "e-mail : m.debeaurecueil@crpconsuting.net\n" );
fwrite( $fp, "Entreprise : Crp Consulting  17, avenue St-Martin de Boville  31138 Balma cedex  (www.crpconsulting.net)\n" );
fwrite( $fp, "****************************************************************************************************/\n" );

?>