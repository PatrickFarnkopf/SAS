<?php

/**
* Licensed under The Apache License
*
* @copyright Copyright 2012-2013 Patrick Farnkopf, Tanja Weiser, Gabriel Wanzek (PaTaGa)
* @link https://github.com/pataga/SAS
* @since SAS v1.0.0
* @license Apache License v2 (http://www.apache.org/licenses/LICENSE-2.0.txt)
* @author Patrick Farnkopf
*
*/

if (isset($_POST['from2'])) {
  if (!$installer->writeConfig()) {
    echo 'Die Konfigurationsdatei konnte nicht beschrieben werden!<br>Bitte f&uuml;hren sie <b>chmod 777 SAS/includes/Config/MySQL.conf.php</b> aus.<br>Weiterleitung zu Schritt 2 in 10 Sekunden...';
    header ("Refresh: 10; ?install=2");
    exit;
  }

  if (!$installer->connect()){
    echo 'MySQL Zugangsdaten inkorrekt! Weiterleitung zu Schritt 2 in 10 Sekunden...';
    header ("Refresh: 10; ?install=2");  
    exit;
  }

  $installer->installDatabase();
}
   
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>SAS</title>
        <link rel="stylesheet" href="./css/normalize.min.css">
        <link rel="stylesheet" href="./css/main.css">
        <script src="./js/vendor/modernizr-2.6.1.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="./js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
        <script src="./js/plugins.js"></script>
        <script src="./js/main.js"></script>
    </head>
    <body>
        <div class="logoinstall">
            <h1>Server <span>Admin</span> System</h1>
            <h3>Installation</h3>
        </div>
            <div id="main">
                <div id="box1_install">
                    <fieldset>
                        <b>SAS wurde erfolgreich konfiguriert.<br> Bitte legen sie nun einen Administrator Benutzer an.</b>
                    </fieldset>
                    <form action="?install=4" method="post">
                        <fieldset>
                            <p><label>Benutzername:</label>
                            <input type="text" name="user" class="text-long" required></p>
                            <p><label>Passwort:</label>
                            <input type="password" name="pass" class="text-long" required></p>
                            <p><label>Passwort best&auml;tigen:</label>
                            <input type="password" name="passwdh" class="text-long" required></p>
                            <p><label>E-Mail:</label>
                            <input type="email" name="email" class="text-long" required></p>
                            <div id="installbutton"><input type="submit" value="Installation abschlie&szlig;en" class="button black"></div>
                        </fieldset>
                    </form>
                </div>
            </div>
    </body>
</html>