<?php
	$link = mysql_pconnect("localhost", "rawpix", "werderbremen") or die ("Fehler #1: Keine Verbindung zum Server möglich.");
	$dblink = mysql_select_db("rawpix") or die ("Fehler #2: Keine Verbindung zur Datenbank möglich.");
?>
