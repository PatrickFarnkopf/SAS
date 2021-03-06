<?php
/**
 * Licensed under The Apache License
 *
 * @copyright Copyright 2012-2013 Patrick Farnkopf, Tanja Weiser, Gabriel Wanzek (PaTaGa)
 * @link https://github.com/pataga/SAS
 * @since SAS v1.0.0
 * @license Apache License v2 (http://www.apache.org/licenses/LICENSE-2.0.txt)
 * @author Gabriel Wanzek
 * @version 0.8
 *
 */
require_once './includes/Content/main/module_functions.inc.php';

$load = $server->execute("uptime");        //für Serverload
$uptime = $server->execute("who -b");      //für Systemstartdatum
$userswho = $server->execute("users");     //zeigt eingeloggte benutzer an
$kernelversion = $server->execute("cat /proc/version");    //kernelversion
$sekundentmp = $server->execute("cat /proc/uptime");       //zeit in sek. wie lang server an ist
$hostname = $server->execute("hostname -s");       //gibt den Systemnamen/Hostnamen aus

$loadpart = explode("load average:", $load);
$serverload = isset($loadpart[1]) ? $loadpart[1] : 0;

$sekunden0 = explode(".", $sekundentmp);
$sekunden = $sekunden0[0];
$serveruptime = (((((((($sekunden - ($sekunden % 60)) / 60) - (($sekunden - ($sekunden % 60)) / 60) % 60) / 60))) - (((((($sekunden - ($sekunden % 60)) / 60) - (($sekunden - ($sekunden % 60)) / 60) % 60) / 60)) % 24)) / 24) . " T. " . (((((($sekunden - ($sekunden % 60)) / 60) - (($sekunden - ($sekunden % 60)) / 60) % 60) / 60)) % 24) . " Std. " . ((($sekunden - ($sekunden % 60)) / 60) % 60) . " Min. " . ($sekunden % 60) . " Sek. "; // macht aus Sekunden xx Tage xx Stunden xx Minuten xx Sekunden (als kurzform)

$bootdatetmp = str_replace("   ", "", $uptime);
$bootdate = str_replace("Systemstart", "", $bootdatetmp);
$userswholi = str_replace(" ", ", ", $userswho);
$service = $server->serviceStatus();

if (isset($_POST['notiz'])) {
    $sql = "INSERT INTO sas_home_notes (id, author, note, notetime) 
    VALUES (NULL, '" . $_SESSION['user']['name'] . "','" . htmlspecialchars(mysql_real_escape_string($_POST['notizen'])) . "'  , CURRENT_TIMESTAMP);";
    $mysql->Query($sql);
}

if (isset($_POST['oldnc'])) {
    $notereslist = $mysql->Query('SELECT * FROM sas_home_notes ORDER BY id DESC LIMIT 75');
}

$noteres = $mysql->Query('SELECT * FROM sas_home_notes ORDER BY id DESC LIMIT 1');

if (isset($_POST['chkver'])) {
    $vercheck = checkVersion();
    if ($vercheck && is_bool($vercheck))
        $chkver = '<span class="aktiv">aktuell</span>';
    elseif (!$vercheck)
        $chkver = '<span class="inaktiv">nicht aktuell</span>';
    elseif ($vercheck == "err")
        $chkver = '<span class="notaviable">keine Information</span>';
    else
        $chkver = '<span class="notaviable">keine Information</span>';
}

?>

<h3>Serverübersicht</h3>
<fieldset>
    <legend>Aktuelle Daten ihres Servers</legend>
    <div class="halbe-box">
        <table>
            <tr>
                <td>Host-IP:</td>
                <td><a href="http://<?php echo $server->getAddress(); ?>" target="_blank"><?php echo $server->getAddress(); ?></a></td>
            </tr>
            <tr class="odd">
                <td>Host-Name:</td>
                <td><?php echo $hostname; ?></td>
            </tr>
            <tr>
                <td>Kernel Version:</td>
                <td>
                    <a href="#" class="tooltip3">Kernel
                        <span><code class="simple"><?= $kernelversion; ?></code></span>
                    </a>
                </td>
            </tr>
            <tr class="odd">
                <td>Server online seit:</td>
                <td id="uptime"> <noscript> <?php echo $serveruptime; ?></noscript> </td>
            </tr>
            <script>
                var sek=<?php echo $sekunden; ?>;
                function upservtime() {
                    var uppy = ((((((((sek - (sek % 60)) / 60) - ((sek - (sek % 60)) / 60) % 60) / 60))) - ((((((sek - (sek % 60)) / 60) - ((sek - (sek % 60)) / 60) % 60) / 60)) % 24)) / 24) + " T " + ((((((sek - (sek % 60)) / 60) - ((sek - (sek % 60)) / 60) % 60) / 60)) % 24) + " Std " + (((sek - (sek % 60)) / 60) % 60) + " Min " + (sek % 60) + " Sek ";
                    document.getElementById('uptime').innerHTML = uppy;  
                    window.setTimeout("upservtime()",1000); 
                    sek++;
                }
                upservtime(); <?php // aktualisiert die Uptime ständig neu.  ?>
            </script>    
            <tr>
                <td>Systemstart:</td>
                <td><?php echo date("d.m.Y - H:i", strtotime($bootdate)) . " Uhr"; ?></td>
            </tr>
            <tr class="odd">
                <td>Eingeloggte User:</td>
                <td><?php echo $userswholi ?></td>
            </tr>
            <tr>
                <td>Load:  <a href="#" class="tooltip"><i class="icon-help-circled"></i>
                        <span><b>Was ist das?</b><br>
                            1. Wert: letzte Minute<br>
                            2. Wert: letzten 5 Min.<br>
                            3. Wert: letzte 15 Min.
                        </span></a>
                </td>
                <td><?php echo $serverload; ?></td>
            </tr>
        </table>
        <br>
        <a href="<?php $_SERVER['SCRIPT_NAME'] ?>" onclick="location.reload();" class="button white"><i class="icon-arrows-ccw"></i> Aktualisieren</a>
    </div>
    <div class="halbe-box lastbox">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td>Apache 2:</td>
                <td>
<?php
echo $service['apache'] ? '<span class="aktiv">aktiv</span>' : '<span class="inaktiv">inaktiv</span>';
?>
                </td>
            </tr>
            <tr>
                <td>FTP:</td>
                <td>
                    <?php
                    echo $service['ftp'] ? '<span class="aktiv">aktiv</span>' : '<span class="inaktiv">inaktiv</span>';
                    ?>
                </td>
            </tr>
            <tr class="odd">
                <td>MySQL:</td>
                <td>
                    <?php
                    echo $service['mysql'] ? '<span class="aktiv">aktiv</span>' : '<span class="inaktiv">inaktiv</span>';
                    ?>
                </td>
            </tr>
            <tr>
                <td>Samba:</td>
                <td>
                    <?php
                    echo $service['samba'] ? '<span class="aktiv">aktiv</span>' : '<span class="inaktiv">inaktiv</span>';
                    ?>
                </td>
            </tr>
            <tr class="odd">
                <td>Daemon:</td>
                <td>
                    <span class="notaviable">keine Information</span>
                </td>
            </tr>
            <tr style="height:50px;">
                <td>SAS-Version:</td>
                <td>
                    <?php
                    if (isset($_POST['chkver'])) {
                        echo $chkver;                    
                    } else {
                    ?>
                    <form action="index.php?p=home" method="post">
                        <input type="submit" name="chkver" value="Version prüfen" class="button grey">
                    </form>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
    <br><br>
</fieldset>
<? if (isset($_GET['success']) && isset($_POST['notiz'])): ?>
    <span class="success">Die Notiz wurde erfolgreich gespeichert.</span><br>
<? endif; ?>
<fieldset id='notelist'>
    <legend>Notizbuch</legend>
    <form action="index.php?p=home&success#notelist" method="POST">
<?php while ($row = $noteres->fetchObject()): ?>
            <textarea name="notizen"><?= $row->note ?></textarea>
            <input type="submit" class="button black" name="notiz" value="Notizen speichern">
            <br><br>
            <span>
                Gespeichert um:
                <br>
                <b><?= date("d.m.Y H:i:s", strtotime($row->notetime)) ?></b> von <b><?= $row->author ?></b>
                <br>
                <br>
                <i class="icon-archive"></i> <input type="submit" name="oldnc" value="ältere Notizen anzeigen" class="invs">
            </span>
<?php endwhile; ?>
    </form>
<?php
if (isset($notereslist)) {
    echo "<div class='clearfix'></div><br><ul class='log' stlye='color:#222;'>";
    while ($row = $notereslist->fetchObject()) {
        echo "<li><b>[" . date("d.m.Y H:i:s", strtotime($row->notetime)) . " von " . $row->author . "]</b> " . $row->note . "</li>";
    }
    echo "</ul>";
}
?>
</fieldset>