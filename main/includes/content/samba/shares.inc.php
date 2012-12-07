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


	if(isset($_POST['add']))
	{
		$name = $_POST['name'];
		$path = $_POST['path'];
		$validusers = $_POST['validusers'];
		$writelist = $_POST['writelist'];
		$createmask = $_POST['createmask'];
		$directorymask = $_POST['directorymask'];
		$readonly = $_POST['readonly'];

		if(isset($_POST['public']))
		{
			if($_POST['public'] == 1)
			$public = "public = yes";
			else 
			$public = "public = no";
		}

		if(isset($_POST['writeable']))
		{
			if($_POST['writeable'] == 1)
			$writeable = "writeable = yes";
			else 
			$writeable = "writeable = no";
		}

		if(isset($_POST['readonly']))
		{
			if($_POST['readonly'] == 1)
			$readonly = "read only = yes";
			else 
			$readonly = "read only = no";
		}

		$ssh->openConnection();
		// Öffnen der Verbindung

$content = "
[$name]
path = $path
valid users = $validusers
writelist = $writelist
create mask = $createmask
directory mask = $directorymask
public = $public
writeable = $writeable
read only = $readonly";

$server->addToFile($ssh, '/etc/samba/smb.conf', $content);
// Schreiben der neuen Freigabe in die smb.conf
$ssh->execute('service smbd reload');
// Neustart
}

?>


<h3>Neue Samba-Freigabe hinzuf&uuml;gen</h3>
<br>
Hinweis: Nach dem hinzufügen einer neuen Freigabe wird der Server automatisch neu gestartet.
<br><br>
<fieldset>
    <form action="index.php?p=samba&s=shares" method="POST">
        <div class ="viertel-box"> 
            Freigabe Name: <br><br>
            Verzeichnispfad: <br><br>
            G&uuml;ltige Benutzer: <br><br>
            Schreibrechte f&uuml;r <br><br>
            Create Mask: <br><br>
            Directory Mask: <br><br><br>
            &Ouml;ffentliche Freigabe? 
            <br><br>
            Schreibrechte f&uuml;r jeden? 
            <br><br>
            Nur lesbar?

        </div>
        <div class="dreiviertel-box lastbox">
            <input type="text" class="text-long" name="name" id=""><br><br>
            <input type="text" class="text-long" name="path" id=""><br><br>
            <input type="text" class="text-long" name="validusers" id=""><br><br>
            <input type="text" class="text-long" name="writelist" id=""><br><br>
            <input type="text" class="text-long" name="createmask" id=""><br><br>
            <input type="text" class="text-long" name="directorymask" id="">
            <br><br><br>
            <select name="public">
                <option value="1"> Ja </option>
                <option value="0"> Nein </option>
            </select>
            <br>
             <select name="writeable">
                <option value="1"> Ja </option>
                <option value="0"> Nein </option>n>
            </select>
            <br>
            <select name="readonly">
                <option value="1"> Ja </option>
                <option value="0"> Nein </option>
            </select>
        </div>
        <div class="clearfix"></div>
        <input type="submit" class="button green" name="add" value="Neue Freigabe Hinzuf&uuml;gen">
    </form>
</fieldset>