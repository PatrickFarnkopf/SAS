<?php


/**
* Licensed under The Apache License
*
* @copyright Copyright 2012-2013 Patrick Farnkopf, Tanja Weiser, Gabriel Wanzek (PaTaGa)
* @link https://github.com/pataga/SAS
* @since SAS v1.0.0
* @license Apache License v2 (http://www.apache.org/licenses/LICENSE-2.0.txt
* @author Tanja Weiser
*
*/

if (!$server->isInstalled('samba')) {
    header('Location:?p=samba&s=install');
    exit;
}

//#######################################################
//		Dienst stoppen
//#######################################################
if(isset($_POST['stop']))
{
	$server->execute('service smbd stop');
}

//#######################################################
//		Dienst neustarten
//#######################################################
if(isset($_POST['restart']))
{
	$server->execute('service smbd restart');
}

//#######################################################
//		Samba Version auslesen
//#######################################################

$version = $server->execute('smbd -V');
	

?>

<h3>Samba Übersicht</h3>

<fieldset>
<legend>Installierte Samba Version</legend>
<h5><?=$version?></h5> 
</fieldset>

<form action="index.php?p=samba" method="POST">
<fieldset>	
<div class ="drittel-box"> 
<h5>Stop</h5>
<p><b>Stoppt den Dienst sofort</b></p>
	<br><input type="submit" class="button pink" name="stop" value="stop"> 
</div>
<div class ="drittel-box lastbox">
<h5>Restart</h5>
<p><b>Startet den Dienst neu</b></p>
	<br><input type="submit" class="button black" name="restart" value="neustarten">
</div>
</form>
</fieldset>